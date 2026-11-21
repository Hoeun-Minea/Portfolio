<!DOCTYPE html>
<html lang="km" class="h-full bg-[#f4f6f8]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Portfolio ស្នាដៃ — បណ្ណាល័យខ្ញុំ | ហឿន មិនា ICT</title>

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

    <!-- 1. Header Navigation Bar (ដូចបណ្ណាល័យខ្ញុំ រៀបចំស្អាត មិនចង្អៀត) -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-20 flex items-center justify-between gap-4">
                
                <!-- Logo: បណ្ណាល័យខ្ញុំ -->
                <div class="flex items-center space-x-3 flex-shrink-0">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-gradient-to-tr from-amber-500 via-rose-500 to-blue-600 p-0.5 shadow-md group-hover:scale-105 transition transform flex-shrink-0">
                            <div class="w-full h-full bg-white rounded-[10px] flex items-center justify-center">
                                <i class="fa-solid fa-book-open-reader text-xl sm:text-2xl text-blue-600 group-hover:text-amber-500 transition"></i>
                            </div>
                        </div>
                        <div class="min-w-0">
                            <span class="font-khmer-muol text-base sm:text-lg text-slate-900 group-hover:text-blue-700 transition whitespace-nowrap">បណ្ណាល័យខ្ញុំ</span>
                            <p class="text-[10px] sm:text-[11px] text-slate-500 font-medium whitespace-nowrap">វិទ្យាល័យ ហ៊ុន សែន សេរីភាព • ហឿន មិនា | ICT</p>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links: ដកចេញ ៣ ម៉ឺនុយ ទុកតែ ផ្ទាំងគ្រប់គ្រង និង Portfolio ស្នាដៃ -->
                <nav class="hidden md:flex items-center gap-2 text-xs lg:text-sm font-medium">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 py-2 px-3.5 rounded-xl whitespace-nowrap text-slate-600 hover:text-blue-700 hover:bg-slate-50 transition">
                        <i class="fa-solid fa-layer-group text-blue-600 text-xs"></i>
                        <span>ផ្ទាំងគ្រប់គ្រង</span>
                    </a>

                    <a href="{{ route('portfolio.public') }}" class="inline-flex items-center gap-2 py-2 px-3.5 rounded-xl whitespace-nowrap text-blue-700 bg-blue-50 font-bold shadow-2xs transition">
                        <i class="fa-solid fa-award text-amber-500 text-xs"></i>
                        <span>Portfolio ស្នាដៃ</span>
                    </a>
                </nav>

                <!-- Actions: Share & Print -->
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <button type="button" id="shareBtn" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-700 text-xs font-semibold transition">
                        <i class="fa-solid fa-share-nodes text-xs"></i>
                        <span class="hidden sm:inline">ចែករំលែក Link</span>
                    </button>

                    <button type="button" onclick="window.print()" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full bg-blue-50 text-blue-700 hover:bg-blue-100 active:scale-95 border border-blue-200 text-xs font-semibold transition">
                        <i class="fa-solid fa-print text-xs"></i>
                        <span>បោះពុម្ព</span>
                    </button>
                </div>

            </div>
        </div>
    </header>

    <!-- 2. Hero Profile Banner: លោកគ្រូ ហឿន មិនា | ICT (រចនាទាន់សម័យ និងស៊ីសង្វាក់ជាមួយបណ្ណាល័យខ្ញុំ) -->
    <section class="relative bg-gradient-to-br from-[#002b4d] via-[#005596] to-[#008ba3] text-white py-12 sm:py-16 px-4 sm:px-6 shadow-md overflow-hidden">
        <!-- Background subtle decorative shapes -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-teal-400/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-5xl mx-auto text-center space-y-5 relative z-10">
            
            <!-- Avatar -->
            <div class="relative inline-block mx-auto">
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-white/20 p-1.5 shadow-2xl mx-auto flex items-center justify-center ring-4 ring-white/30 backdrop-blur-sm">
                    <div class="w-full h-full bg-gradient-to-tr from-blue-700 to-teal-500 rounded-full flex items-center justify-center text-3xl font-bold text-white shadow-inner">
                        HM
                    </div>
                </div>
                <span class="absolute bottom-1 right-1 w-5 h-5 bg-emerald-400 border-2 border-white rounded-full shadow-xs" title="គ្រូបង្រៀនសកម្ម"></span>
            </div>

            <!-- Profile Info -->
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs text-blue-100 font-semibold shadow-xs">
                    <i class="fa-solid fa-award text-amber-300"></i>
                    <span>Portfolio ស្នាដៃបង្រៀន និងសមិទ្ធផលការងារ</span>
                </div>
                
                <h1 class="font-khmer-muol text-2xl sm:text-3xl lg:text-4xl text-white tracking-wide drop-shadow-xs">
                    លោកគ្រូ ហឿន មិនា (Hoeun Minea)
                </h1>
                
                <p class="text-xs sm:text-sm text-blue-100 font-medium max-w-xl mx-auto">
                    គ្រូបង្រៀនមុខវិជ្ជាព័ត៌មានវិទ្យា (ICT) • វិទ្យាល័យ ហ៊ុន សែន សេរីភាព
                </p>
                
                <p class="text-[11px] sm:text-xs text-blue-200/90 max-w-lg mx-auto italic leading-relaxed">
                    «ប្តេជ្ញាលើកកម្ពស់គុណភាពអប់រំតាមបែបឌីជីថល តាមរយៈការបញ្ចូលបច្ចេកវិទ្យាព័ត៌មានវិទ្យាទៅក្នុងការបង្រៀន និងរៀបចំឯកសារគរុកោសល្យទំនើប»
                </p>
            </div>

            <!-- Real Stat Highlights Cards (រាប់ជាក់ស្ដែង) -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 max-w-3xl mx-auto pt-2">
                <div class="p-3 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 text-center">
                    <p class="text-xl sm:text-2xl font-bold text-white">{{ $portfolioDocuments->count() }}</p>
                    <p class="text-[11px] text-blue-200 mt-0.5">ឯកសារស្នាដៃ</p>
                </div>
                <div class="p-3 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 text-center">
                    <p class="text-xl sm:text-2xl font-bold text-white">{{ number_format($totalViews ?? 0) }}</p>
                    <p class="text-[11px] text-blue-200 mt-0.5">ចំនួនទស្សនាសរុប</p>
                </div>
                <div class="p-3 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 text-center">
                    <p class="text-xl sm:text-2xl font-bold text-white">{{ number_format($totalDownloads ?? 0) }}</p>
                    <p class="text-[11px] text-blue-200 mt-0.5">ចំនួនទាញយកសរុប</p>
                </div>
                <div class="p-3 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 text-center">
                    <p class="text-xl sm:text-2xl font-bold text-white">{{ number_format($teacherFollowers ?? 0) }}</p>
                    <p class="text-[11px] text-blue-200 mt-0.5">អ្នកតាមដាន</p>
                </div>
            </div>

            <!-- Social and School Links Bar -->
            <div class="flex flex-wrap items-center justify-center gap-2.5 pt-2">
                <a href="https://web.facebook.com/MineaHoeun10" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold shadow-xs transition transform hover:-translate-y-0.5">
                    <i class="fa-brands fa-facebook-f text-xs"></i>
                    <span>Facebook</span>
                </a>

                <a href="https://www.youtube.com/@hoeunminea8304" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-600 hover:bg-red-500 text-white text-xs font-semibold shadow-xs transition transform hover:-translate-y-0.5">
                    <i class="fa-brands fa-youtube text-xs"></i>
                    <span>YouTube</span>
                </a>

                <a href="https://t.me/mineahoeun" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-sky-500 hover:bg-sky-400 text-white text-xs font-semibold shadow-xs transition transform hover:-translate-y-0.5">
                    <i class="fa-brands fa-telegram text-xs"></i>
                    <span>Telegram</span>
                </a>

                <a href="https://hssp.vercel.app/" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold shadow-xs transition transform hover:-translate-y-0.5" title="គេហទំព័រវិទ្យាល័យ ហ៊ុន សែន សេរីភាព">
                    <i class="fa-solid fa-school text-xs"></i>
                    <span>វិទ្យាល័យ ហ៊ុន សែន សេរីភាព</span>
                </a>
            </div>

        </div>
    </section>

    <!-- 3. Portfolio Showcase Grid (ទំនើប ទាន់សម័យ ស៊ីសង្វាក់ជាមួយបណ្ណាល័យខ្ញុំ) -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
        
        <!-- Header Info & Filter Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200 mb-6">
            <div>
                <h2 class="font-khmer-muol text-lg sm:text-xl text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-award text-amber-500 text-base"></i>
                    <span>ស្នាដៃ និងសមិទ្ធផលការងារគំរូ</span>
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    ភ័ស្តុតាងកិច្ចតែងការគំរូ ICT ស្លាយមេរៀន ឯកសារបង្រៀន និងវិញ្ញាបនបត្រអភិវឌ្ឍវិជ្ជាជីវៈ
                </p>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold text-slate-700 bg-white px-4 py-2 rounded-full border border-slate-200 shadow-2xs">
                    <strong class="text-blue-700">{{ $portfolioDocuments->count() }}</strong> ឯកសារស្នាដៃបានជ្រើសរើស
                </span>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition" title="ត្រឡប់ទៅបណ្ណាល័យ">
                    <i class="fa-solid fa-book-open text-xs text-blue-600"></i>
                    <span>បណ្ណាល័យខ្ញុំ</span>
                </a>
            </div>
        </div>

        <!-- Book Cover Cards Grid (5 Columns on Desktop) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
            @forelse($portfolioDocuments as $item)
                <div class="group flex flex-col justify-between bg-white rounded-3xl border border-slate-200 shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden">
                    
                    <!-- 3:4 Aspect Ratio Portrait Book Cover Container -->
                    <div class="relative aspect-[3/4] w-full overflow-hidden p-3.5 flex flex-col justify-between 
                        @if(str_contains(strtolower($item->title), 'steam') || str_contains(strtolower($item->title), 'network'))
                            bg-gradient-to-br from-[#f1e8d9] via-[#e5d9c3] to-[#cfc1a5] text-[#3e3427]
                        @elseif($item->file_type === 'pdf')
                            bg-gradient-to-br from-slate-100 via-amber-50/70 to-slate-200 text-slate-800
                        @elseif(in_array($item->file_type, ['ppt', 'pptx']))
                            bg-gradient-to-br from-teal-50 via-emerald-100 to-sky-100 text-teal-900
                        @else
                            bg-gradient-to-br from-blue-50 via-indigo-50 to-slate-100 text-slate-800
                        @endif border-b border-slate-200/70">

                        <!-- Spine shadow (book 3D look) -->
                        <div class="absolute left-0 top-0 bottom-0 w-3 bg-gradient-to-r from-black/15 via-black/5 to-transparent pointer-events-none"></div>

                        <!-- Top Ribbon: Portfolio Star & Extension Badge -->
                        <div class="flex items-center justify-between w-full relative z-10">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500 text-white shadow-xs flex items-center gap-1">
                                <i class="fa-solid fa-star text-[9px]"></i>
                                <span>ស្នាដៃ</span>
                            </span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold uppercase tracking-wider bg-white/90 shadow-2xs border border-slate-200/60 text-blue-700">
                                {{ $item->file_type }}
                            </span>
                        </div>

                        <!-- Center Cover Graphic & Title -->
                        <div class="my-auto text-center px-2 py-2 relative z-10 space-y-2">
                            <div class="w-10 h-10 rounded-2xl bg-white/80 shadow-xs mx-auto flex items-center justify-center text-blue-700">
                                @if($item->file_type === 'pdf')
                                    <i class="fa-solid fa-file-pdf text-xl text-rose-500"></i>
                                @elseif(in_array($item->file_type, ['ppt', 'pptx']))
                                    <i class="fa-solid fa-file-powerpoint text-xl text-amber-500"></i>
                                @elseif(in_array($item->file_type, ['doc', 'docx']))
                                    <i class="fa-solid fa-file-word text-xl text-blue-600"></i>
                                @else
                                    <i class="fa-solid fa-file-lines text-xl text-emerald-600"></i>
                                @endif
                            </div>
                            <div class="inline-block px-2.5 py-1 rounded bg-black/5 backdrop-blur-xs">
                                <p class="font-khmer-muol text-[11px] sm:text-xs leading-snug line-clamp-3">
                                    {{ $item->title }}
                                </p>
                            </div>
                            <p class="text-[9px] font-semibold opacity-75">
                                {{ $item->category->name }}
                            </p>
                        </div>

                        <!-- Year -->
                        <div class="flex items-center justify-between text-[10px] font-medium relative z-10 pt-1">
                            <span class="opacity-70"><i class="fa-regular fa-calendar text-[9px]"></i> {{ $item->academic_year }}</span>
                            <span class="text-[10px] font-mono opacity-60">{{ $item->file_size }}</span>
                        </div>

                        <!-- Hover Action Overlay -->
                        <div class="absolute inset-0 bg-slate-950/75 backdrop-blur-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex flex-col items-center justify-center gap-2 p-3 z-20">
                            <a href="/documents/{{ $item->id }}" class="w-full py-2 px-3 rounded-xl bg-white text-blue-700 hover:bg-blue-50 text-xs font-bold text-center shadow transition flex items-center justify-center gap-1.5 active:scale-95">
                                <i class="fa-solid fa-eye text-xs"></i>
                                <span>មើលឯកសារ (Preview)</span>
                            </a>

                            <a href="/documents/{{ $item->id }}/download" download class="w-full py-2 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold text-center shadow transition flex items-center justify-center gap-1.5 active:scale-95">
                                <i class="fa-solid fa-download text-xs"></i>
                                <span>ទាញយក</span>
                            </a>
                        </div>

                    </div>

                    <!-- Book Metadata -->
                    <div class="p-3.5 flex flex-col justify-between flex-1 space-y-2">
                        <div>
                            <h4 class="font-bold text-slate-900 text-xs sm:text-sm line-clamp-2 leading-snug group-hover:text-blue-700 transition" title="{{ $item->title }}">
                                <a href="/documents/{{ $item->id }}" class="hover:underline">
                                    {{ $item->title }}
                                </a>
                            </h4>
                            <!-- Author Line (មិនស្ទួន) -->
                            <p class="text-[11px] text-slate-500 mt-1 truncate">
                                by ហឿន មិនា | ICT
                            </p>
                        </div>

                        <!-- Stats Row: 👁 Views, ⬇ Downloads (រាប់ជាក់ស្ដែង) -->
                        <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                            <span class="flex items-center gap-1" title="ចំនួនអ្នកទស្សនាជាក់ស្ដែង">
                                <i class="fa-regular fa-eye text-slate-400 text-[10px]"></i>
                                <span>{{ number_format($item->views_count ?? 0) }}</span>
                            </span>
                            <span class="flex items-center gap-1" title="ចំនួនទាញយកជាក់ស្ដែង">
                                <i class="fa-solid fa-download text-slate-400 text-[10px]"></i>
                                <span>{{ number_format($item->downloads_count ?? 0) }}</span>
                            </span>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-full py-16 text-center text-slate-400 bg-white rounded-3xl border border-dashed border-slate-200">
                    <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-500 mx-auto flex items-center justify-center text-3xl mb-3 shadow-xs">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <h4 class="font-khmer-muol text-base text-slate-800 mb-1">មិនទាន់មានឯកសារស្នាដៃនៅឡើយទេ</h4>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto mb-4">
                        លោកគ្រូ ហឿន មិនា អាចចូលទៅកាន់ផ្ទាំងគ្រប់គ្រង ហើយជ្រើសរើស "កំណត់ជាឯកសារស្នាដៃ (Portfolio)"។
                    </p>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 active:scale-95 text-white text-xs font-semibold rounded-xl shadow-xs transition">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>ត្រឡប់ទៅផ្ទាំងគ្រប់គ្រង</span>
                    </a>
                </div>
            @endforelse
        </div>

    </main>

    <!-- 4. Footer: បណ្ណាល័យខ្ញុំ Style -->
    <footer class="mt-auto bg-white border-t border-slate-200 text-slate-600 pt-8 pb-8 no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-2">
            <p class="text-xs font-bold text-slate-800">
                បណ្ណាល័យខ្ញុំ — វិទ្យាល័យ ហ៊ុន សែន សេរីភាព
            </p>
            <p class="text-xs text-slate-500">
                រៀបចំ និងគ្រប់គ្រងដោយ <strong>លោកគ្រូ ហឿន មិនា | ICT</strong> (<a href="https://hssp.vercel.app/" target="_blank" class="text-emerald-700 hover:underline font-semibold">វិទ្យាល័យ ហ៊ុន សែន សេរីភាព</a>)
            </p>
            <p class="text-[11px] text-slate-400 pt-1">
                រក្សាសិទ្ធិគ្រប់យ៉ាង &copy; {{ date('Y') }}
            </p>
        </div>
    </footer>

    <!-- Toast Notification -->
    <div id="copyToast" class="fixed bottom-6 right-6 z-50 transform translate-y-20 opacity-0 transition-all duration-300 bg-slate-900 text-white px-5 py-3.5 rounded-2xl shadow-xl flex items-center space-x-2.5 text-xs font-medium">
        <i class="fa-solid fa-circle-check text-emerald-400 text-base"></i>
        <span>បានចម្លង Link Portfolio រួចរាល់!</span>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const shareBtn = document.getElementById('shareBtn');
            const toast = document.getElementById('copyToast');

            if (shareBtn && toast) {
                shareBtn.addEventListener('click', async () => {
                    try {
                        await navigator.clipboard.writeText(window.location.href);
                        toast.classList.remove('translate-y-20', 'opacity-0');
                        setTimeout(() => {
                            toast.classList.add('translate-y-20', 'opacity-0');
                        }, 2500);
                    } catch (err) {
                        prompt('ចម្លង Link Portfolio៖', window.location.href);
                    }
                });
            }
        });
    </script>
</body>
</html>
