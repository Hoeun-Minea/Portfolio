@extends('layouts.app')

@section('title', $document->title . ' — សាលាឌីជីថល')

@section('content')
<div class="space-y-6">

    <!-- Breadcrumb & Back Link -->
    <nav class="flex items-center space-x-2 text-xs text-slate-500 font-medium pb-2">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-700 flex items-center gap-1.5 transition">
            <i class="fa-solid fa-house text-slate-400"></i>
            <span>ទំព័រដើម</span>
        </a>
        <span class="text-slate-300">/</span>
        <a href="{{ route('dashboard') }}#librarySection" class="hover:text-blue-700 transition">
            <span>{{ $document->category->name }}</span>
        </a>
        <span class="text-slate-300">/</span>
        <span class="text-slate-800 font-semibold truncate max-w-xs sm:max-w-md">{{ $document->title }}</span>
    </nav>

    <!-- Main Content Grid (ដូចរូបភាព Sala Digital: sala.moeys.gov.kh) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- ================= LEFT COLUMN: Viewer & Controls (75% / 8 of 12 cols) ================= -->
        <div class="lg:col-span-8 xl:col-span-9 space-y-4">
            
            <!-- 1. Stats Bar & Action Buttons (ដូចរូបភាព Screenshot បេះបិទ) -->
            <div class="bg-white rounded-2xl border border-slate-200 px-5 py-3.5 flex flex-wrap items-center justify-between gap-3 shadow-xs">
                
                <!-- Left: 👁 ទស្សនា & ⬇ ទាញយក -->
                <div class="flex items-center space-x-5 text-xs text-slate-600 font-medium">
                    <span class="flex items-center gap-1.5">
                        <i class="fa-regular fa-eye text-slate-400 text-sm"></i>
                        <span><strong class="text-slate-800">{{ number_format(320 + ($document->id * 47)) }}</strong> ទស្សនា</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <i class="fa-solid fa-download text-slate-400 text-sm"></i>
                        <span><strong class="text-slate-800">{{ number_format(15 + ($document->id * 11)) }}</strong> ទាញយក</span>
                    </span>
                </div>

                <!-- Right: ⬇ ទាញយក (Blue Pill) & 🔗 ចែករំលែក (White Pill) -->
                <div class="flex items-center space-x-2.5">
                    <!-- Download Button (ដូចប៊ូតុងខៀវចាស់ក្នុងរូបភាព) -->
                    <a href="{{ route('documents.download', $document) }}" 
                       download 
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#005596] hover:bg-[#003a66] active:scale-95 text-white text-xs font-semibold shadow-sm transition">
                        <i class="fa-solid fa-download"></i>
                        <span>ទាញយក</span>
                    </a>

                    <!-- Share Button (ដូចប៊ូតុងសក្នុងរូបភាព) -->
                    <button type="button" 
                            id="shareDocumentBtn" 
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full bg-white hover:bg-slate-50 border border-slate-300 active:scale-95 text-slate-700 text-xs font-semibold shadow-xs transition">
                        <i class="fa-solid fa-share-nodes text-slate-500"></i>
                        <span>ចែករំលែក</span>
                    </button>

                    <!-- Open Fullscreen / Separate Tab -->
                    <a href="{{ route('documents.preview', $document) }}" 
                       target="_blank" 
                       class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-medium transition" 
                       title="បើកមើលក្នុង Tab ថ្មី">
                        <i class="fa-solid fa-up-right-from-square text-xs"></i>
                    </a>
                </div>

            </div>

            <!-- 2. Embedded Document Preview Viewer (ដូចក្នុងរូបភាព Screenshot) -->
            <div class="relative bg-[#323639] rounded-2xl border border-slate-300 shadow-md overflow-hidden min-h-[780px] flex flex-col justify-center items-center">
                
                @if($document->file_type === 'pdf')
                    <!-- PDF Viewer Embedded iframe (displays with native Chrome/Edge PDF controls) -->
                    <iframe src="{{ route('documents.preview', $document) }}#toolbar=1&navpanes=1" 
                            class="w-full h-[820px] rounded-2xl border-0" 
                            title="{{ $document->title }}"
                            allowfullscreen>
                    </iframe>
                @elseif(in_array($document->file_type, ['jpg', 'jpeg', 'png', 'webp', 'gif']))
                    <!-- Image Viewer -->
                    <div class="w-full h-[820px] flex items-center justify-center p-4 bg-slate-900/90 overflow-auto">
                        <img src="{{ route('documents.preview', $document) }}" 
                             alt="{{ $document->title }}" 
                             class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
                    </div>
                @else
                    <!-- Office Document (Word, PPT, Excel) Viewer Fallback -->
                    <div class="w-full h-[820px] flex flex-col items-center justify-center p-8 bg-gradient-to-b from-slate-800 to-slate-900 text-white text-center space-y-4">
                        <div class="w-20 h-20 rounded-3xl bg-white/10 flex items-center justify-center text-4xl shadow-lg border border-white/10 
                            @if(in_array($document->file_type, ['doc', 'docx'])) text-blue-400
                            @elseif(in_array($document->file_type, ['ppt', 'pptx'])) text-amber-400
                            @elseif(in_array($document->file_type, ['xls', 'xlsx'])) text-emerald-400
                            @else text-slate-300 @endif">
                            @if(in_array($document->file_type, ['doc', 'docx']))
                                <i class="fa-solid fa-file-word"></i>
                            @elseif(in_array($document->file_type, ['ppt', 'pptx']))
                                <i class="fa-solid fa-file-powerpoint"></i>
                            @elseif(in_array($document->file_type, ['xls', 'xlsx']))
                                <i class="fa-solid fa-file-excel"></i>
                            @else
                                <i class="fa-solid fa-file-lines"></i>
                            @endif
                        </div>

                        <div class="max-w-md space-y-1.5">
                            <h3 class="font-khmer-muol text-lg sm:text-xl text-white">{{ $document->title }}</h3>
                            <p class="text-xs text-slate-400">ឯកសារប្រភេទ {{ strtoupper($document->file_type) }} • ទំហំ {{ $document->file_size }}</p>
                            <p class="text-xs text-slate-300 pt-2 leading-relaxed">
                                ឯកសារនេះត្រូវបានរក្សាទុកដោយជោគជ័យ។ លោកគ្រូអាចចុចប៊ូតុងខាងក្រោមដើម្បីទាញយក និងបើកមើលក្នុងកម្មវិធី Microsoft Office។
                            </p>
                        </div>

                        <div class="pt-3 flex flex-wrap items-center justify-center gap-3">
                            <a href="{{ route('documents.download', $document) }}" 
                               download 
                               class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-blue-600 hover:bg-blue-700 active:scale-95 text-white text-xs font-bold shadow-lg transition">
                                <i class="fa-solid fa-download"></i>
                                <span>ទាញយកឯកសារ {{ strtoupper($document->file_type) }}</span>
                            </a>
                        </div>
                    </div>
                @endif

            </div>

            <!-- 3. Document Details & Description Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-3 shadow-xs">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200/60 mb-2">
                            {{ $document->category->name }}
                        </span>
                        <h1 class="font-khmer-muol text-lg sm:text-xl text-slate-900 leading-snug">
                            {{ $document->title }}
                        </h1>
                    </div>

                    @if($document->is_portfolio)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold flex-shrink-0">
                            <i class="fa-solid fa-award text-amber-500"></i>
                            <span>ស្នាដៃ Portfolio</span>
                        </span>
                    @endif
                </div>

                @if($document->description)
                    <div class="pt-2 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100">
                        <p class="font-semibold text-slate-800 mb-1">ការពិពណ៌នាសង្ខេប៖</p>
                        <p class="whitespace-pre-line">{{ $document->description }}</p>
                    </div>
                @endif

                <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-400">
                    <span>ផ្ទុកឡើងកាលពី {{ $document->created_at->format('d/m/Y h:i A') }}</span>
                    <span>គ្រប់គ្រង និងរៀបចំដោយ <strong>ហឿន មិនា | ICT</strong></span>
                </div>
            </div>

        </div>


        <!-- ================= RIGHT COLUMN: Sidebar (25% / 4 of 12 cols) ================= -->
        <div class="lg:col-span-4 xl:col-span-3 space-y-4">
            
            <!-- Card 1: ស្ថាប័ន / អ្នកបង្កើត (ដូចរូបភាព Screenshot) -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs space-y-4">
                <div class="flex items-center space-x-3.5">
                    <!-- School / Teacher Emblem -->
                    <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-blue-700 to-teal-500 text-white flex items-center justify-center font-bold text-base shadow-sm flex-shrink-0">
                        HM
                    </div>
                    <div class="min-w-0">
                        <h4 class="font-khmer-muol text-xs sm:text-sm text-slate-900 truncate">
                            ហឿន មិនា | ICT
                        </h4>
                        <a href="https://hssp.vercel.app/" target="_blank" class="text-[11px] text-emerald-700 hover:underline font-medium block truncate" title="គេហទំព័រវិទ្យាល័យ ហ៊ុន សែន សេរីភាព">
                            វិទ្យាល័យ ហ៊ុន សែន សេរីភាព ↗
                        </a>
                        <p class="text-[10px] text-slate-400 mt-0.5">គ្រូបង្រៀនព័ត៌មានវិទ្យា (ICT)</p>
                    </div>
                </div>

                <!-- Teacher Social & School Links -->
                <div class="flex items-center justify-between pt-1 border-t border-slate-100">
                    <span class="text-[11px] text-slate-400 font-medium">ទំនាក់ទំនង៖</span>
                    <div class="flex items-center space-x-1.5">
                        <a href="https://web.facebook.com/MineaHoeun10" target="_blank" class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition" title="Facebook: Minea Hoeun">
                            <i class="fa-brands fa-facebook-f text-xs"></i>
                        </a>
                        <a href="https://www.youtube.com/@hoeunminea8304" target="_blank" class="w-7 h-7 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition" title="YouTube: @hoeunminea8304">
                            <i class="fa-brands fa-youtube text-xs"></i>
                        </a>
                        <a href="https://t.me/mineahoeun" target="_blank" class="w-7 h-7 rounded-lg bg-sky-50 text-sky-500 hover:bg-sky-500 hover:text-white flex items-center justify-center transition" title="Telegram: @mineahoeun">
                            <i class="fa-brands fa-telegram text-xs"></i>
                        </a>
                        <a href="https://hssp.vercel.app/" target="_blank" class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white flex items-center justify-center transition" title="វិទ្យាល័យ ហ៊ុន សែន សេរីភាព">
                            <i class="fa-solid fa-globe text-xs"></i>
                        </a>
                    </div>
                </div>

                <a href="{{ route('portfolio.public') }}" 
                   target="_blank" 
                   class="w-full py-2.5 px-4 rounded-xl bg-[#005596] hover:bg-[#003a66] text-white text-xs font-semibold text-center block transition shadow-sm active:scale-95">
                    មើលប្រវត្តិរូប និងស្នាដៃ (Portfolio)
                </a>
            </div>

            <!-- Card 2: អំពីសៀវភៅ / ឯកសារ (ដូចរូបភាព Screenshot) -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs space-y-3">
                <h3 class="font-khmer-muol text-sm text-slate-900 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-blue-600 text-xs"></i>
                    <span>អំពីសៀវភៅ/ឯកសារ</span>
                </h3>

                <dl class="space-y-2 text-xs">
                    <div class="flex items-center justify-between">
                        <dt class="text-slate-500">ភាសា:</dt>
                        <dd class="font-semibold text-slate-800">ភាសាខ្មែរ</dd>
                    </div>

                    <div class="flex items-center justify-between">
                        <dt class="text-slate-500">អ្នកនិពន្ធ/រៀបចំ:</dt>
                        <dd class="font-semibold text-slate-800">ហឿន មិនា | ICT</dd>
                    </div>

                    <div class="flex items-center justify-between">
                        <dt class="text-slate-500">បោះពុម្ពផ្សាយ:</dt>
                        <dd class="font-semibold text-slate-800">
                            <a href="https://hssp.vercel.app/" target="_blank" class="text-emerald-700 hover:underline">ហ៊ុន សែន សេរីភាព</a>, MoEYS
                        </dd>
                    </div>

                    <div class="flex items-center justify-between">
                        <dt class="text-slate-500">ឆ្នាំសិក្សា/បោះពុម្ព:</dt>
                        <dd class="font-semibold text-slate-800">{{ $document->academic_year }}</dd>
                    </div>

                    <div class="flex items-center justify-between">
                        <dt class="text-slate-500">ទំហំឯកសារ:</dt>
                        <dd class="font-mono text-slate-700">{{ $document->file_size }}</dd>
                    </div>

                    <div class="flex items-center justify-between">
                        <dt class="text-slate-500">ប្រភេទ File:</dt>
                        <dd class="font-bold text-blue-700 uppercase">{{ $document->file_type }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Card 3: កម្មវិធីសិក្សា (ដូចរូបភាព Screenshot) -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs space-y-3">
                <h3 class="font-khmer-muol text-sm text-slate-900 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-graduation-cap text-blue-600 text-xs"></i>
                    <span>កម្មវិធីសិក្សា</span>
                </h3>

                <div class="space-y-3 text-xs">
                    <div>
                        <p class="text-[11px] text-slate-400 mb-1.5 font-medium">កម្រិតអប់រំ</p>
                        <div class="flex flex-wrap gap-1.5">
                            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-[11px] font-medium">គ្រប់កម្រិតសិក្សា</span>
                            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-[11px] font-medium">មធ្យមសិក្សាទុតិយភូមិ</span>
                        </div>
                    </div>

                    <div>
                        <p class="text-[11px] text-slate-400 mb-1.5 font-medium">ថ្នាក់</p>
                        <div class="flex flex-wrap gap-1.5">
                            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-[11px] font-medium">គ្រប់កម្រិតថ្នាក់</span>
                            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-[11px] font-medium">ថ្នាក់ទី១០ - ទី១២</span>
                        </div>
                    </div>

                    <div>
                        <p class="text-[11px] text-slate-400 mb-1.5 font-medium">មុខវិជ្ជា</p>
                        <div class="flex flex-wrap gap-1.5">
                            <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-200/60 text-[11px] font-semibold">បច្ចេកវិទ្យា (ICT)</span>
                            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-[11px] font-medium">អក្ខរកម្មឌីជីថល</span>
                            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-[11px] font-medium">ប្រព័ន្ធផ្សព្វផ្សាយ និងព័ត៌មាន</span>
                            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-[11px] font-medium">ការអប់រំ STEAM</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4: ពាក្យគន្លឹះ (ដូចរូបភាព Screenshot) -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs space-y-3">
                <h3 class="font-khmer-muol text-sm text-slate-900 pb-2 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-tags text-blue-600 text-xs"></i>
                    <span>ពាក្យគន្លឹះ</span>
                </h3>

                <div class="flex flex-wrap gap-1.5">
                    <span class="px-3 py-1 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-medium cursor-pointer transition">គ្រូបង្រៀន</span>
                    <span class="px-3 py-1 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-medium cursor-pointer transition">គោលនយោបាយ</span>
                    <span class="px-3 py-1 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-medium cursor-pointer transition">Teacher</span>
                    <span class="px-3 py-1 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-medium cursor-pointer transition">ICT</span>
                    <span class="px-3 py-1 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-medium cursor-pointer transition">កិច្ចតែងការ</span>
                    <span class="px-3 py-1 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-[11px] font-medium cursor-pointer transition">សាលាឌីជីថល</span>
                </div>
            </div>

            <!-- Back to Library Button -->
            <div class="pt-2">
                <a href="{{ route('dashboard') }}" class="w-full py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold text-center block transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    <span>ត្រឡប់ទៅកាតាឡុកបណ្ណាល័យ</span>
                </a>
            </div>

        </div>

    </div>

</div>

<!-- Copy Link Toast Notification -->
<div id="copyToast" class="fixed bottom-6 right-6 z-50 transform translate-y-20 opacity-0 transition-all duration-300 bg-slate-900 text-white px-5 py-3.5 rounded-2xl shadow-xl flex items-center space-x-2.5 text-xs font-medium">
    <i class="fa-solid fa-circle-check text-emerald-400 text-base"></i>
    <span>បានចម្លង Link ឯកសារនេះរួចរាល់!</span>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const shareBtn = document.getElementById('shareDocumentBtn');
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
                    prompt('ចម្លង Link ឯកសារ៖', window.location.href);
                }
            });
        }
    });
</script>
@endpush
