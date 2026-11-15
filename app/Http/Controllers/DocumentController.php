<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'document_file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png|max:20480', // ទំហំអតិបរមា 20MB
            'is_portfolio' => 'nullable|boolean',
        ]);

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');

            // រៀបចំកន្ទុយ File និងទំហំ (KB ឬ MB)
            $fileExtension = $file->getClientOriginalExtension();
            $fileSizeBytes = $file->getSize();
            $formattedSize = $fileSizeBytes >= 1048576
                ? round($fileSizeBytes / 1048576, 2) . ' MB'
                : round($fileSizeBytes / 1024, 2) . ' KB';

            // រក្សាទុកក្នុង storage/app/public/documents
            $filePath = $file->store('documents', 'public');

            // បញ្ចូលទៅក្នុង Database
            Document::create([
                'category_id'   => $validated['category_id'],
                'title'         => $validated['title'],
                'file_path'     => $filePath,
                'file_type'     => strtolower($fileExtension),
                'file_size'     => $formattedSize,
                'academic_year' => $validated['academic_year'],
                'description'   => $validated['description'] ?? null,
                'is_portfolio'  => $request->boolean('is_portfolio'),
            ]);

            return redirect()->route('dashboard')->with('success', 'ឯកសារត្រូវបានបញ្ចូលដោយជោគជ័យ!');
        }

        return back()->with('error', 'មានបញ្ហាក្នុងការ Upload ឯកសារ!');
    }

    /**
     * មុខងារទាញយកឯកសារ (Download)
     */
    public function download(Document $document)
    {
        if (!Storage::disk('public')->exists($document->file_path)) {
            return back()->with('error', 'រកមិនឃើញឯកសារក្នុង Server ទេ!');
        }

        return Storage::disk('public')->download($document->file_path, $document->title . '.' . $document->file_type);
    }

    /**
     * មុខងារលុបឯកសារ
     */
    public function destroy(Document $document)
    {
        // លុប File ចេញពី Storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        // លុបទិន្នន័យពី Database
        $document->delete();

        return redirect()->route('dashboard')->with('success', 'ឯកសារត្រូវបានលុបរួចរាល់!');
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
