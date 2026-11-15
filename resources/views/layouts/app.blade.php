<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ប្រព័ន្ធគ្រប់គ្រងឯកសារ និង Portfolio គ្រូបង្រៀន')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Khmer Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@300;400;500;600;700&family=Moul&family=Siemreap&display=swap" rel="stylesheet">

    <style>
        .font-khmer-muol {
            font-family: 'Khmer OS Muol Light', 'Khmer OS Muol', 'Moul', serif;
        }
        .font-khmer-siemreap {
            font-family: 'Khmer OS Siemreap', 'Siemreap', 'Kantumruy Pro', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-100 font-khmer-siemreap text-slate-800 antialiased">

    <div class="min-h-screen flex">
        <!-- របារ Sidebar ខាងឆ្វេង -->
        <aside class="w-64 bg-slate-900 text-white flex-shrink-0 flex flex-col justify-between hidden md:flex">
            <div>
                <!-- Header នៃ Sidebar -->
                <div class="h-20 flex items-center px-6 bg-blue-700">
                    <i class="fa-solid fa-graduation-cap text-2xl mr-3 text-blue-200"></i>
                    <div>
                        <h1 class="font-khmer-muol text-sm tracking-wide text-white leading-tight">ប្រព័ន្ធឯកសារគ្រូ</h1>
                        <p class="text-xs text-blue-200">Teacher Portfolio Hub</p>
                    </div>
                </div>

                <!-- ម៉ឺនុយរុករក (Navigation Menu) -->
                <nav class="mt-6 px-4 space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
                        <i class="fa-solid fa-chart-pie w-5 mr-3"></i>
                        <span>ផ្ទាំងគ្រប់គ្រង (Dashboard)</span>
                    </a>

                    <a href="{{ route('portfolio.public') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('portfolio.public') ? 'bg-blue-600 text-white shadow' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
                        <i class="fa-solid fa-award w-5 mr-3"></i>
                        <span>Portfolio សាធារណៈ</span>
                    </a>
                </nav>
            </div>

            <!-- Profile សង្ខេបរបស់គ្រូ -->
            <div class="p-4 border-t border-slate-800 flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center font-bold text-white shadow">
                    គ
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-white">លោកគ្រូ / អ្នកគ្រូ</h4>
                    <p class="text-xs text-slate-400">វិទ្យាល័យ / សាលារៀន</p>
                </div>
            </div>
        </aside>

        <!-- ផ្នែក Main Content ខាងស្តាំ -->
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <!-- Topbar Header -->
            <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 shadow-sm sticky top-0 z-20">
                <div class="flex items-center space-x-3">
                    <span class="text-xs font-semibold px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full">
                        ឆ្នាំសិក្សា ២០២៤-២០២៥
                    </span>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('portfolio.public') }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center">
                        <i class="fa-solid fa-arrow-up-right-from-square mr-1.5 text-xs"></i> មើល Portfolio សាធារណៈ
                    </a>
                </div>
            </header>

            <!-- Main Body View -->
            <main class="p-6 md:p-8">
                <!-- បង្ហាញ Alert Messages -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded shadow-sm flex items-center">
                        <i class="fa-solid fa-circle-check mr-3 text-lg"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-800 rounded shadow-sm flex items-center">
                        <i class="fa-solid fa-circle-exclamation mr-3 text-lg"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
