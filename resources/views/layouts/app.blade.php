<!DOCTYPE html>
<html lang="km" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ប្រព័ន្ធគ្រប់គ្រងឯកសារ និង Portfolio គ្រូបង្រៀន')</title>
    
    <!-- Google Fonts: Kantumruy Pro, Moul, Siemreap -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Moul&family=Siemreap&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Pro/Free Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS with custom configuration -->
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
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
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
        /* Typography overrides */
        .font-khmer-muol {
            font-family: 'Khmer OS Muol Light', 'Khmer OS Muol', 'Moul', serif;
            letter-spacing: 0.02em;
        }
        .font-khmer-body {
            font-family: 'Kantumruy Pro', 'Khmer OS Siemreap', 'Siemreap', sans-serif;
        }

        /* Modern Dialog Backdrop and Scroll Containment (Modern Web Guidance) */
        dialog:modal {
            overscroll-behavior: contain;
        }
        dialog::backdrop {
            background-color: rgb(15 23 42 / 0.65);
            backdrop-filter: blur(6px);
            overflow: hidden;
            overscroll-behavior: contain;
        }

        /* Smooth custom scrollbars */
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
<body class="h-full font-khmer-body text-slate-800 antialiased flex flex-col bg-slate-50 selection:bg-primary-600 selection:text-white">

    <div class="min-h-screen flex flex-col lg:flex-row">

        <!-- Mobile Sidebar Overlay Backdrop -->
        <div id="mobileBackdrop" class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm hidden lg:hidden transition-opacity"></div>

        <!-- Sidebar Navigation -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 text-white flex flex-col justify-between transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto transition-transform duration-300 ease-in-out border-r border-slate-800 shadow-2xl lg:shadow-none">
            
            <div class="flex flex-col h-full">
                <!-- Brand Header -->
                <div class="h-20 px-6 flex items-center justify-between border-b border-slate-800/80 bg-slate-950/40">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-primary-700 to-primary-500 flex items-center justify-center text-white shadow-lg shadow-primary-900/40 group-hover:scale-105 transition transform">
                            <i class="fa-solid fa-graduation-cap text-xl"></i>
                        </div>
                        <div>
                            <h1 class="font-khmer-muol text-sm tracking-wide text-white group-hover:text-primary-300 transition">ប្រព័ន្ធឯកសារគ្រូ</h1>
                            <p class="text-[11px] text-slate-400 font-medium">Digital Portfolio Hub</p>
                        </div>
                    </a>
                    <button id="closeMobileSidebar" class="lg:hidden p-2 text-slate-400 hover:text-white rounded-lg hover:bg-slate-800/60">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <!-- Navigation Links -->
                <div class="px-4 py-6 flex-1 overflow-y-auto space-y-6">
                    <div>
                        <p class="px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-400 mb-2">ម៉ឺនុយចម្បង</p>
                        <nav class="space-y-1.5">
                            <a href="{{ route('dashboard') }}" class="flex items-center px-3.5 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-primary-600 text-white shadow-lg shadow-primary-900/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                <div class="w-7 text-center mr-2">
                                    <i class="fa-solid fa-chart-pie text-base {{ request()->routeIs('dashboard') ? 'text-white' : 'text-primary-400' }}"></i>
                                </div>
                                <span class="flex-1">ផ្ទាំងគ្រប់គ្រង (Dashboard)</span>
                                @if(request()->routeIs('dashboard'))
                                    <span class="w-1.5 h-5 bg-white/70 rounded-full"></span>
                                @endif
                            </a>

                            <a href="{{ route('portfolio.public') }}" target="_blank" class="flex items-center px-3.5 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('portfolio.public') ? 'bg-primary-600 text-white shadow-lg shadow-primary-900/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                <div class="w-7 text-center mr-2">
                                    <i class="fa-solid fa-award text-base text-amber-400"></i>
                                </div>
                                <span class="flex-1">Portfolio សាធារណៈ</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-xs text-slate-400"></i>
                            </a>
                        </nav>
                    </div>

                    <!-- Quick Information Card -->
                    <div class="p-4 rounded-2xl bg-gradient-to-br from-slate-800/80 to-slate-900/90 border border-slate-700/60 text-slate-300">
                        <div class="flex items-center space-x-2 text-primary-400 mb-2">
                            <i class="fa-solid fa-lightbulb text-sm"></i>
                            <span class="text-xs font-semibold">គន្លឹះមានប្រយោជន៍</span>
                        </div>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            អ្នកអាចគ្រីសយក "ឯកសារស្នាដៃ (Portfolio)" ពេល Upload ដើម្បីឱ្យឯកសារនោះបង្ហាញលើទំព័រ Showcase សាធារណៈ។
                        </p>
                    </div>
                </div>

                <!-- Teacher Profile Summary at Bottom -->
                <div class="p-4 border-t border-slate-800/80 bg-slate-950/60 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-primary-600 to-indigo-600 flex items-center justify-center font-bold text-white text-base shadow-md">
                                គ
                            </div>
                            <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 border-2 border-slate-900 rounded-full"></span>
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-sm font-semibold text-white truncate">លោកគ្រូ / អ្នកគ្រូ</h4>
                            <p class="text-xs text-slate-400 truncate">វិទ្យាល័យ ហ៊ុន សែន សេរីភាព</p>
                        </div>
                    </div>
                    <div class="text-slate-400 hover:text-white cursor-pointer" title="ព័ត៌មានគណនី">
                        <i class="fa-solid fa-gear text-sm"></i>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 bg-slate-50">
            
            <!-- Modern Sticky Topbar Header -->
            <header class="bg-white/80 backdrop-blur-md border-b border-slate-200/80 h-20 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-30 transition-all">
                <div class="flex items-center space-x-4">
                    <!-- Hamburger Menu Button for Mobile -->
                    <button id="openMobileSidebar" class="lg:hidden p-2.5 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 focus:outline-none transition">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-primary-50 text-primary-700 border border-primary-200/60">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary-600 animate-pulse"></span>
                                ឆ្នាំសិក្សា ២០២៤-២០២៥
                            </span>
                            <span class="hidden sm:inline-block text-slate-300">|</span>
                            <span class="hidden sm:inline-block text-xs text-slate-500 font-medium">
                                <i class="fa-regular fa-calendar-check mr-1 text-primary-500"></i> បច្ចុប្បន្នភាពឌីជីថល
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-3 sm:space-x-4">
                    <!-- Link to Public Portfolio Button -->
                    <a href="{{ route('portfolio.public') }}" target="_blank" class="inline-flex items-center space-x-2 px-3.5 py-2 text-xs sm:text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 hover:text-primary-700 border border-slate-200 rounded-xl shadow-sm transition hover:shadow">
                        <i class="fa-solid fa-eye text-primary-600"></i>
                        <span class="hidden sm:inline">ទំព័រ</span> Portfolio សាធារណៈ
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-400"></i>
                    </a>
                </div>
            </header>

            <!-- Main Page Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">
                <!-- Flash Notification Banners -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl shadow-sm flex items-start sm:items-center justify-between gap-3 animate-fade-in">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 text-sm">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold">ជោគជ័យ!</p>
                                <p class="text-xs text-emerald-700">{{ session('success') }}</p>
                            </div>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-700 p-1">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-900 rounded-2xl shadow-sm flex items-start sm:items-center justify-between gap-3 animate-fade-in">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0 text-sm">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold">មានបញ្ហា!</p>
                                <p class="text-xs text-rose-700">{{ session('error') }}</p>
                            </div>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-700 p-1">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="mt-auto py-6 px-8 border-t border-slate-200/60 bg-white/60 text-center text-xs text-slate-500">
                <p>ប្រព័ន្ធគ្រប់គ្រងឯកសារ និង Portfolio គ្រូបង្រៀន &copy; {{ date('Y') }} — រចនាឡើងដើម្បីលើកកម្ពស់ការគ្រប់គ្រងការងារបែបឌីជីថល</p>
            </footer>

        </div>
    </div>

    <!-- Mobile Sidebar JavaScript -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const openBtn = document.getElementById('openMobileSidebar');
        const closeBtn = document.getElementById('closeMobileSidebar');
        const backdrop = document.getElementById('mobileBackdrop');

        function toggleSidebar(open) {
            if (open) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }

        if (openBtn) openBtn.addEventListener('click', () => toggleSidebar(true));
        if (closeBtn) closeBtn.addEventListener('click', () => toggleSidebar(false));
        if (backdrop) backdrop.addEventListener('click', () => toggleSidebar(false));
    </script>

    @stack('scripts')
</body>
</html>
