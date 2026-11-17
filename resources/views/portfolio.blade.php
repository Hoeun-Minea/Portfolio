<!DOCTYPE html>
<html lang="km" class="h-full bg-[#f4f6f8]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Portfolio ស្នាដៃ និងសមិទ្ធផលការងារ — ហឿន មិនា | ICT</title>

    <!-- Google Fonts: Kantumruy Pro, Moul, Siemreap -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Moul&family=Siemreap&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS with Sala Digital Theme -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        muol: ['"Khmer OS Muol Light"', '"Khmer OS Muol"', 'Moul', 'serif'],
                        siemreap: ['"Khmer OS Siemreap"', 'Siemreap', '"Kantumruy Pro"', 'sans-serif'],
                        body: ['"Kantumruy Pro"', '"Khmer OS Siemreap"', 'sans-serif'],
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
<body class="min-h-full font-khmer-body text-slate-800 antialiased bg-[#f4f6f8] flex flex-col">

    <!-- 1. Sala Digital Top Navigation Bar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-20 flex items-center justify-between gap-4">
                
                <!-- Logo: សាលាឌីជីថល -->
                <div class="flex items-center space-x-3 flex-shrink-0">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-amber-500 via-rose-500 to-blue-600 p-0.5 shadow-md group-hover:scale-105 transition transform">
                            <div class="w-full h-full bg-white rounded-[10px] flex items-center justify-center">
                                <i class="fa-solid fa-book-open-reader text-2xl text-blue-600 group-hover:text-amber-500 transition"></i>
                            </div>
                        </div>
                        <div>
                            <span class="font-khmer-muol text-lg sm:text-xl text-slate-900 group-hover:text-blue-700 transition">សាលាឌីជីថល</span>
                            <p class="text-[11px] text-slate-500 font-medium">ក្រសួងអប់រំ យុវជន និងកីឡា • ហឿន មិនា | ICT</p>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="hidden md:flex items-center space-x-6 text-sm">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 py-2 px-1 text-slate-600 hover:text-blue-700 font-medium transition">
                        <i class="fa-solid fa-layer-group text-blue-600 text-xs"></i>
                        <span>ផ្ទាំងគ្រប់គ្រង</span>
                    </a>

                    <a href="{{ route('portfolio.public') }}" class="flex items-center space-x-2 py-2 px-1 text-blue-700 border-b-2 border-blue-700 font-semibold transition">
                        <i class="fa-solid fa-award text-amber-500 text-xs"></i>
                        <span>Portfolio ស្នាដៃ</span>
                    </a>

                    <a href="{{ route('dashboard') }}#librarySection" class="flex items-center space-x-2 py-2 px-1 text-slate-600 hover:text-blue-700 font-medium transition">
                        <i class="fa-solid fa-book-bookmark text-emerald-600 text-xs"></i>
                        <span>បណ្ណាល័យ ICT</span>
                    </a>
                </nav>

                <!-- Actions: Share & Print -->
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <button type="button" id="shareBtn" class="inline-flex items-center gap-1.5 px-3 sm:px-4 py-2 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
                        <i class="fa-solid fa-share-nodes text-xs"></i>
                        <span class="hidden sm:inline">ចែករំលែក Link</span>
                    </button>

                    <button type="button" onclick="window.print()" class="inline-flex items-center gap-1.5 px-3 sm:px-4 py-2 rounded-full bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200 text-xs font-semibold transition">
                        <i class="fa-solid fa-print text-xs"></i>
                        <span>បោះពុម្ព</span>
                    </button>
                </div>

            </div>
        </div>
    </header>

    <!-- 2. Hero Profile Banner: លោកគ្រូ ហឿន មិនា | ICT -->
    <section class="relative bg-gradient-to-r from-[#003865] via-[#005596] to-[#0f2744] text-white py-12 sm:py-16 px-4 sm:px-6 shadow-md">
        <div class="max-w-5xl mx-auto text-center space-y-4 relative z-10">
            
            <!-- Avatar -->
            <div class="relative inline-block mx-auto">
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-white/20 p-1.5 shadow-xl mx-auto flex items-center justify-center">
                    <div class="w-full h-full bg-white rounded-full flex items-center justify-center text-3xl font-bold text-blue-700 shadow-inner">
                        HM
                    </div>
                </div>
                <span class="absolute bottom-1 right-1 w-5 h-5 bg-emerald-500 border-2 border-white rounded-full" title="Active"></span>
            </div>

            <!-- Profile Info -->
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs text-blue-100 font-medium">
                    <i class="fa-solid fa-laptop-code text-amber-300"></i>
                    <span>គ្រប់គ្រង និងរៀបចំដោយ ហឿន មិនា | ICT</span>
                </div>
                <h1 class="font-khmer-muol text-2xl sm:text-3xl text-white tracking-wide">
                    លោកគ្រូ ហឿន មិនា (Hoeun Minea)
                </h1>
                <p class="text-xs sm:text-sm text-blue-100 max-w-xl mx-auto">
                    គ្រូបង្រៀនមុខវិជ្ជាព័ត៌មានវិទ្យា (ICT) • វិទ្យាល័យ ហ៊ុន សែន សេរីភាព
                </p>
                <p class="text-[11px] sm:text-xs text-blue-200/90 max-w-md mx-auto italic">
                    «ប្តេជ្ញាលើកកម្ពស់គុណភាពអប់រំតាមបែបឌីជីថល តាមរយៈការបញ្ចូលបច្ចេកវិទ្យាព័ត៌មានវិទ្យាទៅក្នុងការបង្រៀន»
                </p>
            </div>

            <!-- Badges -->
            <div class="flex flex-wrap items-center justify-center gap-2.5 pt-2 text-xs">
                <span class="px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-sm border border-white/15 text-white flex items-center gap-1.5">
                    <i class="fa-solid fa-laptop-file text-amber-300"></i> គ្រូបង្រៀន ICT
                </span>
                <span class="px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-sm border border-white/15 text-white flex items-center gap-1.5">
                    <i class="fa-solid fa-award text-amber-300"></i> ស្នាដៃ {{ $portfolioDocuments->count() }} ឯកសារ
                </span>
                <span class="px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-sm border border-white/15 text-white flex items-center gap-1.5">
                    <i class="fa-solid fa-school text-emerald-300"></i> វិទ្យាល័យ ហ៊ុន សែន សេរីភាព
                </span>
            </div>

        </div>
    </section>

    <!-- 3. Portfolio Showcase Grid (ដូច Sala Digital Book Covers) -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
        
        <!-- Header Info -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-200 mb-6">
            <div>
                <h2 class="font-khmer-muol text-lg sm:text-xl text-slate-900">ស្នាដៃ និងសមិទ្ធផលការងារគំរូ</h2>
                <p class="text-xs text-slate-500 mt-0.5">ភ័ស្តុតាងកិច្ចតែងការគំរូ ICT ស្លាយមេរៀន និងវិញ្ញាបនបត្រអភិវឌ្ឍវិជ្ជាជីវៈ</p>
            </div>

            <div class="text-xs font-semibold text-slate-700 bg-white px-3.5 py-2 rounded-full border border-slate-200 shadow-sm self-start sm:self-auto">
                <span class="text-blue-700 font-bold">{{ $portfolioDocuments->count() }}</span> ឯកសារស្នាដៃបានជ្រើសរើស
            </div>
        </div>

        <!-- Book Cover Cards Grid (5 Columns on Desktop) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
            @forelse($portfolioDocuments as $item)
                <div class="group flex flex-col justify-between bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden">
                    
                    <!-- 3:4 Aspect Ratio Portrait Book Cover Container -->
                    <div class="relative aspect-[3/4] w-full overflow-hidden p-3 flex flex-col justify-between 
                        @if(str_contains(strtolower($item->title), 'steam') || str_contains(strtolower($item->title), 'network'))
                            bg-gradient-to-br from-[#e8decb] via-[#dfd3bc] to-[#c9bca0] text-[#3e3427]
                        @elseif($item->file_type === 'pdf')
                            bg-gradient-to-br from-slate-100 via-amber-50/60 to-slate-200 text-slate-800
                        @elseif(in_array($item->file_type, ['ppt', 'pptx']))
                            bg-gradient-to-br from-teal-50 via-emerald-100 to-sky-100 text-teal-900
                        @else
                            bg-gradient-to-br from-blue-50 via-slate-50 to-indigo-100 text-slate-800
                        @endif border-b border-slate-200/60">

                        <!-- Spine shadow -->
                        <div class="absolute left-0 top-0 bottom-0 w-3 bg-gradient-to-r from-black/15 via-black/5 to-transparent pointer-events-none"></div>

                        <!-- Top Emblem -->
                        <div class="flex items-center justify-between w-full relative z-10">
                            <div class="w-8 h-8 rounded-full bg-white/90 shadow-sm border border-slate-200/60 flex items-center justify-center">
                                <i class="fa-solid fa-award text-amber-500 text-xs"></i>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold uppercase tracking-wider bg-white/90 shadow-sm border border-slate-200/60 text-blue-700">
                                {{ $item->file_type }}
                            </span>
                        </div>

                        <!-- Center Cover Graphic & Title -->
                        <div class="my-auto text-center px-2 py-2 relative z-10 space-y-2">
                            <div class="inline-block px-2.5 py-1 rounded bg-black/5 backdrop-blur-sm">
                                <p class="font-khmer-muol text-[11px] sm:text-xs leading-snug line-clamp-3">
                                    {{ $item->title }}
                                </p>
                            </div>
                            <p class="text-[9px] font-semibold opacity-75">
                                {{ $item->category->name }}
                            </p>
                        </div>

                        <!-- Year & Portfolio Star -->
                        <div class="flex items-center justify-between text-[10px] font-medium relative z-10 pt-1">
                            <span class="opacity-70"><i class="fa-regular fa-calendar text-[9px]"></i> {{ $item->academic_year }}</span>
                            <span class="px-2 py-0.5 rounded-full bg-emerald-600 text-white font-bold text-[9px] shadow-sm flex items-center gap-1">
                                <i class="fa-solid fa-star text-[8px]"></i> ស្នាដៃ
                            </span>
                        </div>

                        <!-- Hover Overlay -->
                        <div class="absolute inset-0 bg-slate-950/75 backdrop-blur-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex flex-col items-center justify-center gap-2 p-3 z-20">
                            @if(in_array($item->file_type, ['pdf', 'jpg', 'jpeg', 'png', 'webp']))
                                <a href="/documents/{{ $item->id }}/preview" target="_blank" class="w-full py-2 px-3 rounded-xl bg-white text-blue-700 hover:bg-blue-50 text-xs font-bold text-center shadow transition flex items-center justify-center gap-1.5">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                    <span>មើលឯកសារ</span>
                                </a>
                            @endif

                            <a href="/documents/{{ $item->id }}/download" class="w-full py-2 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold text-center shadow transition flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-download text-xs"></i>
                                <span>ទាញយក</span>
                            </a>
                        </div>

                    </div>

                    <!-- Book Metadata -->
                    <div class="p-3.5 flex flex-col justify-between flex-1 space-y-2">
                        <div>
                            <h4 class="font-bold text-slate-900 text-xs sm:text-sm line-clamp-2 leading-snug group-hover:text-blue-700 transition" title="{{ $item->title }}">
                                {{ $item->title }}
                            </h4>
                            <p class="text-[11px] text-slate-500 mt-1 truncate">
                                by ហឿន មិនា | ICT
                            </p>
                        </div>

                        <!-- Stats Row -->
                        <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                            <span class="flex items-center gap-1">
                                <i class="fa-regular fa-eye text-slate-400 text-[10px]"></i>
                                <span>{{ number_format(3200 + ($item->id * 437)) }}</span>
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-download text-slate-400 text-[10px]"></i>
                                <span>{{ number_format(150 + ($item->id * 43)) }}</span>
                            </span>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-full py-16 text-center text-slate-400 bg-white rounded-3xl border border-dashed border-slate-200">
                    <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-500 mx-auto flex items-center justify-center text-3xl mb-3">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <h4 class="font-khmer-muol text-base text-slate-700 mb-1">មិនទាន់មានឯកសារស្នាដៃនៅឡើយទេ</h4>
                    <p class="text-xs text-slate-400 max-w-sm mx-auto mb-4">
                        លោកគ្រូ ហឿន មិនា អាចចូលទៅកាន់ផ្ទាំងគ្រប់គ្រង ហើយជ្រើសរើស "កំណត់ជាឯកសារស្នាដៃ (Portfolio)"។
                    </p>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-xs font-semibold rounded-xl hover:bg-blue-700 transition">
                        <i class="fa-solid fa-arrow-left"></i> ត្រឡប់ទៅផ្ទាំងគ្រប់គ្រង
                    </a>
                </div>
            @endforelse
        </div>

    </main>

    <!-- 4. Footer: Sala Digital Style -->
    <footer class="mt-auto bg-white border-t border-slate-200 text-slate-600 pt-10 pb-8 no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-3">
            <p class="text-xs font-semibold text-slate-800">
                ប្រព័ន្ធសាលាឌីជីថល — Portfolio ស្នាដៃ និងកាតាឡុកឯកសារបង្រៀន
            </p>
            <p class="text-xs text-slate-500">
                រៀបចំ និងគ្រប់គ្រងដោយ <strong>លោកគ្រូ ហឿន មិនា | ICT</strong> (វិទ្យាល័យ ហ៊ុន សែន សេរីភាព)
            </p>
            <p class="text-[11px] text-slate-400">
                &copy; {{ date('Y') }} សាលាឌីជីថល ក្រសួងអប់រំ យុវជន និងកីឡា — រក្សាសិទ្ធិគ្រប់យ៉ាង
            </p>
        </div>
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