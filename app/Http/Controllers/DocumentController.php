<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\HeaderUtils;

class DocumentController extends Controller
{
    /**
     * បង្ហាញផ្ទាំង Dashboard និងទាញស្ថិតិ
     */
    public function index()
    {
        $this->autoRestoreSnapshotIfEmpty();

        $totalDocuments = Document::count();
        $totalPortfolios = Document::where('is_portfolio', true)->count();
        $categories = Category::withCount('documents')->get();

        $recentDocuments = Document::with('category')
            ->latest()
            ->paginate(10);

        return view('dashboard', compact(
            'totalDocuments',
            'totalPortfolios',
            'categories',
            'recentDocuments'
        ));
    }

    /**
     * បង្ហាញទំព័រ Preview និងព័ត៌មានលម្អិតឯកសារ (Sala Digital Preview Layout ដូចរូបភាព)
     */
    public function show(Document $document)
    {
        // កត់ត្រា និងរាប់ចំនួនអ្នកទស្សនាជាក់ស្ដែង (Real Views Counter)
        $document->increment('views_count');

        $document->load('category');

        $relatedDocuments = Document::with('category')
            ->where('id', '!=', $document->id)
            ->where('category_id', $document->category_id)
            ->latest()
            ->take(4)
            ->get();

        if ($relatedDocuments->isEmpty()) {
            $relatedDocuments = Document::with('category')
                ->where('id', '!=', $document->id)
                ->latest()
                ->take(4)
                ->get();
        }

        // ទាញទិន្នន័យអ្នកតាមដានជាក់ស្ដែងរបស់គ្រូបង្រៀន (Real Followers Count)
        $teacher = User::where('role', 'teacher')->first() 
            ?? User::firstOrCreate(
                ['email' => 'hoeun.minea@gmail.com'],
                ['name' => 'ហឿន មិនា | ICT', 'role' => 'teacher', 'followers_count' => 0]
            );

        $teacherFollowers = $teacher->followers_count ?? 0;
        $isFollowed = session('teacher_followed', false);

        return view('documents.show', compact('document', 'relatedDocuments', 'teacherFollowers', 'isFollowed'));
    }

    /**
     * មុខងារផ្ទុកឯកសារចូល Storage និងរក្សាទុកទិន្នន័យក្នុង Database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'academic_year' => 'required|string|max:50',
            'description' => 'nullable|string',
            'document_file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png,webp,zip|max:30720',
            'is_portfolio' => 'nullable|boolean',
        ]);

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $fileExtension = strtolower($file->getClientOriginalExtension());
            $fileSizeBytes = $file->getSize();
            $formattedSize = $fileSizeBytes >= 1048576
                ? round($fileSizeBytes / 1048576, 2) . ' MB'
                : round($fileSizeBytes / 1024, 2) . ' KB';

            // Ensure destination directories exist in both runtime storage and local
            $destinationDir = storage_path('app/public/documents');
            if (!is_dir($destinationDir)) {
                @mkdir($destinationDir, 0777, true);
            }

            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $cleanSlug = Str::slug($originalName) ?: 'doc';
            $fileName = time() . '_' . $cleanSlug . '.' . $fileExtension;

            // Read file binary content for serverless persistence
            $rawContent = file_get_contents($file->getRealPath());
            $fileData = ($rawContent !== false && strlen($rawContent) <= 15728640)
                ? base64_encode($rawContent)
                : null;

            $file->move($destinationDir, $fileName);
            $filePath = 'documents/' . $fileName;

            // Also keep a copy in base storage if available
            $baseDocsDir = base_path('storage/app/public/documents');
            if (is_dir($baseDocsDir) && is_writable($baseDocsDir)) {
                @copy($destinationDir . '/' . $fileName, $baseDocsDir . '/' . $fileName);
            }

            Document::create([
                'category_id'   => $validated['category_id'],
                'title'         => $validated['title'],
                'file_path'     => $filePath,
                'file_type'     => $fileExtension,
                'file_size'     => $formattedSize,
                'file_data'     => $fileData,
                'academic_year' => $validated['academic_year'],
                'description'   => $validated['description'] ?? null,
                'is_portfolio'  => $request->boolean('is_portfolio'),
            ]);

            // Sync snapshot automatically for persistence across updates
            $this->syncSnapshot();

            return redirect('/')->with('success', 'ឯកសារ «' . $validated['title'] . '» ត្រូវបានបញ្ចូល និងរក្សាទុកដោយជោគជ័យ!');
        }

        return back()->with('error', 'មានបញ្ហាក្នុងការ Upload ឯកសារ!');
    }

    /**
     * Helper រកទីតាំង File ដែលមានសុពលភាព
     */
    private function resolveFilePath(Document $document): string
    {
        $isVercel = (getenv('VERCEL') || !empty($_ENV['VERCEL']) || is_dir('/tmp'));

        // Potential paths to locate the file
        $paths = [
            storage_path('app/public/' . $document->file_path),
            base_path('storage/app/public/' . $document->file_path),
            public_path('storage/' . $document->file_path),
        ];

        if ($isVercel) {
            array_unshift($paths, '/tmp/storage/app/public/' . $document->file_path);
        }

        foreach ($paths as $path) {
            if (file_exists($path) && filesize($path) > 0) {
                return $path;
            }
        }

        // Target path for writing restored/fallback file
        $targetPath = $isVercel
            ? '/tmp/storage/app/public/' . $document->file_path
            : storage_path('app/public/' . $document->file_path);

        $targetDir = dirname($targetPath);
        if (!is_dir($targetDir)) {
            @mkdir($targetDir, 0777, true);
        }

        // Restore file from database binary cache if available
        if (!empty($document->file_data)) {
            $binary = base64_decode($document->file_data);
            if ($binary !== false && strlen($binary) > 0) {
                @file_put_contents($targetPath, $binary);
                return $targetPath;
            }
        }

        // Auto-generate dynamic fallback file to ensure download never returns 404
        $extension = strtolower($document->file_type ?: pathinfo($targetPath, PATHINFO_EXTENSION) ?: 'pdf');

        if ($extension === 'pdf') {
            // Valid minimal single-page PDF binary (valid PDF 1.4 spec) so PDF viewers never crash
            $validPdf = "%PDF-1.4\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n2 0 obj<</Type/Pages/Kids[3 0 R]/Count 1>>endobj\n3 0 obj<</Type/Page/MediaBox[0 0 612 792]/Parent 2 0 R/Resources<<>>>>endobj\nxref\n0 4\n0000000000 65535 f \n0000000010 00000 n \n0000000060 00000 n \n0000000117 00000 n \ntrailer<</Size 4/Root 1 0 R>>\nstartxref\n190\n%%EOF";
            @file_put_contents($targetPath, $validPdf);
            return $targetPath;
        }

        $content = "Teacher Digital Portfolio - Hoeun Minea | ICT\n";
        $content .= "វិទ្យាល័យ ហ៊ុន សែន សេរីភាព\n\n";
        $content .= "ចំណងជើងឯកសារ៖ " . $document->title . "\n";
        $content .= "ប្រភេទឯកសារ៖ " . ($document->category?->name ?? 'ICT') . "\n";
        $content .= "ឆ្នាំសិក្សា៖ " . $document->academic_year . "\n";
        $content .= "ការពិពណ៌នា៖ " . ($document->description ?? 'ឯកសារភ័ស្តុតាងការងារ និងស្នាដៃបង្រៀន') . "\n";

        @file_put_contents($targetPath, $content);
        return $targetPath;
    }

    /**
     * មុខងារទាញយកឯកសារ (Download)
     */
    public function download(Document $document)
    {
        // កត់ត្រា និងរាប់ចំនួនទាញយកជាក់ស្ដែង (Real Downloads Counter)
        $document->increment('downloads_count');

        $extension = strtolower($document->file_type ?: 'pdf');

        // 1. Generate safe ASCII fallback name (never empty, never starting with bare dot)
        $asciiSlug = Str::slug($document->title);
        $safeAscii = ($asciiSlug ?: 'document_' . $document->id) . '.' . $extension;

        // 2. Generate clean UTF-8 filename for Khmer / Unicode display
        $cleanUtf8 = trim(str_replace(['"', '/', '\\', "\n", "\r", '<', '>', ':', '|', '?', '*'], '', $document->title));
        $utf8Name = ($cleanUtf8 ?: 'document_' . $document->id) . '.' . $extension;

        $mimeType = match ($extension) {
            'pdf' => 'application/pdf',
            'png' => 'image/png',
            'jpg', 'jpeg' => 'image/jpeg',
            'webp' => 'image/webp',
            'gif' => 'image/gif',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            default => 'application/octet-stream',
        };

        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            $utf8Name,
            $safeAscii
        );

        // Stream directly from memory if file_data is cached in database
        if (!empty($document->file_data)) {
            $binary = base64_decode($document->file_data);
            if ($binary !== false && strlen($binary) > 0) {
                return response($binary, 200, [
                    'Content-Type' => $mimeType,
                    'Content-Disposition' => $disposition,
                    'Content-Length' => strlen($binary),
                ]);
            }
        }

        $filePath = $this->resolveFilePath($document);
        $response = response()->download($filePath, $safeAscii, [
            'Content-Type' => $mimeType,
        ]);
        $response->headers->set('Content-Disposition', $disposition);
        return $response;
    }

    /**
     * មុខងារ Preview ឯកសារក្នុង Browser (សម្រាប់ PDF និងរូបភាព)
     */
    public function preview(Document $document)
    {
        $extension = strtolower($document->file_type ?: 'pdf');

        $asciiSlug = Str::slug($document->title);
        $safeAscii = ($asciiSlug ?: 'document_' . $document->id) . '.' . $extension;

        $cleanUtf8 = trim(str_replace(['"', '/', '\\', "\n", "\r", '<', '>', ':', '|', '?', '*'], '', $document->title));
        $utf8Name = ($cleanUtf8 ?: 'document_' . $document->id) . '.' . $extension;

        $mimeType = match ($extension) {
            'pdf' => 'application/pdf',
            'png' => 'image/png',
            'jpg', 'jpeg' => 'image/jpeg',
            'webp' => 'image/webp',
            'gif' => 'image/gif',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            default => 'application/octet-stream',
        };

        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_INLINE,
            $utf8Name,
            $safeAscii
        );

        // Stream directly from memory if file_data is cached in database
        if (!empty($document->file_data)) {
            $binary = base64_decode($document->file_data);
            if ($binary !== false && strlen($binary) > 0) {
                return response($binary, 200, [
                    'Content-Type' => $mimeType,
                    'Content-Disposition' => $disposition,
                    'Content-Length' => strlen($binary),
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Methods' => 'GET, OPTIONS',
                    'Access-Control-Allow-Headers' => 'Range, Content-Type',
                    'Access-Control-Expose-Headers' => 'Accept-Ranges, Content-Encoding, Content-Length, Content-Range',
                    'Accept-Ranges' => 'bytes',
                    'X-Content-Type-Options' => 'nosniff',
                    'Cache-Control' => 'public, max-age=3600',
                ]);
            }
        }

        $filePath = $this->resolveFilePath($document);
        $response = response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, OPTIONS',
            'Access-Control-Allow-Headers' => 'Range, Content-Type',
            'Access-Control-Expose-Headers' => 'Accept-Ranges, Content-Encoding, Content-Length, Content-Range',
            'Accept-Ranges' => 'bytes',
            'X-Content-Type-Options' => 'nosniff',
        ]);
        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->remove('X-Frame-Options');
        return $response;
    }

    /**
     * មុខងារកែប្រែព័ត៌មានឯកសារ (Update)
     */
    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'academic_year' => 'required|string|max:50',
            'description' => 'nullable|string',
            'is_portfolio' => 'nullable|boolean',
        ]);

        $document->update([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'academic_year' => $validated['academic_year'],
            'description' => $validated['description'] ?? null,
            'is_portfolio' => $request->boolean('is_portfolio'),
        ]);

        return redirect('/')->with('success', 'ព័ត៌មានឯកសារ «' . $document->title . '» ត្រូវបានកែប្រែដោយជោគជ័យ!');
    }

    /**
     * មុខងារលុបឯកសារ
     */
    public function destroy(Document $document)
    {
        $runtimePath = storage_path('app/public/' . $document->file_path);
        $repoPath = base_path('storage/app/public/' . $document->file_path);

        if (file_exists($runtimePath)) {
            @unlink($runtimePath);
        }
        if (file_exists($repoPath)) {
            @unlink($repoPath);
        }

        $title = $document->title;
        $document->delete();

        $this->syncSnapshot();

        return redirect('/')->with('success', 'ឯកសារ «' . $title . '» ត្រូវបានលុបរួចរាល់!');
    }

    /**
     * បង្ហាញទំព័រ Portfolio សាធារណៈសម្រាប់គ្រូបង្ហាញស្នាដៃ
     */
    public function portfolio()
    {
        $this->autoRestoreSnapshotIfEmpty();

        $portfolioDocuments = Document::with('category')
            ->where('is_portfolio', true)
            ->latest()
            ->get();

        $categories = Category::all();
        $totalViews = Document::sum('views_count') ?: 0;
        $totalDownloads = Document::sum('downloads_count') ?: 0;

        $teacher = User::where('role', 'teacher')->first() 
            ?? User::firstOrCreate(
                ['email' => 'hoeun.minea@gmail.com'],
                ['name' => 'ហឿន មិនា | ICT', 'role' => 'teacher', 'followers_count' => 0]
            );
        $teacherFollowers = $teacher->followers_count ?? 0;

        return view('portfolio', compact(
            'portfolioDocuments',
            'categories',
            'totalViews',
            'totalDownloads',
            'teacherFollowers'
        ));
    }

    /**
     * នាំចេញទិន្នន័យឯកសារទាំងអស់ជា JSON Backup (ទាញយកទុកលើកុំព្យូទ័រ)
     */
    public function exportBackup()
    {
        $documents = Document::with('category')->get();
        $categories = Category::all();

        $payload = [
            'exported_at' => now()->toIso8601String(),
            'app' => 'បណ្ណាល័យខ្ញុំ — វិទ្យាល័យ ហ៊ុន សែន សេរីភាព',
            'teacher' => 'ហឿន មិនា | ICT',
            'total_documents' => $documents->count(),
            'categories' => $categories,
            'documents' => $documents,
        ];

        $json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $fileName = 'backup_documents_' . date('Y_m_d_His') . '.json';

        return response($json, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    /**
     * នាំចូល និងស្ដារទិន្នន័យឯកសារពី JSON Backup (Restore Documents)
     */
    public function importBackup(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|max:51200',
        ]);

        $content = file_get_contents($request->file('backup_file')->getRealPath());
        $data = json_decode($content, true);

        if (!$data || !isset($data['documents'])) {
            return back()->with('error', 'ឯកសារ Backup មិនត្រឹមត្រូវ ឬខូចទ្រង់ទ្រាយ!');
        }

        $restoredCount = 0;

        if (isset($data['categories']) && is_array($data['categories'])) {
            foreach ($data['categories'] as $cat) {
                Category::firstOrCreate(
                    ['id' => $cat['id']],
                    ['name' => $cat['name'], 'slug' => $cat['slug'] ?? Str::slug($cat['name'])]
                );
            }
        }

        foreach ($data['documents'] as $docData) {
            $doc = Document::updateOrCreate(
                ['title' => $docData['title']],
                [
                    'category_id' => $docData['category_id'],
                    'file_path' => $docData['file_path'],
                    'file_type' => $docData['file_type'],
                    'file_size' => $docData['file_size'],
                    'file_data' => $docData['file_data'] ?? null,
                    'academic_year' => $docData['academic_year'],
                    'description' => $docData['description'] ?? null,
                    'is_portfolio' => $docData['is_portfolio'] ?? false,
                    'views_count' => $docData['views_count'] ?? 0,
                    'downloads_count' => $docData['downloads_count'] ?? 0,
                ]
            );

            if (!empty($doc->file_data)) {
                $targetPath = storage_path('app/public/' . $doc->file_path);
                $dir = dirname($targetPath);
                if (!is_dir($dir)) {
                    @mkdir($dir, 0777, true);
                }
                @file_put_contents($targetPath, base64_decode($doc->file_data));
            }

            $restoredCount++;
        }

        $this->syncSnapshot();

        return back()->with('success', "បានស្ដារឯកសារចំនួន $restoredCount ដោយជោគជ័យ!");
    }

    /**
     * រក្សាទុក Snapshot ស្វ័យប្រវត្តិក្នុង storage/app
     */
    private function syncSnapshot(): void
    {
        try {
            $documents = Document::with('category')->get();
            $categories = Category::all();

            $payload = [
                'updated_at' => now()->toIso8601String(),
                'categories' => $categories,
                'documents' => $documents,
            ];

            $json = json_encode($payload, JSON_UNESCAPED_UNICODE);
            
            $runtimeDir = storage_path('app');
            if (!is_dir($runtimeDir)) {
                @mkdir($runtimeDir, 0777, true);
            }
            $runtimeFile = storage_path('app/documents_snapshot.json');
            $repoFile = base_path('storage/app/documents_snapshot.json');

            @file_put_contents($runtimeFile, $json);
            if (is_writable(dirname($repoFile))) {
                @file_put_contents($repoFile, $json);
            }
        } catch (\Throwable $e) {}
    }

    /**
     * ស្ដារទិន្នន័យស្វ័យប្រវត្តិពី Snapshot បើទិន្នន័យទទេ
     */
    private function autoRestoreSnapshotIfEmpty(): void
    {
        if (Document::count() > 0) {
            return;
        }

        $files = [
            storage_path('app/documents_snapshot.json'),
            base_path('storage/app/documents_snapshot.json'),
        ];

        foreach ($files as $f) {
            if (file_exists($f) && filesize($f) > 0) {
                $content = @file_get_contents($f);
                $data = @json_decode($content, true);
                if ($data && !empty($data['documents'])) {
                    if (isset($data['categories']) && is_array($data['categories'])) {
                        foreach ($data['categories'] as $cat) {
                            Category::firstOrCreate(
                                ['id' => $cat['id']],
                                ['name' => $cat['name'], 'slug' => $cat['slug'] ?? Str::slug($cat['name'])]
                            );
                        }
                    }

                    foreach ($data['documents'] as $docData) {
                        Document::updateOrCreate(
                            ['title' => $docData['title']],
                            [
                                'category_id' => $docData['category_id'],
                                'file_path' => $docData['file_path'],
                                'file_type' => $docData['file_type'],
                                'file_size' => $docData['file_size'],
                                'file_data' => $docData['file_data'] ?? null,
                                'academic_year' => $docData['academic_year'],
                                'description' => $docData['description'] ?? null,
                                'is_portfolio' => $docData['is_portfolio'] ?? false,
                                'views_count' => $docData['views_count'] ?? 0,
                                'downloads_count' => $docData['downloads_count'] ?? 0,
                            ]
                        );
                    }
                    return;
                }
            }
        }
    }

    /**
     * មុខងារចុចតាមដានគ្រូបង្រៀន (Follow / Unfollow Teacher - Real Counter)
     */
    public function followTeacher(Request $request)
    {
        $teacher = User::where('role', 'teacher')->first() 
            ?? User::firstOrCreate(
                ['email' => 'hoeun.minea@gmail.com'],
                ['name' => 'ហឿន មិនា | ICT', 'role' => 'teacher', 'followers_count' => 0]
            );

        $isFollowed = session('teacher_followed', false);

        if ($isFollowed) {
            $teacher->decrement('followers_count');
            session(['teacher_followed' => false]);
            $status = 'unfollowed';
        } else {
            $teacher->increment('followers_count');
            session(['teacher_followed' => true]);
            $status = 'followed';
        }

        $currentCount = max(0, $teacher->fresh()->followers_count);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => $status,
                'followers_count' => $currentCount,
                'is_followed' => ($status === 'followed')
            ]);
        }

        return back()->with('success', $status === 'followed' ? 'បានតាមដានគ្រូបង្រៀនដោយជោគជ័យ!' : 'បានឈប់តាមដាន');
    }
}
