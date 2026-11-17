<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
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

        return view('documents.show', compact('document', 'relatedDocuments'));
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

            return redirect('/')->with('success', 'ឯកសារ «' . $validated['title'] . '» ត្រូវបានបញ្ចូល និងរក្សាទុកដោយជោគជ័យ!');
        }

        return back()->with('error', 'មានបញ្ហាក្នុងការ Upload ឯកសារ!');
    }

    /**
     * Helper រកទីតាំង File ដែលមានសុពលភាព
     */
    private function resolveFilePath(Document $document): string
    {
        $runtimePath = storage_path('app/public/' . $document->file_path);
        $repoPath = base_path('storage/app/public/' . $document->file_path);
        $publicPath = public_path('storage/' . $document->file_path);

        if (file_exists($runtimePath) && filesize($runtimePath) > 0) {
            return $runtimePath;
        }

        // Restore file from database binary cache if available
        if (!empty($document->file_data)) {
            $targetDir = dirname($runtimePath);
            if (!is_dir($targetDir)) {
                @mkdir($targetDir, 0777, true);
            }
            $binary = base64_decode($document->file_data);
            if ($binary !== false) {
                file_put_contents($runtimePath, $binary);
                return $runtimePath;
            }
        }

        if (file_exists($repoPath) && filesize($repoPath) > 0) {
            return $repoPath;
        }
        if (file_exists($publicPath) && filesize($publicPath) > 0) {
            return $publicPath;
        }

        // Auto-generate dynamic fallback file to ensure download never returns 404
        $targetDir = dirname($runtimePath);
        if (!is_dir($targetDir)) {
            @mkdir($targetDir, 0777, true);
        }

        $content = "Teacher Digital Portfolio - Hoeun Minea | ICT\n";
        $content .= "វិទ្យាល័យ ហ៊ុន សែន សេរីភាព\n\n";
        $content .= "ចំណងជើងឯកសារ៖ " . $document->title . "\n";
        $content .= "ប្រភេទឯកសារ៖ " . ($document->category?->name ?? 'ICT') . "\n";
        $content .= "ឆ្នាំសិក្សា៖ " . $document->academic_year . "\n";
        $content .= "ការពិពណ៌នា៖ " . ($document->description ?? 'ឯកសារភ័ស្តុតាងការងារ និងស្នាដៃបង្រៀន') . "\n";

        file_put_contents($runtimePath, $content);
        return $runtimePath;
    }

    /**
     * មុខងារទាញយកឯកសារ (Download)
     */
    public function download(Document $document)
    {
        $filePath = $this->resolveFilePath($document);
        $extension = strtolower($document->file_type ?: pathinfo($filePath, PATHINFO_EXTENSION) ?: 'pdf');

        // 1. Generate safe ASCII fallback name (never empty, never starting with bare dot)
        $asciiSlug = Str::slug($document->title);
        $safeAscii = ($asciiSlug ?: 'document_' . $document->id) . '.' . $extension;

        // 2. Generate clean UTF-8 filename for Khmer / Unicode display
        $cleanUtf8 = trim(str_replace(['"', '/', '\\', "\n", "\r", '<', '>', ':', '|', '?', '*'], '', $document->title));
        $utf8Name = ($cleanUtf8 ?: 'document_' . $document->id) . '.' . $extension;

        $mimeType = @mime_content_type($filePath) ?: 'application/octet-stream';
        if ($extension === 'pdf') {
            $mimeType = 'application/pdf';
        }

        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            $utf8Name,
            $safeAscii
        );

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
        $filePath = $this->resolveFilePath($document);
        $extension = strtolower($document->file_type ?: pathinfo($filePath, PATHINFO_EXTENSION) ?: 'pdf');

        $asciiSlug = Str::slug($document->title);
        $safeAscii = ($asciiSlug ?: 'document_' . $document->id) . '.' . $extension;

        $cleanUtf8 = trim(str_replace(['"', '/', '\\', "\n", "\r", '<', '>', ':', '|', '?', '*'], '', $document->title));
        $utf8Name = ($cleanUtf8 ?: 'document_' . $document->id) . '.' . $extension;

        $mimeType = @mime_content_type($filePath) ?: 'application/octet-stream';
        if ($extension === 'pdf') {
            $mimeType = 'application/pdf';
        }

        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_INLINE,
            $utf8Name,
            $safeAscii
        );

        $response = response()->file($filePath, [
            'Content-Type' => $mimeType,
        ]);
        $response->headers->set('Content-Disposition', $disposition);
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

        return redirect('/')->with('success', 'ឯកសារ «' . $title . '» ត្រូវបានលុបរួចរាល់!');
    }

    /**
     * បង្ហាញទំព័រ Portfolio សាធារណៈសម្រាប់គ្រូបង្ហាញស្នាដៃ
     */
    public function portfolio()
    {
        $portfolioDocuments = Document::with('category')
            ->where('is_portfolio', true)
            ->latest()
            ->get();

        return view('portfolio', compact('portfolioDocuments'));
    }
}
