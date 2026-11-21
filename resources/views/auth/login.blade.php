@extends('layouts.app')

@section('title', 'ចូលគណនី — បណ្ណាល័យខ្ញុំ | ហឿន មិនា ICT')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-10 px-4">
    
    <!-- Login Card -->
    <div class="w-full max-w-md bg-white rounded-3xl border border-slate-200/90 shadow-xl overflow-hidden p-7 sm:p-9 space-y-6">
        
        <!-- Header & Logo -->
        <div class="text-center space-y-3">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-amber-500 via-rose-500 to-blue-600 p-0.5 shadow-lg mx-auto transform hover:scale-105 transition">
                <div class="w-full h-full bg-white rounded-[14px] flex items-center justify-center">
                    <i class="fa-solid fa-book-open-reader text-3xl text-blue-600"></i>
                </div>
            </div>

            <div>
                <h1 class="font-khmer-muol text-xl sm:text-2xl text-slate-900 tracking-wide">
                    បណ្ណាល័យខ្ញុំ
                </h1>
                <p class="text-xs text-slate-500 font-medium mt-1">
                    វិទ្យាល័យ ហ៊ុន សែន សេរីភាព • ហឿន មិនា | ICT
                </p>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 border border-blue-200/60 text-[11px] text-blue-700 font-semibold mt-2.5">
                    <i class="fa-solid fa-user-shield text-xs"></i>
                    <span>ចូលគណនីដើម្បីគ្រប់គ្រង និងបញ្ចូលឯកសារ</span>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('error'))
            <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation text-rose-500 flex-shrink-0"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(session('info'))
            <div class="p-3.5 bg-blue-50 border border-blue-200 text-blue-700 rounded-xl text-xs flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-blue-500 flex-shrink-0"></i>
                <span>{{ session('info') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-500 flex-shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Tab Selection: Gmail vs Telegram Author -->
        <div class="space-y-4">
            
            <!-- Tab Buttons -->
            <div class="grid grid-cols-2 gap-2 p-1 bg-slate-100 rounded-2xl text-xs font-semibold">
                <button type="button" 
                        id="tabGmailBtn" 
                        onclick="switchLoginTab('gmail')" 
                        class="py-2.5 px-3 rounded-xl transition flex items-center justify-center gap-2 bg-white text-slate-900 shadow-xs">
                    <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                    </svg>
                    <span>Google Gmail</span>
                </button>
                <button type="button" 
                        id="tabTelegramBtn" 
                        onclick="switchLoginTab('telegram')" 
                        class="py-2.5 px-3 rounded-xl transition flex items-center justify-center gap-2 text-slate-500 hover:text-slate-900">
                    <i class="fa-brands fa-telegram text-sky-500 text-base"></i>
                    <span>Telegram</span>
                </button>
            </div>

            <!-- Tab 1: Gmail Form -->
            <div id="gmailSection" class="space-y-3">
                <form action="{{ route('auth.gmail') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">អាសយដ្ឋាន Gmail ពិតប្រាកដ *</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-regular fa-envelope text-xs"></i>
                            </span>
                            <input type="email" 
                                   name="email" 
                                   required 
                                   value="{{ old('email', 'hoeun.minea@gmail.com') }}" 
                                   placeholder="hoeun.minea@gmail.com" 
                                   class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">ឈ្មោះគ្រូបង្រៀន (ស្រេចចិត្ត)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-regular fa-user text-xs"></i>
                            </span>
                            <input type="text" 
                                   name="name" 
                                   value="ហឿន មិនា | ICT" 
                                   placeholder="ហឿន មិនា | ICT" 
                                   class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 active:scale-98 text-white text-xs font-semibold shadow transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-right-to-bracket text-xs"></i>
                        <span>ចូលគណនីជាមួយ Gmail នេះ</span>
                    </button>
                </form>

                <!-- Google OAuth Consent Alternative -->
                <div class="pt-1">
                    <a href="{{ route('auth.google') }}" 
                       class="w-full py-2.5 px-4 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-xs font-medium shadow-2xs transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                        <span>ភ្ជាប់ Google OAuth Consent (បើមាន Client ID)</span>
                    </a>
                </div>
            </div>

            <!-- Tab 2: Telegram Form -->
            <div id="telegramSection" class="hidden space-y-3">
                <form action="{{ route('auth.telegram') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Telegram Username ឬគណនី *</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-sky-500">
                                <i class="fa-brands fa-telegram text-sm"></i>
                            </span>
                            <input type="text" 
                                   name="username" 
                                   required 
                                   value="{{ old('username', '@mineahoeun') }}" 
                                   placeholder="@mineahoeun" 
                                   class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">ឧទាហរណ៍៖ @mineahoeun ឬឈ្មោះគណនី Telegram របស់អ្នក</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">ឈ្មោះបង្ហាញ (ស្រេចចិត្ត)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-regular fa-user text-xs"></i>
                            </span>
                            <input type="text" 
                                   name="name" 
                                   value="ហឿន មិនា | ICT" 
                                   placeholder="ហឿន មិនា | ICT" 
                                   class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 px-4 rounded-xl bg-[#229ED9] hover:bg-[#1e8ec3] active:scale-98 text-white text-xs font-semibold shadow transition flex items-center justify-center gap-2">
                        <i class="fa-brands fa-telegram text-sm"></i>
                        <span>ភ្ជាប់ និងចូលតាម Telegram នេះ</span>
                    </button>
                </form>

                <!-- Official Telegram Widget (if bot configured) -->
                @if(!empty($telegramBotUsername))
                    <div class="pt-2 text-center border-t border-slate-100">
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
            </div>

            <!-- Divider -->
            <div class="relative flex items-center justify-center py-1">
                <div class="border-t border-slate-200 w-full"></div>
                <span class="bg-white px-3 text-[11px] text-slate-400 font-medium">ឬចូលរហ័ស</span>
            </div>

            <!-- Quick Teacher Login Button -->
            <a href="{{ route('auth.quick-teacher') }}" 
               class="w-full py-3 px-4 rounded-xl bg-[#005596] hover:bg-[#003a66] active:scale-98 text-white text-xs font-semibold shadow-sm transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-chalkboard-user text-amber-300"></i>
                <span>ចូលគណនីគ្រូបង្រៀន (ហឿន មិនា | ICT) ភ្លាមៗ</span>
            </a>

        </div>

        <!-- Footer / Return to Home -->
        <div class="pt-4 border-t border-slate-100 text-center space-y-2 text-xs">
            <a href="{{ route('dashboard') }}" class="text-slate-500 hover:text-blue-700 font-medium inline-flex items-center gap-1.5 transition">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                <span>ត្រឡប់ទៅមើលកាតាឡុកបណ្ណាល័យ (ភ្ញៀវទូទៅ)</span>
            </a>
            <p class="text-[10px] text-slate-400">
                បណ្ណាល័យខ្ញុំ &copy; {{ date('Y') }} — វិទ្យាល័យ ហ៊ុន សែន សេរីភាព • ហឿន មិនា | ICT
            </p>
        </div>

    </div>

</div>

<script>
    function switchLoginTab(tab) {
        const gmailSec = document.getElementById('gmailSection');
        const telegramSec = document.getElementById('telegramSection');
        const gmailBtn = document.getElementById('tabGmailBtn');
        const telegramBtn = document.getElementById('tabTelegramBtn');

        if (tab === 'gmail') {
            gmailSec.classList.remove('hidden');
            telegramSec.classList.add('hidden');
            gmailBtn.className = 'py-2.5 px-3 rounded-xl transition flex items-center justify-center gap-2 bg-white text-slate-900 shadow-xs';
            telegramBtn.className = 'py-2.5 px-3 rounded-xl transition flex items-center justify-center gap-2 text-slate-500 hover:text-slate-900';
        } else {
            gmailSec.classList.add('hidden');
            telegramSec.classList.remove('hidden');
            telegramBtn.className = 'py-2.5 px-3 rounded-xl transition flex items-center justify-center gap-2 bg-white text-slate-900 shadow-xs';
            gmailBtn.className = 'py-2.5 px-3 rounded-xl transition flex items-center justify-center gap-2 text-slate-500 hover:text-slate-900';
        }
    }
</script>
@endsection
