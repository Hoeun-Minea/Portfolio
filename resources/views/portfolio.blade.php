<!DOCTYPE html>
<html lang="km" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio ស្នាដៃ និងសមិទ្ធផលការងារ — ហឿន មិនា | ICT</title>

    <!-- Google Fonts: Kantumruy Pro, Moul, Siemreap -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Moul&family=Siemreap&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS with custom styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        muol: ['"Khmer OS Muol Light"', '"Khmer OS Muol"', 'Moul', 'serif'],
                        body: ['"Kantumruy Pro"', '"Khmer OS Siemreap"', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                            950: '#172554',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .font-khmer-muol {
            font-family: 'Khmer OS Muol Light', 'Khmer OS Muol', 'Moul', serif;
        }
        .font-khmer-body {
            font-family: 'Kantumruy Pro', 'Khmer OS Siemreap', 'Siemreap', sans-serif;
        }
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="min-h-full font-khmer-body text-slate-800 antialiased bg-slate-50 flex flex-col">

    <!-- Top Navigation Bar -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-30 no-print">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-slate-600 hover:text-primary-600 transition">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                <span>ត្រឡប់ទៅផ្ទាំងគ្រប់គ្រង</span>
            </a>

            <div class="flex items-center gap-2.5">
                <!-- Copy Link Button -->
                <button type="button" id="shareBtn" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
                    <i class="fa-solid fa-share-nodes text-xs"></i>
                    <span>ចែករំលែក Link</span>
                </button>

                <!-- Print Button -->
                <button type="button" onclick="window.print()" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-primary-50 text-primary-700 hover:bg-primary-100 border border-primary-200/60 text-xs font-semibold transition">
                    <i class="fa-solid fa-print text-xs"></i>
                    <span>បោះពុម្ព</span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Header / Profile Section: ហឿន មិនា | ICT -->
    <header class="relative bg-gradient-to-br from-slate-950 via-primary-950 to-primary-900 text-white overflow-hidden py-14 sm:py-20 px-4 sm:px-6">
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-primary-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute left-10 -bottom-20 w-96 h-96 bg-indigo-500/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-4xl mx-auto text-center relative z-10 space-y-4">
            
            <!-- Avatar / Photo -->
            <div class="relative inline-block mx-auto">
                <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-3xl bg-gradient-to-tr from-primary-600 via-primary-500 to-indigo-500 p-1 shadow-2xl mx-auto flex items-center justify-center">
                    <div class="w-full h-full bg-slate-900 rounded-[22px] flex items-center justify-center text-4xl text-primary-300 font-extrabold tracking-wider">
                        HM
                    </div>
                </div>
                <span class="absolute bottom-1 right-1 w-6 h-6 bg-emerald-500 border-4 border-slate-900 rounded-full" title="Active Teacher"></span>
            </div>

            <!-- Profile Info: ហឿន មិនា | ICT -->
            <div class="space-y-2">
                <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs text-primary-200 font-medium">
                    <i class="fa-solid fa-laptop-code text-amber-400"></i>
                    <span>គ្រប់គ្រង និងរៀបចំដោយ ហឿន មិនា | ICT</span>
                </div>
                <h1 class="font-khmer-muol text-2xl sm:text-3xl text-white tracking-wide">
                    លោកគ្រូ ហឿន មិនា (Hoeun Minea)
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 max-w-xl mx-auto leading-relaxed">
                    គ្រូបង្រៀនមុខវិជ្ជាព័ត៌មានវិទ្យា (ICT) • វិទ្យាល័យ ហ៊ុន សែន សេរីភាព
                </p>
                <p class="text-[11px] sm:text-xs text-slate-400 max-w-lg mx-auto italic">
                    «ប្តេជ្ញាលើកកម្ពស់គុណភាពអប់រំតាមបែបឌីជីថល តាមរយៈការបញ្ចូលបច្ចេកវិទ្យាព័ត៌មានវិទ្យាទៅក្នុងការបង្រៀន និងការអភិវឌ្ឍសមត្ថភាពសិស្ស»
                </p>
            </div>

            <!-- Badges -->
            <div class="flex flex-wrap items-center justify-center gap-3 pt-2 text-xs">
                <span class="px-3.5 py-1.5 rounded-xl bg-white/10 backdrop-blur-md border border-white/10 text-slate-200 flex items-center gap-1.5">
                    <i class="fa-solid fa-laptop-file text-primary-400"></i> គ្រូបង្រៀន ICT
                </span>
                <span class="px-3.5 py-1.5 rounded-xl bg-white/10 backdrop-blur-md border border-white/10 text-slate-200 flex items-center gap-1.5">
                    <i class="fa-solid fa-award text-amber-400"></i> ស្នាដៃ {{ $portfolioDocuments->count() }} ឯកសារ
                </span>
                <span class="px-3.5 py-1.5 rounded-xl bg-white/10 backdrop-blur-md border border-white/10 text-slate-200 flex items-center gap-1.5">
                    <i class="fa-solid fa-school text-emerald-400"></i> វិទ្យាល័យ ហ៊ុន សែន សេរីភាព
                </span>
            </div>

        </div>
    </header>

    <!-- Main Showcase Content -->
    <main class="flex-1 max-w-6xl w-full mx-auto px-4 sm:px-6 py-10 sm:py-12">
        
        <!-- Header Controls & Category Filter -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-200/80 mb-8">
            <div>
                <h2 class="font-khmer-muol text-xl text-slate-900">ស្នាដៃ និងសមិទ្ធផលការងារដែលបានជ្រើសរើស</h2>
                <p class="text-xs text-slate-500 mt-1">ភ័ស្តុតាងកិច្ចតែងការគំរូ ICT ស្លាយមេរៀន និងវិញ្ញាបនបត្រអភិវឌ្ឍវិជ្ជាជីវៈ</p>
            </div>

            <div class="text-xs font-semibold text-slate-600 bg-white px-3.5 py-2 rounded-xl border border-slate-200 shadow-sm self-start sm:self-auto">
                បង្ហាញ <span class="text-primary-600 font-bold">{{ $portfolioDocuments->count() }}</span> ឯកសារស្នាដៃ
            </div>
        </div>

        <!-- Portfolio Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($portfolioDocuments as $item)
                <div class="group bg-white rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-6 flex flex-col justify-between">
                    
                    <div class="space-y-4">
                        <!-- Top Metadata Row -->
                        <div class="flex items-center justify-between gap-2">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-primary-50 text-primary-700 border border-primary-100">
                                {{ $item->category->name }}
                            </span>
                            <span class="text-xs font-medium text-slate-400">
                                <i class="fa-regular fa-calendar mr-1"></i> {{ $item->academic_year }}
                            </span>
                        </div>

                        <!-- Card Title & Icon -->
                        <div class="flex items-start space-x-3 pt-1">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm border 
                                @if($item->file_type === 'pdf') bg-rose-50 border-rose-100 text-rose-600
                                @elseif(in_array($item->file_type, ['doc', 'docx'])) bg-blue-50 border-blue-100 text-blue-600
                                @elseif(in_array($item->file_type, ['ppt', 'pptx'])) bg-amber-50 border-amber-100 text-amber-600
                                @elseif(in_array($item->file_type, ['xls', 'xlsx'])) bg-emerald-50 border-emerald-100 text-emerald-600
                                @else bg-slate-50 border-slate-200 text-slate-500 @endif">
                                
                                @if($item->file_type === 'pdf')
                                    <i class="fa-solid fa-file-pdf text-lg"></i>
                                @elseif(in_array($item->file_type, ['doc', 'docx']))
                                    <i class="fa-solid fa-file-word text-lg"></i>
                                @elseif(in_array($item->file_type, ['ppt', 'pptx']))
                                    <i class="fa-solid fa-file-powerpoint text-lg"></i>
                                @elseif(in_array($item->file_type, ['xls', 'xlsx']))
                                    <i class="fa-solid fa-file-excel text-lg"></i>
                                @else
                                    <i class="fa-solid fa-file-lines text-lg"></i>
                                @endif
                            </div>

                            <div class="min-w-0">
                                <h3 class="font-bold text-slate-900 text-sm leading-snug line-clamp-2 group-hover:text-primary-600 transition">
                                    {{ $item->title }}
                                </h3>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                            {{ $item->description ?? 'មិនមានការពិពណ៌នាបន្ថែម' }}
                        </p>
                    </div>

                    <!-- Bottom Card Footer & Action Buttons -->
                    <div class="pt-4 mt-5 border-t border-slate-100 flex items-center justify-between gap-2">
                        <span class="text-[11px] font-mono text-slate-400">
                            {{ strtoupper($item->file_type) }} • {{ $item->file_size }}
                        </span>

                        <div class="flex items-center gap-1.5">
                            @if(in_array($item->file_type, ['pdf', 'jpg', 'jpeg', 'png', 'webp']))
                                <a href="{{ route('documents.preview', $item) }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-semibold transition" title="មើលផ្ទាល់">
                                    <i class="fa-solid fa-eye text-[11px]"></i>
                                    <span>មើល</span>
                                </a>
                            @endif

                            <a href="{{ route('documents.download', $item) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-primary-600 hover:bg-primary-700 active:scale-95 text-white text-xs font-semibold shadow-sm transition">
                                <i class="fa-solid fa-download text-[11px]"></i>
                                <span>ទាញយក</span>
                            </a>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-full py-16 text-center text-slate-400 bg-white rounded-3xl border border-dashed border-slate-200">
                    <div class="w-16 h-16 rounded-2xl bg-slate-50 text-slate-300 mx-auto flex items-center justify-center text-3xl mb-3">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <h4 class="font-khmer-muol text-base text-slate-700 mb-1">មិនទាន់មានឯកសារស្នាដៃនៅឡើយទេ</h4>
                    <p class="text-xs text-slate-400 max-w-sm mx-auto mb-4">
                        សូមចូលទៅកាន់ផ្ទាំងគ្រប់គ្រង ហើយជ្រើសរើសគ្រីសយក "ឯកសារស្នាដៃ (Portfolio)" នៅពេល Upload ឯកសារ។
                    </p>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white text-xs font-semibold rounded-xl hover:bg-primary-700 transition">
                        <i class="fa-solid fa-arrow-left"></i> ត្រឡប់ទៅផ្ទាំងគ្រប់គ្រង
                    </a>
                </div>
            @endforelse
        </div>

    </main>

    <!-- Footer: គ្រប់គ្រង និងរៀបចំដោយ ហឿន មិនា | ICT -->
    <footer class="py-8 px-6 border-t border-slate-200 text-center text-xs text-slate-400 bg-white no-print space-y-1">
        <p class="font-medium text-slate-600">Portfolio ឌីជីថលផ្ទាល់ខ្លួន — គ្រប់គ្រង និងរៀបចំដោយ <strong>ហឿន មិនា | ICT</strong></p>
        <p>វិទ្យាល័យ ហ៊ុន សែន សេរីភាព &copy; {{ date('Y') }} — រក្សាសិទ្ធិគ្រប់យ៉ាង</p>
    </footer>

    <!-- Copy Link Notification Toast -->
    <div id="toast" class="fixed bottom-6 right-6 z-50 transform translate-y-20 opacity-0 transition-all duration-300 bg-slate-900 text-white px-4 py-3 rounded-2xl shadow-xl flex items-center space-x-2 text-xs font-medium">
        <i class="fa-solid fa-circle-check text-emerald-400 text-sm"></i>
        <span>បានចម្លង Link Portfolio រួចរាល់!</span>
    </div>

    <script>
        const shareBtn = document.getElementById('shareBtn');
        const toast = document.getElementById('toast');

        if (shareBtn && toast) {
            shareBtn.addEventListener('click', async () => {
                try {
                    await navigator.clipboard.writeText(window.location.href);
                    toast.classList.remove('translate-y-20', 'opacity-0');
                    setTimeout(() => {
                        toast.classList.add('translate-y-20', 'opacity-0');
                    }, 2500);
                } catch (err) {
                    alert('Link: ' + window.location.href);
                }
            });
        }
    </script>

</body>
</html>
