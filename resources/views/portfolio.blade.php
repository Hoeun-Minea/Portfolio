<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio ស្នាដៃ និងបទពិសោធន៍គ្រូបង្រៀន</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@300;400;500;600;700&family=Moul&family=Siemreap&display=swap" rel="stylesheet">
    <style>
        .font-khmer-muol { font-family: 'Khmer OS Muol Light', 'Moul', serif; }
        .font-khmer-siemreap { font-family: 'Khmer OS Siemreap', 'Siemreap', 'Kantumruy Pro', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 font-khmer-siemreap text-slate-800">

    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-blue-800 to-blue-600 text-white py-14 px-6 text-center shadow-md">
        <div class="max-w-4xl mx-auto">
            <div class="w-24 h-24 bg-white text-blue-700 rounded-full mx-auto flex items-center justify-center text-4xl shadow-lg border-4 border-blue-200 mb-4">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <h1 class="font-khmer-muol text-2xl md:text-3xl tracking-wide">PORTFOLIO ស្នាដៃ និងសមិទ្ធផលការងារ</h1>
            <p class="text-blue-100 mt-2 text-sm md:text-base">ឯកសារភ័ស្តុតាង កិច្ចតែងការគំរូ និងការអភិវឌ្ឍវិជ្ជាជីវៈបង្រៀន</p>
        </div>
    </div>

    <!-- Portfolio Content Section -->
    <div class="max-w-6xl mx-auto px-6 py-10">
        <div class="flex items-center justify-between mb-8">
            <h2 class="font-khmer-muol text-lg text-blue-950">ស្នាដៃដែលបានជ្រើសរើស ({{ $portfolioDocuments->count() }})</h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:underline">
                <i class="fa-solid fa-arrow-left mr-1"></i> ត្រឡប់ទៅផ្ទាំងគ្រប់គ្រង
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($portfolioDocuments as $item)
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition p-5 flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between gap-2">
                            <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded-md">
                                {{ $item->category->name }}
                            </span>
                            <span class="text-xs text-slate-400 font-medium">ឆ្នាំ {{ $item->academic_year }}</span>
                        </div>
                        <h3 class="font-bold text-slate-900 mt-3 text-base line-clamp-2">{{ $item->title }}</h3>
                        <p class="text-xs text-slate-500 mt-2 line-clamp-3">
                            {{ $item->description ?? 'មិនមានការពិពណ៌នាបន្ថែម' }}
                        </p>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs text-slate-400">
                            <i class="fa-solid fa-paperclip mr-1"></i> {{ strtoupper($item->file_type) }} ({{ $item->file_size }})
                        </span>
                        <a href="{{ route('documents.download', $item) }}" class="inline-flex items-center text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 px-3 py-1.5 rounded-lg shadow-sm transition">
                            <i class="fa-solid fa-download mr-1.5"></i> ទាញយក
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-slate-400">
                    <i class="fa-solid fa-folder-open text-5xl mb-3 text-slate-300 block"></i>
                    មិនទាន់មានឯកសារស្នាដៃដែលបានកំណត់បង្ហាញនៅឡើយទេ។
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>
