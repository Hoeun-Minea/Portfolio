@extends('layouts.app')

@section('title', $document->title . ' — បណ្ណាល័យខ្ញុំ')

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
                
                <!-- Left: 👁 ទស្សនា & ⬇ ទាញយក (រាប់ជាក់ស្ដែង) -->
                <div class="flex items-center space-x-5 text-xs text-slate-600 font-medium">
                    <span class="flex items-center gap-1.5" title="ចំនួនអ្នកទស្សនាជាក់ស្ដែង">
                        <i class="fa-regular fa-eye text-slate-400 text-sm"></i>
                        <span><strong class="text-slate-800" id="liveViewsCount">{{ number_format($document->views_count ?? 0) }}</strong> ទស្សនា</span>
                    </span>
                    <span class="flex items-center gap-1.5" title="ចំនួនទាញយកជាក់ស្ដែង">
                        <i class="fa-solid fa-download text-slate-400 text-sm"></i>
                        <span><strong class="text-slate-800" id="liveDownloadsCount">{{ number_format($document->downloads_count ?? 0) }}</strong> ទាញយក</span>
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

                        <!-- 2. Embedded Document Preview Viewer (ដូចក្នុងរូបភាព Screenshot MoEYS Sala Digital) -->
            <div id="pdfViewerWrapper" class="relative bg-[#323639] rounded-2xl border border-slate-300 shadow-md overflow-hidden min-h-[780px] flex flex-col">
                
                @if($document->file_type === 'pdf')
                    <!-- PDF.js Top Dark Toolbar (ដូចរូបភាព Screenshot MoEYS Sala Digital បេះបិទ) -->
                    <div class="bg-[#202124] text-slate-200 px-4 py-2.5 flex flex-wrap items-center justify-between gap-2 border-b border-white/10 select-none z-10">
                        <!-- Left: Document Title -->
                        <div class="flex items-center space-x-2 min-w-0 max-w-[260px] sm:max-w-xs">
                            <i class="fa-regular fa-file-pdf text-red-400 text-sm flex-shrink-0"></i>
                            <span class="text-xs font-medium text-slate-200 truncate" title="{{ $document->title }}">{{ $document->title }}</span>
                        </div>

                        <!-- Center: Page Navigation & Zoom Controls (ដូច Screenshot 1/28, - 126% +) -->
                        <div class="flex items-center space-x-2 text-xs">
                            <!-- Page Prev/Next -->
                            <div class="flex items-center bg-[#2d2e30] rounded-lg px-2 py-1 border border-white/10 space-x-1.5">
                                <button type="button" onclick="onPrevPage()" class="p-1 hover:text-white text-slate-300 hover:bg-white/10 rounded transition" title="ទំព័រមុន (Previous Page)">
                                    <i class="fa-solid fa-chevron-left text-[10px]"></i>
                                </button>
                                <div class="flex items-center space-x-1 font-mono text-[11px]">
                                    <input type="number" id="pdfPageNum" value="1" min="1" class="w-10 bg-transparent text-center text-white focus:outline-none focus:bg-white/10 rounded py-0.5" title="វាយបញ្ចូលលេខទំព័រ">
                                    <span class="text-slate-400">/</span>
                                    <span id="pdfPageCount" class="text-slate-400">--</span>
                                </div>
                                <button type="button" onclick="onNextPage()" class="p-1 hover:text-white text-slate-300 hover:bg-white/10 rounded transition" title="ទំព័របន្ទាប់ (Next Page)">
                                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </button>
                            </div>

                            <span class="text-white/20 hidden sm:inline">|</span>

                            <!-- Zoom Controls (- 100% +) -->
                            <div class="hidden sm:flex items-center bg-[#2d2e30] rounded-lg px-2 py-1 border border-white/10 space-x-1.5">
                                <button type="button" onclick="onZoomOut()" class="p-1 hover:text-white text-slate-300 hover:bg-white/10 rounded transition" title="បង្រួម (Zoom Out)">
                                    <i class="fa-solid fa-minus text-[10px]"></i>
                                </button>
                                <span id="pdfZoomLevel" class="text-[11px] font-mono text-slate-200 min-w-[42px] text-center">100%</span>
                                <button type="button" onclick="onZoomIn()" class="p-1 hover:text-white text-slate-300 hover:bg-white/10 rounded transition" title="ពង្រីក (Zoom In)">
                                    <i class="fa-solid fa-plus text-[10px]"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Right: Actions (Fit Width, Rotate, Print, Download, Fullscreen, Open in Tab) -->
                        <div class="flex items-center space-x-1 text-xs">
                            <button type="button" onclick="onFitWidth()" class="p-1.5 hover:text-white text-slate-300 hover:bg-white/10 rounded-lg transition" title="សមល្មមទទឹងអេក្រង់ (Fit to Width)">
                                <i class="fa-solid fa-arrows-left-right-to-line text-xs"></i>
                            </button>
                            <button type="button" onclick="onRotate()" class="p-1.5 hover:text-white text-slate-300 hover:bg-white/10 rounded-lg transition" title="បង្វិល 90° (Rotate)">
                                <i class="fa-solid fa-rotate-right text-xs"></i>
                            </button>
                            <button type="button" onclick="onPrintPdf()" class="p-1.5 hover:text-white text-slate-300 hover:bg-white/10 rounded-lg transition" title="បោះពុម្ព (Print)">
                                <i class="fa-solid fa-print text-xs"></i>
                            </button>
                            <button type="button" onclick="onToggleFullscreen()" class="p-1.5 hover:text-white text-slate-300 hover:bg-white/10 rounded-lg transition" title="ពេញអេក្រង់ (Fullscreen)">
                                <i class="fa-solid fa-expand text-xs"></i>
                            </button>
                            <a href="{{ route('documents.preview', $document) }}" target="_blank" class="p-1.5 hover:text-white text-slate-300 hover:bg-white/10 rounded-lg transition" title="បើកមើលក្នុងផ្ទាំងថ្មី (Open in New Tab)">
                                <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                            </a>
                        </div>
                    </div>

                    <!-- PDF Scrollable Canvas Viewport -->
                    <div id="pdfViewerContainer" class="flex-1 w-full bg-[#525659] overflow-auto p-4 sm:p-6 flex flex-col items-center justify-start min-h-[720px] relative">
                        <!-- Loading State -->
                        <div id="pdfLoading" class="absolute inset-0 bg-[#323639]/90 backdrop-blur-xs flex flex-col items-center justify-center space-y-3 z-20">
                            <div class="w-10 h-10 border-3 border-blue-400 border-t-transparent rounded-full animate-spin"></div>
                            <p class="text-xs font-semibold text-slate-200">កំពុងដំណើរការបើកឯកសារ PDF...</p>
                        </div>

                        <!-- Error State -->
                        <div id="pdfError" class="hidden absolute inset-0 bg-[#323639] flex flex-col items-center justify-center p-6 text-center space-y-4 z-20">
                            <div class="w-16 h-16 rounded-2xl bg-red-500/10 text-red-400 flex items-center justify-center text-3xl">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </div>
                            <div class="max-w-md space-y-1">
                                <h3 class="font-khmer-muol text-base text-white">មិនអាចបង្ហាញឯកសារដោយផ្ទាល់បានទេ</h3>
                                <p class="text-xs text-slate-400">លោកគ្រូអាចចុចប៊ូតុងខាងក្រោមដើម្បីបើកមើលតាម Tab ថ្មី ឬទាញយកឯកសារ</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('documents.preview', $document) }}" target="_blank" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-sm transition">
                                    <i class="fa-solid fa-arrow-up-right-from-square mr-1.5"></i> បើកមើលក្នុង Tab ថ្មី
                                </a>
                                <a href="{{ route('documents.download', $document) }}" download class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold transition">
                                    <i class="fa-solid fa-download mr-1.5"></i> ទាញយក
                                </a>
                            </div>
                        </div>

                        <!-- Canvas for Rendered PDF -->
                        <canvas id="pdfCanvas" class="shadow-2xl rounded-sm bg-white mx-auto my-auto transition-transform"></canvas>
                    </div>

                @elseif(in_array($document->file_type, ['jpg', 'jpeg', 'png', 'webp', 'gif']))
                    <!-- Image Viewer -->
                    <div class="w-full h-[820px] flex items-center justify-center p-4 bg-slate-900/90 overflow-auto">
                        <img src="{{ route('documents.preview', $document) }}" 
                             alt="{{ $document->title }}" 
                             class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
                    </div>

                @else
                    <!-- Office Document (Word, PPT, Excel) with Google Docs Viewer & Download Card -->
                    <div class="w-full flex-1 flex flex-col min-h-[780px]">
                        <!-- Office Header Bar -->
                        <div class="bg-[#202124] text-slate-200 px-4 py-2.5 flex items-center justify-between border-b border-white/10">
                            <div class="flex items-center space-x-2">
                                @if(in_array($document->file_type, ['doc', 'docx']))
                                    <i class="fa-solid fa-file-word text-blue-400 text-sm"></i>
                                @elseif(in_array($document->file_type, ['ppt', 'pptx']))
                                    <i class="fa-solid fa-file-powerpoint text-amber-400 text-sm"></i>
                                @elseif(in_array($document->file_type, ['xls', 'xlsx']))
                                    <i class="fa-solid fa-file-excel text-emerald-400 text-sm"></i>
                                @else
                                    <i class="fa-solid fa-file-lines text-slate-300 text-sm"></i>
                                @endif
                                <span class="text-xs font-medium text-slate-200 truncate">{{ $document->title }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('documents.download', $document) }}" download class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold flex items-center gap-1.5 transition">
                                    <i class="fa-solid fa-download text-[11px]"></i>
                                    <span>ទាញយក</span>
                                </a>
                            </div>
                        </div>

                        <!-- Embedded Google Docs Viewer (works seamlessly online) -->
                        <iframe src="https://docs.google.com/viewer?url={{ urlencode(route('documents.preview', $document)) }}&embedded=true" 
                                class="w-full flex-1 min-h-[720px] border-0 bg-white" 
                                title="{{ $document->title }}"
                                allowfullscreen>
                        </iframe>
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

                <!-- Follower Row (រាប់តាមការជាក់ស្ដែង ដូច Sala Digital) -->
                <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                    <div>
                        <span class="text-sm font-bold text-slate-800" id="followerCountDisplay">{{ number_format($teacherFollowers ?? 0) }}</span>
                        <span class="text-[11px] text-slate-500">អ្នកតាមដាន</span>
                    </div>

                    <!-- Interactive Follow Button -->
                    <button type="button" 
                            id="followTeacherBtn" 
                            onclick="toggleFollowTeacher()" 
                            class="px-4 py-1.5 rounded-full text-xs font-semibold shadow-xs transition active:scale-95 flex items-center gap-1.5 {{ $isFollowed ? 'bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-300' : 'bg-[#005596] hover:bg-[#003a66] text-white' }}">
                        <i class="fa-solid {{ $isFollowed ? 'fa-check' : 'fa-plus' }} text-xs" id="followIcon"></i>
                        <span id="followText">{{ $isFollowed ? 'បានតាមដាន' : 'តាមដាន' }}</span>
                    </button>
                </div>

                <!-- Teacher Social & School Links -->
                <div class="flex items-center justify-between pt-1 border-t border-slate-100">
                    <span class="text-[11px] text-slate-400 font-medium">ទំនាក់ទំនង៖</span>
                    <div class="flex items-center space-x-1.5">
                        <a href="https://web.facebook.com/MineaHoeun10" target="_blank" class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition" title="Facebook">
                            <i class="fa-brands fa-facebook-f text-xs"></i>
                        </a>
                        <a href="https://www.youtube.com/@hoeunminea8304" target="_blank" class="w-7 h-7 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition" title="YouTube">
                            <i class="fa-brands fa-youtube text-xs"></i>
                        </a>
                        <a href="https://t.me/mineahoeun" target="_blank" class="w-7 h-7 rounded-lg bg-sky-50 text-sky-500 hover:bg-sky-500 hover:text-white flex items-center justify-center transition" title="Telegram">
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
@if($document->file_type === 'pdf')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    if (typeof pdfjsLib !== 'undefined') {
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    }

    let pdfDoc = null;
    let pageNum = 1;
    let pageRendering = false;
    let pageNumPending = null;
    let scale = 1.25;
    let rotation = 0;
    const canvas = document.getElementById('pdfCanvas');
    const ctx = canvas ? canvas.getContext('2d') : null;

    function renderPage(num) {
        if (!pdfDoc || !canvas || !ctx) return;
        pageRendering = true;
        
        pdfDoc.getPage(num).then(function(page) {
            const viewport = page.getViewport({ scale: scale, rotation: rotation });
            
            const outputScale = window.devicePixelRatio || 1;
            canvas.width = Math.floor(viewport.width * outputScale);
            canvas.height = Math.floor(viewport.height * outputScale);
            canvas.style.width = Math.floor(viewport.width) + "px";
            canvas.style.height = Math.floor(viewport.height) + "px";

            const transform = outputScale !== 1
                ? [outputScale, 0, 0, outputScale, 0, 0]
                : null;

            const renderContext = {
                canvasContext: ctx,
                transform: transform,
                viewport: viewport
            };

            const renderTask = page.render(renderContext);

            renderTask.promise.then(function() {
                pageRendering = false;
                const loadingEl = document.getElementById('pdfLoading');
                if (loadingEl) loadingEl.classList.add('hidden');
                
                if (pageNumPending !== null) {
                    renderPage(pageNumPending);
                    pageNumPending = null;
                }
            }).catch(function(err) {
                console.error('Page render error:', err);
                pageRendering = false;
            });
        }).catch(function(err) {
            console.error('Error fetching page:', err);
            pageRendering = false;
            const loadingEl = document.getElementById('pdfLoading');
            if (loadingEl) loadingEl.classList.add('hidden');
            const errorEl = document.getElementById('pdfError');
            if (errorEl) errorEl.classList.remove('hidden');
        });

        const pageNumInput = document.getElementById('pdfPageNum');
        if (pageNumInput) pageNumInput.value = num;
    }

    function queueRenderPage(num) {
        if (pageRendering) {
            pageNumPending = num;
        } else {
            renderPage(num);
        }
    }

    function onPrevPage() {
        if (!pdfDoc || pageNum <= 1) return;
        pageNum--;
        queueRenderPage(pageNum);
    }

    function onNextPage() {
        if (!pdfDoc || pageNum >= pdfDoc.numPages) return;
        pageNum++;
        queueRenderPage(pageNum);
    }

    function onZoomIn() {
        scale = Math.min(3.0, +(scale + 0.25).toFixed(2));
        updateZoomDisplay();
        queueRenderPage(pageNum);
    }

    function onZoomOut() {
        scale = Math.max(0.5, +(scale - 0.25).toFixed(2));
        updateZoomDisplay();
        queueRenderPage(pageNum);
    }

    function updateZoomDisplay() {
        const el = document.getElementById('pdfZoomLevel');
        if (el) el.textContent = Math.round(scale * 100) + '%';
    }

    function onFitWidth() {
        const container = document.getElementById('pdfViewerContainer');
        if (!container || !pdfDoc) return;
        pdfDoc.getPage(pageNum).then(function(page) {
            const viewport = page.getViewport({ scale: 1.0, rotation: rotation });
            const containerWidth = container.clientWidth - 48;
            if (containerWidth > 200) {
                scale = +(containerWidth / viewport.width).toFixed(2);
                updateZoomDisplay();
                queueRenderPage(pageNum);
            }
        });
    }

    function onRotate() {
        rotation = (rotation + 90) % 360;
        queueRenderPage(pageNum);
    }

    function onPrintPdf() {
        const previewUrl = '{{ route("documents.preview", $document) }}';
        const win = window.open(previewUrl, '_blank');
        if (win) {
            win.focus();
            setTimeout(() => { try { win.print(); } catch (e) {} }, 1000);
        }
    }

    function onToggleFullscreen() {
        const elem = document.getElementById('pdfViewerWrapper');
        if (!elem) return;
        if (!document.fullscreenElement) {
            elem.requestFullscreen().catch(err => {
                console.error('Fullscreen error:', err);
            });
        } else {
            document.exitFullscreen();
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const pageNumInput = document.getElementById('pdfPageNum');
        if (pageNumInput) {
            pageNumInput.addEventListener('change', (e) => {
                const targetPage = parseInt(e.target.value, 10);
                if (pdfDoc && targetPage >= 1 && targetPage <= pdfDoc.numPages) {
                    pageNum = targetPage;
                    queueRenderPage(pageNum);
                } else {
                    e.target.value = pageNum;
                }
            });
        }

        const pdfUrl = '{{ route("documents.preview", $document) }}';
        if (typeof pdfjsLib !== 'undefined') {
            const loadingTask = pdfjsLib.getDocument({
                url: pdfUrl,
                cMapUrl: 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/cmaps/',
                cMapPacked: true,
            });

            loadingTask.promise.then(function(pdf) {
                pdfDoc = pdf;
                const countEl = document.getElementById('pdfPageCount');
                if (countEl) countEl.textContent = pdf.numPages;
                
                const container = document.getElementById('pdfViewerContainer');
                if (container && container.clientWidth > 300) {
                    pdf.getPage(1).then(page => {
                        const vp = page.getViewport({ scale: 1.0 });
                        const targetScale = (container.clientWidth - 48) / vp.width;
                        scale = Math.min(1.5, Math.max(0.75, +targetScale.toFixed(2)));
                        updateZoomDisplay();
                        renderPage(pageNum);
                    });
                } else {
                    renderPage(pageNum);
                }
            }).catch(function(error) {
                console.error('PDF.js loading error:', error);
                const loadingEl = document.getElementById('pdfLoading');
                if (loadingEl) loadingEl.classList.add('hidden');
                const errorEl = document.getElementById('pdfError');
                if (errorEl) errorEl.classList.remove('hidden');
            });
        }
    });
</script>
@endif

<script>
    function toggleFollowTeacher() {
        const btn = document.getElementById('followTeacherBtn');
        const icon = document.getElementById('followIcon');
        const text = document.getElementById('followText');
        const countEl = document.getElementById('followerCountDisplay');

        btn.disabled = true;

        fetch('{{ route("teacher.follow") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            if (countEl) countEl.textContent = new Intl.NumberFormat().format(data.followers_count);
            
            if (data.is_followed) {
                btn.className = 'px-4 py-1.5 rounded-full text-xs font-semibold shadow-xs transition active:scale-95 flex items-center gap-1.5 bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-300';
                if (icon) icon.className = 'fa-solid fa-check text-xs';
                if (text) text.textContent = 'បានតាមដាន';
            } else {
                btn.className = 'px-4 py-1.5 rounded-full text-xs font-semibold shadow-xs transition active:scale-95 flex items-center gap-1.5 bg-[#005596] hover:bg-[#003a66] text-white';
                if (icon) icon.className = 'fa-solid fa-plus text-xs';
                if (text) text.textContent = 'តាមដាន';
            }
        })
        .catch(err => {
            btn.disabled = false;
            console.error('Follow error:', err);
        });
    }

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
