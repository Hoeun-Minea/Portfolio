<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    /**
     * បង្ហាញផ្ទាំង Dashboard និងទាញស្ថិតិ
     */
    public function index()
    {
        // គណនាស្ថិតិសរុប
        $totalDocuments = Document::count();
        $totalPortfolios = Document::where('is_portfolio', true)->count();

        // ស្ថិតិចំនួនឯកសារតាមប្រភេទនីមួយៗ
        $categories = Category::withCount('documents')->get();

        // ទាញយកឯកសារថ្មីៗ
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
     * មុខងារផ្ទុកឯកសារចូល Storage និងរក្សាទុកទិន្នន័យក្នុង Database
     */
    public function store(Request $request)
    {
        // ផ្ទៀងផ្ទាត់សុពលភាពនៃទិន្នន័យ (Validation)
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'academic_year' => 'required|string|max:50',
            'description' => 'nullable|string',
            'document_file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png,webp,zip|max:30720', // អតិបរមា 30MB
            'is_portfolio' => 'nullable|boolean',
        ]);

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');

            // រៀបចំកន្ទុយ File និងទំហំ (KB ឬ MB)
            $fileExtension = strtolower($file->getClientOriginalExtension());
            $fileSizeBytes = $file->getSize();
            $formattedSize = $fileSizeBytes >= 1048576
                ? round($fileSizeBytes / 1048576, 2) . ' MB'
                : round($fileSizeBytes / 1024, 2) . ' KB';

            // រៀបចំថត Folder សម្រាប់ផ្ទុក
            $destinationDir = storage_path('app/public/documents');
            if (!is_dir($destinationDir)) {
                @mkdir($destinationDir, 0777, true);
            }

            // បង្កើតឈ្មោះ File ស្អាត និងមានសុវត្ថិភាព
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $cleanSlug = Str::slug($originalName) ?: 'document';
            $fileName = time() . '_' . $cleanSlug . '.' . $fileExtension;

            // រក្សាទុក File ចូលទីតាំង
            $file->move($destinationDir, $fileName);
            $filePath = 'documents/' . $fileName;

            // បញ្ចូលទៅក្នុង Database
            Document::create([
                'category_id'   => $validated['category_id'],
                'title'         => $validated['title'],
                'file_path'     => $filePath,
                'file_type'     => $fileExtension,
                'file_size'     => $formattedSize,
                'academic_year' => $validated['academic_year'],
                'description'   => $validated['description'] ?? null,
                'is_portfolio'  => $request->boolean('is_portfolio'),
            ]);

            return redirect()->route('dashboard')->with('success', 'ឯកសារ «' . $validated['title'] . '» ត្រូវបានបញ្ចូល និងរក្សាទុកដោយជោគជ័យ!');
        }

        return back()->with('error', 'មានបញ្ហាក្នុងការ Upload ឯកសារ!');
    }

    /**
     * មុខងារទាញយកឯកសារ (Download)
     */
    public function download(Document $document)
    {
        $fullPath = storage_path('app/public/' . $document->file_path);

        if (!file_exists($fullPath)) {
            // Check fallback in default storage
            if (Storage::disk('public')->exists($document->file_path)) {
                return Storage::disk('public')->download($document->file_path, $document->title . '.' . $document->file_type);
            }
            return back()->with('error', 'រកមិនឃើញឯកសារក្នុង Server ទេ!');
        }

        return response()->download($fullPath, $document->title . '.' . $document->file_type);
    }

    /**
     * មុខងារ Preview ឯកសារក្នុង Browser (សម្រាប់ PDF និងរូបភាព)
     */
    public function preview(Document $document)
    {
        $fullPath = storage_path('app/public/' . $document->file_path);

        if (!file_exists($fullPath)) {
            return back()->with('error', 'រកមិនឃើញឯកសារសម្រាប់ Preview ទេ!');
        }

        $mimeType = mime_content_type($fullPath) ?: 'application/octet-stream';

        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $document->title . '.' . $document->file_type . '"',
        ]);
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

        return redirect()->route('dashboard')->with('success', 'ព័ត៌មានឯកសារ «' . $document->title . '» ត្រូវបានកែប្រែដោយជោគជ័យ!');
    }

    /**
     * មុខងារលុបឯកសារ
     */
    public function destroy(Document $document)
    {
        $fullPath = storage_path('app/public/' . $document->file_path);

        // លុប File ចេញពី Server
        if (file_exists($fullPath)) {
            @unlink($fullPath);
        }

        // លុបទិន្នន័យពី Database
        $title = $document->title;
        $document->delete();

        return redirect()->route('dashboard')->with('success', 'ឯកសារ «' . $title . '» ត្រូវបានលុបរួចរាល់!');
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
