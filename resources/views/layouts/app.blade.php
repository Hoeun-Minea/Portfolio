<!DOCTYPE html>
<html lang="km" class="h-full bg-[#f4f6f8]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>@yield('title', 'សាលាឌីជីថល — ប្រព័ន្ធគ្រប់គ្រងឯកសារ និង Portfolio | ហឿន មិនា ICT')</title>

    <!-- Google Fonts: Kantumruy Pro, Moul, Siemreap -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Moul&family=Siemreap&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Pro/Free Icons -->
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
                    },
                    colors: {
                        moeys: {
                            blue: '#005596',
                            dark: '#003a66',
                            light: '#e6f0f8',
                            teal: '#008ba3',
                            navy: '#0f2744',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .font-khmer-muol {
            font-family: 'Khmer OS Muol Light', 'Khmer OS Muol', 'Moul', serif;
            letter-spacing: 0.015em;
        }
        .font-khmer-body {
            font-family: 'Kantumruy Pro', 'Khmer OS Siemreap', 'Siemreap', sans-serif;
        }

        /* Modern Dialog Backdrop and Scroll Containment */
        dialog:modal {
            overscroll-behavior: contain;
        }
        dialog::backdrop {
            background-color: rgb(15 23 42 / 0.65);
            backdrop-filter: blur(6px);
            overflow: hidden;
            overscroll-behavior: contain;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="min-h-full font-khmer-body text-slate-800 antialiased flex flex-col bg-[#f4f6f8]">

    <!-- 1. Sala Digital Top Navbar (ដូចរូបភាព sala.moeys.gov.kh) -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-20 flex items-center justify-between gap-4">
                
                <!-- Logo: សាលាឌីជីថល (Sala Digital) -->
                <div class="flex items-center space-x-3 flex-shrink-0">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        <!-- Open Book with Gradient Logo -->
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-amber-500 via-rose-500 to-blue-600 p-0.5 shadow-md group-hover:scale-105 transition transform">
                            <div class="w-full h-full bg-white rounded-[10px] flex items-center justify-center">
                                <i class="fa-solid fa-book-open-reader text-2xl text-blue-600 group-hover:text-amber-500 transition"></i>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center space-x-1.5">
                                <span class="font-khmer-muol text-lg sm:text-xl text-slate-900 group-hover:text-blue-700 transition">សាលាឌីជីថល</span>
                            </div>
                            <p class="text-[11px] text-slate-500 font-medium">ក្រសួងអប់រំ យុវជន និងកីឡា • ហឿន មិនា | ICT</p>
                        </div>
                    </a>
                </div>

                <!-- Navigation Menu Links (ដូច sala.moeys.gov.kh) -->
                <nav class="hidden md:flex items-center space-x-6 text-sm">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 py-2 px-1 font-medium transition {{ request()->routeIs('dashboard') ? 'text-blue-700 border-b-2 border-blue-700' : 'text-slate-600 hover:text-blue-700' }}">
                        <i class="fa-solid fa-layer-group text-blue-600 text-xs"></i>
                        <span>ផ្ទាំងគ្រប់គ្រង</span>
                    </a>

                    <a href="{{ route('portfolio.public') }}" target="_blank" class="flex items-center space-x-2 py-2 px-1 font-medium transition {{ request()->routeIs('portfolio.public') ? 'text-blue-700 border-b-2 border-blue-700' : 'text-slate-600 hover:text-blue-700' }}">
                        <i class="fa-solid fa-award text-amber-500 text-xs"></i>
                        <span>Portfolio ស្នាដៃ</span>
                    </a>

                    <a href="#librarySection" class="flex items-center space-x-2 py-2 px-1 text-slate-600 hover:text-blue-700 font-medium transition">
                        <i class="fa-solid fa-book-bookmark text-emerald-600 text-xs"></i>
                        <span>បណ្ណាល័យ ICT</span>
                    </a>

                    <a href="https://hssp.vercel.app/" target="_blank" class="flex items-center space-x-2 py-2 px-1 text-slate-600 hover:text-blue-700 font-medium transition" title="គេហទំព័រវិទ្យាល័យ ហ៊ុន សែន សេរីភាព">
                        <i class="fa-solid fa-school text-indigo-600 text-xs"></i>
                        <span>វិទ្យាល័យសេរីភាព</span>
                    </a>

                    <a href="#aboutTeacher" class="flex items-center space-x-2 py-2 px-1 text-slate-600 hover:text-blue-700 font-medium transition">
                        <i class="fa-solid fa-circle-info text-emerald-600 text-xs"></i>
                        <span>អំពីគ្រូបង្រៀន</span>
                    </a>
                </nav>

                <!-- Right Actions: Upload Button & Teacher Profile -->
                <div class="flex items-center space-x-3">
                    <button type="button" id="headerUploadBtn" onclick="document.getElementById('openUploadDialogBtn')?.click()" class="hidden sm:inline-flex items-center space-x-2 px-4 py-2 rounded-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-sm hover:shadow transition active:scale-95">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <span>+ បញ្ចូលឯកសារ</span>
                    </button>

                    <!-- Teacher Account Pill (ដូចប៊ូតុង ចូលគណនី) -->
                    <div class="flex items-center space-x-2.5 pl-2 border-l border-slate-200">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-blue-700 to-teal-500 text-white flex items-center justify-center font-bold text-xs shadow-sm">
                            HM
                        </div>
                        <div class="hidden lg:block text-left">
                            <p class="text-xs font-bold text-slate-800 leading-tight">ហឿន មិនា</p>
                            <p class="text-[10px] text-teal-700 font-semibold">គ្រូបង្រៀន ICT</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- 2. Flash Messages Alert -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
            <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-900 rounded-xl shadow-sm flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                    <div>
                        <p class="text-xs font-bold">ជោគជ័យ!</p>
                        <p class="text-xs text-emerald-700">{{ session('success') }}</p>
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-700 p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
            <div class="p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-900 rounded-xl shadow-sm flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg"></i>
                    <div>
                        <p class="text-xs font-bold">មានបញ្ហា!</p>
                        <p class="text-xs text-rose-700">{{ session('error') }}</p>
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-700 p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- 3. Main Content Container -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        @yield('content')
    </main>

    <!-- 4. Sala Digital / MoEYS Style Footer (ដូចរូបភាព sala.moeys.gov.kh បេះបិទ) -->
    <footer class="mt-auto bg-white border-t border-slate-200 text-slate-600 pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-10 border-b border-slate-200">
                
                <!-- Col 1: គេហទំព័រផ្លូវការ -->
                <div>
                    <h4 class="font-khmer-muol text-sm text-slate-900 mb-4 pb-1 border-b-2 border-blue-600 inline-block">
                        គេហទំព័រផ្លូវការ
                    </h4>
                    <ul class="space-y-2.5 text-xs">
                        <li>
                            <a href="https://moeys.gov.kh" target="_blank" class="hover:text-blue-700 flex items-center space-x-2">
                                <i class="fa-solid fa-landmark text-slate-400 text-[10px]"></i>
                                <span>ក្រសួងអប់រំ យុវជន និងកីឡា</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://sala.moeys.gov.kh" target="_blank" class="hover:text-blue-700 flex items-center space-x-2">
                                <i class="fa-solid fa-graduation-cap text-slate-400 text-[10px]"></i>
                                <span>ប្រព័ន្ធសាលាឌីជីថល (MoEYS)</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://hssp.vercel.app/" target="_blank" class="hover:text-blue-700 flex items-center space-x-2 text-emerald-700 font-medium">
                                <i class="fa-solid fa-school text-emerald-600 text-[10px]"></i>
                                <span>វិទ្យាល័យ ហ៊ុន សែន សេរីភាព</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 2: បណ្តាញសង្គមផ្លូវការ -->
                <div>
                    <h4 class="font-khmer-muol text-sm text-slate-900 mb-4 pb-1 border-b-2 border-blue-600 inline-block">
                        បណ្តាញសង្គមផ្លូវការ
                    </h4>
                    <ul class="space-y-2.5 text-xs">
                        <li>
                            <a href="https://web.facebook.com/MineaHoeun10" target="_blank" class="hover:text-blue-700 flex items-center space-x-2 text-blue-600">
                                <i class="fa-brands fa-facebook text-base"></i>
                                <span class="text-slate-600 hover:text-blue-600 font-medium">Facebook: Minea Hoeun</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.youtube.com/@hoeunminea8304" target="_blank" class="hover:text-red-700 flex items-center space-x-2 text-red-600">
                                <i class="fa-brands fa-youtube text-base"></i>
                                <span class="text-slate-600 hover:text-red-600 font-medium">YouTube: @hoeunminea8304</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://t.me/mineahoeun" target="_blank" class="hover:text-sky-700 flex items-center space-x-2 text-sky-500">
                                <i class="fa-brands fa-telegram text-base"></i>
                                <span class="text-slate-600 hover:text-sky-600 font-medium">Telegram: @mineahoeun</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: ជំនួយ និងឯកសារ -->
                <div id="aboutTeacher">
                    <h4 class="font-khmer-muol text-sm text-slate-900 mb-4 pb-1 border-b-2 border-blue-600 inline-block">
                        ជំនួយ និងការគាំទ្រ
                    </h4>
                    <ul class="space-y-2.5 text-xs">
                        <li>
                            <a href="{{ route('portfolio.public') }}" class="hover:text-blue-700 flex items-center space-x-1.5">
                                <i class="fa-solid fa-arrow-right text-[10px] text-blue-600"></i>
                                <span>Portfolio ស្នាដៃគ្រូបង្រៀន</span>
                            </a>
                        </li>
                        <li>
                            <a href="#librarySection" class="hover:text-blue-700 flex items-center space-x-1.5">
                                <i class="fa-solid fa-arrow-right text-[10px] text-blue-600"></i>
                                <span>កាតាឡុកឯកសារ ICT</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-blue-700 flex items-center space-x-1.5">
                                <i class="fa-solid fa-arrow-right text-[10px] text-blue-600"></i>
                                <span>មជ្ឈមណ្ឌលជំនួយបច្ចេកទេស</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: ដៃគូសហការ និងរៀបចំដោយ -->
                <div>
                    <h4 class="font-khmer-muol text-sm text-slate-900 mb-4 pb-1 border-b-2 border-blue-600 inline-block">
                        ដៃគូសហការ និងគ្រប់គ្រង
                    </h4>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3 p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <div class="w-10 h-10 rounded-lg bg-blue-700 text-white flex items-center justify-center font-bold text-sm">
                                HM
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-900">ហឿន មិនា | ICT</p>
                                <p class="text-[10px] text-slate-500">អ្នករៀបចំ និងគ្រប់គ្រងប្រព័ន្ធ</p>
                            </div>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            រៀបចំឡើងស្របតាមស្តង់ដារប្រព័ន្ធសាលាឌីជីថល ដើម្បីលើកកម្ពស់ការគ្រប់គ្រងឯកសារបង្រៀន និងស្នាដៃឌីជីថល។
                        </p>
                        <!-- Social Quick Links -->
                        <div class="flex items-center space-x-2 pt-1">
                            <a href="https://web.facebook.com/MineaHoeun10" target="_blank" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition" title="Facebook">
                                <i class="fa-brands fa-facebook-f text-xs"></i>
                            </a>
                            <a href="https://www.youtube.com/@hoeunminea8304" target="_blank" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition" title="YouTube">
                                <i class="fa-brands fa-youtube text-xs"></i>
                            </a>
                            <a href="https://t.me/mineahoeun" target="_blank" class="w-8 h-8 rounded-lg bg-sky-50 text-sky-500 hover:bg-sky-500 hover:text-white flex items-center justify-center transition" title="Telegram">
                                <i class="fa-brands fa-telegram text-xs"></i>
                            </a>
                            <a href="https://hssp.vercel.app/" target="_blank" class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white flex items-center justify-center transition" title="គេហទំព័រវិទ្យាល័យ ហ៊ុន សែន សេរីភាព">
                                <i class="fa-solid fa-school text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright Bar -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-2">
                <p>សាលាឌីជីថល &copy; {{ date('Y') }} — គ្រប់គ្រង និងរៀបចំដោយ <strong>ហឿន មិនា | ICT</strong> (វិទ្យាល័យ ហ៊ុន សែន សេរីភាព)</p>
                <div class="flex space-x-4">
                    <a href="#" class="hover:underline">លក្ខខណ្ឌប្រើប្រាស់</a>
                    <a href="#" class="hover:underline">គោលការណ៍ឯកជនភាព</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
