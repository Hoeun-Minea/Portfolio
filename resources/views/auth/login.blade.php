@extends('layouts.app')

@section('title', 'ចូលគណនី — សាលាឌីជីថល | ហឿន មិនា ICT')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-10 px-4">
    
    <!-- Login Card -->
    <div class="w-full max-w-md bg-white rounded-3xl border border-slate-200/90 shadow-xl overflow-hidden p-8 sm:p-10 space-y-6">
        
        <!-- Header & Logo (ដូច Sala Digital) -->
        <div class="text-center space-y-3">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-amber-500 via-rose-500 to-blue-600 p-0.5 shadow-lg mx-auto transform hover:scale-105 transition">
                <div class="w-full h-full bg-white rounded-[14px] flex items-center justify-center">
                    <i class="fa-solid fa-book-open-reader text-3xl text-blue-600"></i>
                </div>
            </div>

            <div>
                <h1 class="font-khmer-muol text-xl sm:text-2xl text-slate-900 tracking-wide">
                    សាលាឌីជីថល
                </h1>
                <p class="text-xs text-slate-500 font-medium mt-1">
                    ក្រសួងអប់រំ យុវជន និងកីឡា • វិទ្យាល័យ ហ៊ុន សែន សេរីភាព
                </p>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 border border-blue-200/60 text-[11px] text-blue-700 font-semibold mt-2.5">
                    <i class="fa-solid fa-user-shield text-xs"></i>
                    <span>ចូលគណនីដើម្បីគ្រប់គ្រង និងបញ្ចូលឯកសារ</span>
                </div>
            </div>
        </div>

        <!-- Alert messages -->
        @if(session('error'))
            <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- 1. Google & Telegram Login Options -->
        <div class="space-y-3 pt-2">
            
            <!-- Google Sign-In Button -->
            <a href="{{ route('auth.google') }}" 
               class="group relative w-full py-3.5 px-5 rounded-2xl bg-white hover:bg-slate-50 border border-slate-300 hover:border-slate-400 text-slate-700 text-xs sm:text-sm font-semibold shadow-xs hover:shadow transition flex items-center justify-center gap-3 active:scale-98">
                <!-- Official Google Colored 'G' SVG Logo -->
                <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
                <span>ចូលគណនីតាម Google / Gmail</span>
            </a>

            <!-- Telegram Sign-In Button -->
            <a href="{{ route('auth.telegram.callback') }}?id=mineahoeun&first_name=ហឿន&last_name=មិនា&username=mineahoeun" 
               class="group relative w-full py-3.5 px-5 rounded-2xl bg-[#229ED9] hover:bg-[#1e8ec3] text-white text-xs sm:text-sm font-semibold shadow-sm hover:shadow transition flex items-center justify-center gap-3 active:scale-98">
                <i class="fa-brands fa-telegram text-xl"></i>
                <span>ចូលគណនីតាម Telegram Account</span>
            </a>

            <!-- Divider -->
            <div class="relative flex items-center justify-center py-2">
                <div class="border-t border-slate-200 w-full"></div>
                <span class="bg-white px-3 text-[11px] text-slate-400 font-medium uppercase tracking-wider">ឬ</span>
            </div>

            <!-- Quick Teacher Login -->
            <a href="{{ route('auth.quick-teacher') }}" 
               class="w-full py-3.5 px-5 rounded-2xl bg-[#005596] hover:bg-[#003a66] text-white text-xs sm:text-sm font-semibold shadow-md transition flex items-center justify-center gap-2.5 active:scale-98">
                <i class="fa-solid fa-chalkboard-user text-amber-300"></i>
                <span>ចូលគណនីគ្រូបង្រៀន (ហឿន មិនា | ICT)</span>
            </a>

        </div>

        <!-- Telegram Web Widget Section (if bot username configured) -->
        @if(!empty($telegramBotUsername))
            <div class="text-center pt-2">
                <p class="text-[11px] text-slate-400 mb-2">Telegram Widget ផ្លូវការ៖</p>
                <div class="flex justify-center">
                    <script async src="https://telegram.org/js/telegram-widget.js?22" 
                            data-telegram-login="{{ $telegramBotUsername }}" 
                            data-size="large" 
                            data-radius="14"
                            data-auth-url="{{ route('auth.telegram.callback') }}" 
                            data-request-access="write">
                    </script>
                </div>
            </div>
        @endif

        <!-- Footer / Return to Home -->
        <div class="pt-4 border-t border-slate-100 text-center space-y-2 text-xs">
            <a href="{{ route('dashboard') }}" class="text-slate-500 hover:text-blue-700 font-medium inline-flex items-center gap-1.5 transition">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                <span>ត្រឡប់ទៅមើលកាតាឡុកសៀវភៅ (ភ្ញៀវទូទៅ)</span>
            </a>
            <p class="text-[10px] text-slate-400">
                ប្រព័ន្ធសុវត្ថិភាពសាលាឌីជីថល &copy; {{ date('Y') }} — រៀបចំដោយ ហឿន មិនា | ICT
            </p>
        </div>

    </div>

</div>
@endsection
