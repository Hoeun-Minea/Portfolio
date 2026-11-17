@extends('layouts.app')

@section('title', 'សាលាឌីជីថល — កាតាឡុកឯកសារ និងស្នាដៃបង្រៀន | ហឿន មិនា ICT')

@section('content')
<div class="space-y-6">

    <!-- 1. Hero Search Section (ដូចរូបភាព Sala Digital: sala.moeys.gov.kh) -->
    <div class="max-w-3xl mx-auto pt-2 pb-4 text-center">
        <!-- Search Input with Rounded Pill Style -->
        <div class="relative flex items-center shadow-sm">
            <div class="absolute left-4 sm:left-5 text-slate-400 pointer-events-none">
                <i class="fa-solid fa-magnifying-glass text-slate-400 text-base"></i>
            </div>
            <input type="text" 
                   id="searchInput" 
                   placeholder="ស្វែងរកឯកសារ, មេរៀន, កិច្ចតែងការ..." 
                   class="w-full pl-11 sm:pl-12 pr-28 py-3.5 sm:py-4 rounded-full bg-white border border-slate-200/90 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition shadow-sm">
            <button type="button" 
                    id="searchClearBtn" 
                    class="hidden absolute right-24 text-slate-300 hover:text-slate-500 p-1">
                <i class="fa-solid fa-circle-xmark"></i>
            </button>
            <button type="button" 
                    id="searchTriggerBtn"
                    class="absolute right-2 sm:right-2.5 px-4 sm:px-5 py-2 rounded-full bg-blue-600 hover:bg-blue-700 active:scale-95 text-white text-xs font-semibold shadow transition">
                ស្វែងរក
            </button>
        </div>

        <!-- Sub-Navigation Tabs under Search Input (ដូច sala.moeys.gov.kh) -->
        <div class="flex items-center justify-center gap-4 sm:gap-8 mt-5 border-b border-slate-200 overflow-x-auto pb-0.5 text-xs sm:text-sm font-medium">
            <button type="button" onclick="setSubTab('books')" id="subtab-books" class="subtab-item active text-blue-700 border-b-2 border-blue-700 pb-2.5 px-1.5 flex items-center gap-2 font-semibold">
                <i class="fa-solid fa-book-bookmark text-sm text-blue-600"></i>
                <span>សៀវភៅ/ឯកសារ</span>
            </button>

            <a href="#aboutTeacher" class="subtab-item text-slate-500 hover:text-blue-700 pb-2.5 px-1.5 flex items-center gap-2 transition">
                <i class="fa-solid fa-school text-sm text-slate-400"></i>
                <span>សាលារៀន</span>
            </a>

            <button type="button" onclick="filterByCategoryName('កិច្ចតែងការ')" id="subtab-lessons" class="subtab-item text-slate-500 hover:text-blue-700 pb-2.5 px-1.5 flex items-center gap-2 transition">
                <i class="fa-solid fa-chalkboard-user text-sm text-slate-400"></i>
                <span>មេរៀន/កិច្ចតែងការ</span>
            </button>

            <a href="{{ route('portfolio.public') }}" target="_blank" class="subtab-item text-slate-500 hover:text-blue-700 pb-2.5 px-1.5 flex items-center gap-2 transition">
                <i class="fa-solid fa-newspaper text-sm text-slate-400"></i>
                <span>អត្ថបទ/ស្នាដៃ</span>
            </a>

            <a href="#aboutTeacher" class="subtab-item text-slate-500 hover:text-blue-700 pb-2.5 px-1.5 flex items-center gap-2 transition">
                <i class="fa-solid fa-user-tie text-sm text-slate-400"></i>
                <span>អ្នកប្រើប្រាស់</span>
            </a>
        </div>
    </div>

    <!-- 2. Results Header & Category Pills (ដូចរូបភាព Sala Digital) -->
    <div id="librarySection" class="space-y-3 pt-2">
        
        <!-- Results Counter & Action Controls -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center space-x-2">
                <span id="resultsCountDisplay" class="font-bold text-slate-800 text-sm sm:text-base">
                    {{ $recentDocuments->total() ?? $recentDocuments->count() }} លទ្ធផល
                </span>
                <span class="text-xs text-slate-400">• ប្រព័ន្ធឯកសារ ហឿន មិនា | ICT</span>
            </div>

            <div class="flex items-center space-x-2">
                <!-- View Mode Switcher: Grid vs Table -->
                <div class="inline-flex rounded-xl p-1 bg-slate-200/80 border border-slate-200 text-xs">
                    <button type="button" id="gridModeBtn" onclick="switchView('grid')" class="px-3 py-1.5 rounded-lg font-semibold transition bg-white text-blue-700 shadow-sm flex items-center gap-1.5">
                        <i class="fa-solid fa-grip"></i>
                        <span>កាតាឡុក</span>
                    </button>
                    <button type="button" id="tableModeBtn" onclick="switchView('table')" class="px-3 py-1.5 rounded-lg font-medium transition text-slate-600 hover:text-slate-900 flex items-center gap-1.5">
                        <i class="fa-solid fa-table-list"></i>
                        <span>តារាង</span>
                    </button>
                </div>

                <!-- Open Upload Dialog Button -->
                <button type="button" id="openUploadDialogBtn" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 active:scale-95 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <span>+ បញ្ចូលឯកសារ</span>
                </button>
            </div>
        </div>

        <!-- Horizontal Scrollable Category Pills (ដូចរូបភាព Sala Digital: ទាំងអស់, អក្សរសាស្ត្រខ្មែរ, បច្ចេកវិទ្យា, etc.) -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none text-xs">
            <!-- ទាំងអស់ (All) -->
            <button type="button" data-category="all" class="category-pill-btn active inline-flex items-center px-4 py-2 rounded-full font-semibold transition flex-shrink-0 bg-[#1d3557] text-white shadow-sm">
                ទាំងអស់
            </button>

            <!-- បច្ចេកវិទ្យា (ICT) -->
            <button type="button" data-category="ict" data-filter-text="ict" class="category-pill-btn inline-flex items-center px-4 py-2 rounded-full font-medium transition flex-shrink-0 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 shadow-sm">
                បច្ចេកវិទ្យា (ICT)
            </button>

            <!-- កិច្ចតែងការបង្រៀន -->
            <button type="button" data-category="1" class="category-pill-btn inline-flex items-center px-4 py-2 rounded-full font-medium transition flex-shrink-0 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 shadow-sm">
                កិច្ចតែងការបង្រៀន
            </button>

            <!-- ស្លាយបង្រៀន & មេឌៀ -->
            <button type="button" data-category="2" class="category-pill-btn inline-flex items-center px-4 py-2 rounded-full font-medium transition flex-shrink-0 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 shadow-sm">
                ស្លាយបង្រៀន (PPT)
            </button>

            <!-- កម្មវិធីសិក្សា & ផែនការ -->
            <button type="button" data-category="3" class="category-pill-btn inline-flex items-center px-4 py-2 rounded-full font-medium transition flex-shrink-0 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 shadow-sm">
                ស្តង់ដា/កម្មវិធីសិក្សា
            </button>

            <!-- លិខិតរដ្ឋបាល & បទបញ្ជា -->
            <button type="button" data-category="4" class="category-pill-btn inline-flex items-center px-4 py-2 rounded-full font-medium transition flex-shrink-0 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 shadow-sm">
                លិខិតរដ្ឋបាល
            </button>

            <!-- ស្នាដៃ & CPD -->
            <button type="button" data-category="5" class="category-pill-btn inline-flex items-center px-4 py-2 rounded-full font-medium transition flex-shrink-0 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 shadow-sm">
                ស្នាដៃ & CPD
            </button>

            <!-- Sort Dropdown Pill ពេញនិយម ∨ (ដូច Sala Digital) -->
            <div class="relative ml-auto flex-shrink-0">
                <button type="button" id="sortDropdownBtn" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full font-medium bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 shadow-sm transition">
                    <span id="currentSortText">ពេញនិយម</span>
                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                </button>
            </div>
        </div>

    </div>

    <!-- 3. Sala Digital Book/Document Cards Grid (ទម្រង់សៀវភៅ 5 ជួរដេក ដូចរូបភាព) -->
    <div id="bookGridView" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5 pt-2">
        @forelse($recentDocuments as $index => $doc)
            <!-- Book Card -->
            <div class="document-item-card group flex flex-col justify-between bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden"
                 data-category-id="{{ $doc->category_id }}"
                 data-title="{{ strtolower($doc->title) }}"
                 data-id="{{ $doc->id }}"
                 data-academic-year="{{ $doc->academic_year }}"
                 data-description="{{ $doc->description ?? '' }}"
                 data-is-portfolio="{{ $doc->is_portfolio ? '1' : '0' }}">
                
                <!-- 3:4 Aspect Ratio Portrait Book Cover Container -->
                <div class="relative aspect-[3/4] w-full overflow-hidden p-3 flex flex-col justify-between 
                    @if(str_contains(strtolower($doc->title), 'steam') || str_contains(strtolower($doc->title), 'network'))
                        bg-gradient-to-br from-[#e8decb] via-[#dfd3bc] to-[#c9bca0] text-[#3e3427]
                    @elseif($doc->file_type === 'pdf')
                        bg-gradient-to-br from-slate-100 via-amber-50/60 to-slate-200 text-slate-800
                    @elseif(in_array($doc->file_type, ['ppt', 'pptx']))
                        bg-gradient-to-br from-teal-50 via-emerald-100 to-sky-100 text-teal-900
                    @elseif(in_array($doc->file_type, ['doc', 'docx']))
                        bg-gradient-to-br from-blue-50 via-slate-50 to-indigo-100 text-slate-800
                    @else
                        bg-gradient-to-br from-amber-50 via-orange-50 to-amber-100 text-amber-950
                    @endif border-b border-slate-200/60">

                    <!-- Realistic Book Spine visual shadow -->
                    <div class="absolute left-0 top-0 bottom-0 w-3 bg-gradient-to-r from-black/15 via-black/5 to-transparent pointer-events-none"></div>

                    <!-- Top Cover Emblem / Badge -->
                    <div class="flex items-center justify-between w-full relative z-10">
                        <!-- MoEYS / School Seal -->
                        <div class="w-8 h-8 rounded-full bg-white/90 shadow-sm border border-slate-200/60 flex items-center justify-center">
                            @if(str_contains(strtolower($doc->title), 'steam') || $doc->category_id == 1)
                                <i class="fa-solid fa-atom text-amber-600 text-xs"></i>
                            @elseif($doc->category_id == 2)
                                <i class="fa-solid fa-laptop-code text-teal-600 text-xs"></i>
                            @elseif($doc->category_id == 4)
                                <i class="fa-solid fa-stamp text-blue-700 text-xs"></i>
                            @elseif($doc->category_id == 5)
                                <i class="fa-solid fa-award text-amber-500 text-xs"></i>
                            @else
                                <i class="fa-solid fa-book-open text-blue-600 text-xs"></i>
                            @endif
                        </div>

                        <!-- File Type Tag -->
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold uppercase tracking-wider bg-white/90 shadow-sm border border-slate-200/60 
                            @if($doc->file_type === 'pdf') text-rose-600
                            @elseif(in_array($doc->file_type, ['ppt', 'pptx'])) text-amber-600
                            @elseif(in_array($doc->file_type, ['doc', 'docx'])) text-blue-600
                            @else text-slate-700 @endif">
                            {{ $doc->file_type }}
                        </span>
                    </div>

                    <!-- Middle Cover Title / Graphic (ដូចក្របសៀវភៅ MoEYS) -->
                    <div class="my-auto text-center px-2 py-2 relative z-10 space-y-2">
                        <div class="inline-block px-2.5 py-1 rounded bg-black/5 backdrop-blur-sm">
                            <p class="font-khmer-muol text-[11px] sm:text-xs leading-snug line-clamp-3">
                                {{ $doc->title }}
                            </p>
                        </div>
                        <p class="text-[9px] font-semibold opacity-75">
                            {{ $doc->category->name }}
                        </p>
                    </div>

                    <!-- Bottom Cover Year & Portfolio Ribbon -->
                    <div class="flex items-center justify-between text-[10px] font-medium relative z-10 pt-1">
                        <span class="opacity-70"><i class="fa-regular fa-calendar text-[9px]"></i> {{ $doc->academic_year }}</span>
                        @if($doc->is_portfolio)
                            <span class="px-2 py-0.5 rounded-full bg-emerald-600 text-white font-bold text-[9px] shadow-sm flex items-center gap-1">
                                <i class="fa-solid fa-star text-[8px]"></i> ស្នាដៃ
                            </span>
                        @endif
                    </div>

                    <!-- Hover Quick Actions Overlay -->
                    <div class="absolute inset-0 bg-slate-950/75 backdrop-blur-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex flex-col items-center justify-center gap-2 p-3 z-20">
                        @if(in_array($doc->file_type, ['pdf', 'jpg', 'jpeg', 'png', 'webp']))
                            <a href="/documents/{{ $doc->id }}/preview" target="_blank" class="w-full py-2 px-3 rounded-xl bg-white text-blue-700 hover:bg-blue-50 text-xs font-bold text-center shadow transition flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-eye text-xs"></i>
                                <span>មើលឯកសារ</span>
                            </a>
                        @endif

                        <a href="/documents/{{ $doc->id }}/download" class="w-full py-2 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold text-center shadow transition flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-download text-xs"></i>
                            <span>ទាញយក</span>
                        </a>

                        <div class="flex items-center gap-2 w-full pt-1">
                            <button type="button" class="edit-doc-btn flex-1 py-1.5 px-2 rounded-lg bg-white/20 hover:bg-white/30 text-white text-xs font-semibold text-center transition flex items-center justify-center gap-1">
                                <i class="fa-regular fa-pen-to-square text-xs"></i>
                                <span>កែ</span>
                            </button>

                            <form action="/documents/{{ $doc->id }}" method="POST" class="flex-1" onsubmit="return confirm('តើលោកគ្រូ ហឿន មិនា ពិតជាចង់លុបឯកសារ «{{ $doc->title }}» នេះមែនទេ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full py-1.5 px-2 rounded-lg bg-rose-600/80 hover:bg-rose-600 text-white text-xs font-semibold text-center transition flex items-center justify-center gap-1">
                                    <i class="fa-regular fa-trash-can text-xs"></i>
                                    <span>លុប</span>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>

                <!-- Book Metadata (ដូច Sala Digital: Title, by ហឿន មិនា, views, downloads) -->
                <div class="p-3.5 flex flex-col justify-between flex-1 space-y-2">
                    <div>
                        <!-- Title (max 2 lines) -->
                        <h4 class="font-bold text-slate-900 text-xs sm:text-sm line-clamp-2 leading-snug group-hover:text-blue-700 transition" title="{{ $doc->title }}">
                            {{ $doc->title }}
                        </h4>
                        <!-- Author Line -->
                        <p class="text-[11px] text-slate-500 mt-1 truncate">
                            by ហឿន មិនា | ICT
                        </p>
                    </div>

                    <!-- Stats Row: 👁 Views, ⬇ Downloads -->
                    <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                        <span class="flex items-center gap-1">
                            <i class="fa-regular fa-eye text-slate-400 text-[10px]"></i>
                            <span>{{ number_format(3200 + ($doc->id * 437)) }}</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="fa-solid fa-download text-slate-400 text-[10px]"></i>
                            <span>{{ number_format(150 + ($doc->id * 43)) }}</span>
                        </span>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full py-16 text-center text-slate-400 bg-white rounded-3xl border border-dashed border-slate-200">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-500 mx-auto flex items-center justify-center text-2xl mb-3">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <h4 class="font-khmer-muol text-base text-slate-700 mb-1">មិនទាន់មានឯកសារនៅឡើយទេ</h4>
                <p class="text-xs text-slate-400 max-w-sm mx-auto mb-4">
                    លោកគ្រូ ហឿន មិនា អាចចុចប៊ូតុងខាងក្រោមដើម្បីចាប់ផ្តើម Upload ឯកសារដំបូង។
                </p>
                <button type="button" onclick="document.getElementById('openUploadDialogBtn').click()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow transition">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <span>+ បញ្ចូលឯកសារឥឡូវនេះ</span>
                </button>
            </div>
        @endforelse
    </div>

    <!-- 4. Detailed Table View (អាច Toggle មើលបានគ្រប់ពេល) -->
    <div id="tableView" class="hidden bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-semibold border-b border-slate-200">
                        <th class="py-3.5 px-5">ឯកសារ</th>
                        <th class="py-3.5 px-4">ប្រភេទ</th>
                        <th class="py-3.5 px-4">ឆ្នាំសិក្សា</th>
                        <th class="py-3.5 px-4">ទំហំ</th>
                        <th class="py-3.5 px-4 text-center">Portfolio</th>
                        <th class="py-3.5 px-5 text-right">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @foreach($recentDocuments as $doc)
                        <tr class="document-row-item hover:bg-slate-50 transition"
                            data-category-id="{{ $doc->category_id }}"
                            data-title="{{ strtolower($doc->title) }}"
                            data-id="{{ $doc->id }}"
                            data-academic-year="{{ $doc->academic_year }}"
                            data-description="{{ $doc->description ?? '' }}"
                            data-is-portfolio="{{ $doc->is_portfolio ? '1' : '0' }}">
                            <td class="py-3.5 px-5">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-xs uppercase
                                        @if($doc->file_type === 'pdf') bg-rose-50 text-rose-600 border border-rose-100
                                        @elseif(in_array($doc->file_type, ['ppt', 'pptx'])) bg-amber-50 text-amber-600 border border-amber-100
                                        @elseif(in_array($doc->file_type, ['doc', 'docx'])) bg-blue-50 text-blue-600 border border-blue-100
                                        @else bg-slate-100 text-slate-700 @endif">
                                        {{ $doc->file_type }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 line-clamp-1">{{ $doc->title }}</p>
                                        <p class="text-[10px] text-slate-400">by ហឿន មិនា | ICT</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-[11px] font-medium">
                                    {{ $doc->category->name }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">{{ $doc->academic_year }}</td>
                            <td class="py-3.5 px-4 font-mono text-slate-500">{{ $doc->file_size }}</td>
                            <td class="py-3.5 px-4 text-center">
                                @if($doc->is_portfolio)
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-semibold">បង្ហាញ</span>
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-5 text-right space-x-1 whitespace-nowrap">
                                @if(in_array($doc->file_type, ['pdf', 'jpg', 'jpeg', 'png', 'webp']))
                                    <a href="/documents/{{ $doc->id }}/preview" target="_blank" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg inline-block" title="មើល">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                @endif
                                <a href="/documents/{{ $doc->id }}/download" class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-lg inline-block" title="ទាញយក">
                                    <i class="fa-solid fa-download"></i>
                                </a>
                                <button type="button" class="edit-doc-btn p-1.5 text-amber-600 hover:bg-amber-50 rounded-lg" title="កែប្រែ">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                                <form action="/documents/{{ $doc->id }}" method="POST" class="inline-block" onsubmit="return confirm('តើលោកគ្រូ ហឿន មិនា ពិតជាចង់លុបឯកសារ «{{ $doc->title }}» នេះមែនទេ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg" title="លុប">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- 5. Pagination (if exists) -->
    @if($recentDocuments->hasPages())
        <div class="px-4 py-3 bg-white rounded-2xl border border-slate-200">
            {{ $recentDocuments->links() }}
        </div>
    @endif

</div>

<!-- 6. Upload Modal Dialog -->
<dialog id="uploadDialog" closedby="any" aria-labelledby="dialog-title" class="p-0 rounded-3xl bg-white shadow-2xl border border-slate-200/90 w-full max-w-lg mx-auto my-auto overflow-hidden">
    <div class="flex flex-col">
        
        <!-- Header -->
        <div class="px-6 py-5 bg-gradient-to-r from-blue-700 via-blue-600 to-teal-600 text-white flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center">
                    <i class="fa-solid fa-cloud-arrow-up text-sm"></i>
                </div>
                <div>
                    <h3 id="dialog-title" class="font-khmer-muol text-base text-white">បញ្ចូលឯកសារការងារថ្មី</h3>
                    <p class="text-[11px] text-blue-100">គ្រប់គ្រង និងរៀបចំដោយ ហឿន មិនា | ICT</p>
                </div>
            </div>
            
            <button type="button" id="closeUploadDialogBtn" class="text-white/80 hover:text-white p-2 rounded-xl hover:bg-white/10 transition">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Form (action="/documents" relative path) -->
        <form action="/documents" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf

            <!-- 1. Document Title -->
            <div>
                <label for="title" class="block text-xs font-semibold text-slate-700 mb-1.5">ចំណងជើងឯកសារ <span class="text-rose-500">*</span></label>
                <input type="text" name="title" id="title" required placeholder="ឧ. ការអប់រំ STEAM តាមរយៈ ICT" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-xs text-slate-800 transition">
            </div>

            <!-- 2. Category & Academic Year -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="category_id" class="block text-xs font-semibold text-slate-700 mb-1.5">ប្រភេទឯកសារ <span class="text-rose-500">*</span></label>
                    <select name="category_id" id="category_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-xs text-slate-800 transition">
                        <option value="">-- សូមជ្រើសរើសប្រភេទ --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="academic_year" class="block text-xs font-semibold text-slate-700 mb-1.5">ឆ្នាំសិក្សា <span class="text-rose-500">*</span></label>
                    <input type="text" name="academic_year" id="academic_year" required value="2024-2025" placeholder="ឧ. 2024-2025" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-xs text-slate-800 transition">
                </div>
            </div>

            <!-- 3. Drag & Drop File Zone -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">ជ្រើសរើស File ឯកសារ <span class="text-rose-500">*</span></label>
                <div id="dropZone" class="group relative flex flex-col items-center justify-center p-6 border-2 border-dashed border-slate-200 hover:border-blue-500 bg-slate-50/60 hover:bg-blue-50/30 rounded-2xl transition cursor-pointer text-center">
                    <div class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center text-blue-600 mb-2 group-hover:scale-110 transition">
                        <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                    </div>
                    <p class="text-xs font-semibold text-slate-700 group-hover:text-blue-600 transition">
                        ចុចទីនេះ ឬអូសទម្លាក់ File ចូលទីនេះ
                    </p>
                    <p class="text-[11px] text-slate-400 mt-1">
                        ទទួលស្គាល់ PDF, Word, PowerPoint, Excel, Images (ទំហំអតិបរមា 30MB)
                    </p>

                    <!-- Selected File Info Pill -->
                    <div id="selectedFileInfo" class="hidden mt-3 inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-100 text-blue-900 text-xs font-medium">
                        <i class="fa-solid fa-file-circle-check text-blue-600"></i>
                        <span id="selectedFileName"></span>
                        <span id="selectedFileSize" class="text-blue-500 text-[10px]"></span>
                    </div>

                    <input id="document_file" name="document_file" type="file" required class="hidden" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.jpg,.jpeg,.png,.webp,.zip">
                </div>
            </div>

            <!-- 4. Description Field -->
            <div>
                <label for="description" class="block text-xs font-semibold text-slate-700 mb-1.5">ការបរិយាយសង្ខេប (ស្រេចចិត្ត)</label>
                <textarea name="description" id="description" rows="2" placeholder="ព័ត៌មានលម្អិតបន្ថែមអំពីឯកសារនេះ..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none text-xs text-slate-800 transition"></textarea>
            </div>

            <!-- 5. Portfolio Toggle -->
            <label class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 border border-slate-200 cursor-pointer hover:bg-slate-100/70 transition">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center">
                        <i class="fa-solid fa-medal text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-800">កំណត់ជាឯកសារស្នាដៃ (Portfolio)</p>
                        <p class="text-[11px] text-slate-400">បង្ហាញជាសាធារណៈលើទំព័រ Showcase ស្នាដៃរបស់លោកគ្រូ ហឿន មិនា</p>
                    </div>
                </div>
                <input type="checkbox" name="is_portfolio" id="is_portfolio" value="1" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-slate-300">
            </label>

            <!-- Buttons -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-end space-x-3">
                <button type="button" id="cancelUploadDialogBtn" class="px-5 py-2.5 text-xs font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition">
                    បោះបង់
                </button>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 active:scale-95 text-white text-xs font-semibold rounded-xl shadow-md transition">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>រក្សាទុកឯកសារ</span>
                </button>
            </div>
        </form>

    </div>
</dialog>

<!-- 7. Edit Modal Dialog -->
<dialog id="editDialog" closedby="any" aria-labelledby="edit-dialog-title" class="p-0 rounded-3xl bg-white shadow-2xl border border-slate-200/90 w-full max-w-lg mx-auto my-auto overflow-hidden">
    <div class="flex flex-col">
        <!-- Header -->
        <div class="px-6 py-5 bg-gradient-to-r from-amber-600 to-amber-700 text-white flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center">
                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                </div>
                <div>
                    <h3 id="edit-dialog-title" class="font-khmer-muol text-base text-white">កែប្រែព័ត៌មានឯកសារ</h3>
                    <p class="text-[11px] text-amber-100">ធ្វើបច្ចុប្បន្នភាពព័ត៌មានឯកសារការងារ</p>
                </div>
            </div>
            
            <button type="button" id="closeEditDialogBtn" class="text-white/80 hover:text-white p-2 rounded-xl hover:bg-white/10 transition">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Edit Form -->
        <form id="editDocumentForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <!-- Edit Title -->
            <div>
                <label for="edit_title" class="block text-xs font-semibold text-slate-700 mb-1.5">ចំណងជើងឯកសារ <span class="text-rose-500">*</span></label>
                <input type="text" name="title" id="edit_title" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none text-xs text-slate-800 transition">
            </div>

            <!-- Edit Category & Year -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="edit_category_id" class="block text-xs font-semibold text-slate-700 mb-1.5">ប្រភេទឯកសារ <span class="text-rose-500">*</span></label>
                    <select name="category_id" id="edit_category_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none text-xs text-slate-800 transition">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="edit_academic_year" class="block text-xs font-semibold text-slate-700 mb-1.5">ឆ្នាំសិក្សា <span class="text-rose-500">*</span></label>
                    <input type="text" name="academic_year" id="edit_academic_year" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none text-xs text-slate-800 transition">
                </div>
            </div>

            <!-- Edit Description -->
            <div>
                <label for="edit_description" class="block text-xs font-semibold text-slate-700 mb-1.5">ការបរិយាយសង្ខេប</label>
                <textarea name="description" id="edit_description" rows="2" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none text-xs text-slate-800 transition"></textarea>
            </div>

            <!-- Edit Portfolio Toggle -->
            <label class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 border border-slate-200 cursor-pointer hover:bg-slate-100/70 transition">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center">
                        <i class="fa-solid fa-medal text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-800">កំណត់ជាឯកសារស្នាដៃ (Portfolio)</p>
                        <p class="text-[11px] text-slate-400">បង្ហាញជាសាធារណៈលើទំព័រ Portfolio</p>
                    </div>
                </div>
                <input type="checkbox" name="is_portfolio" id="edit_is_portfolio" value="1" class="w-4 h-4 rounded text-amber-600 focus:ring-amber-500 border-slate-300">
            </label>

            <!-- Actions -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-end space-x-3">
                <button type="button" id="cancelEditDialogBtn" class="px-5 py-2.5 text-xs font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition">
                    បោះបង់
                </button>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-amber-600 hover:bg-amber-700 active:scale-95 text-white text-xs font-semibold rounded-xl shadow transition">
                    <i class="fa-solid fa-check"></i>
                    <span>ធ្វើបច្ចុប្បន្នភាព</span>
                </button>
            </div>
        </form>
    </div>
</dialog>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Upload Dialog
        const uploadDialog = document.getElementById('uploadDialog');
        const openUploadBtn = document.getElementById('openUploadDialogBtn');
        const closeUploadBtn = document.getElementById('closeUploadDialogBtn');
        const cancelUploadBtn = document.getElementById('cancelUploadDialogBtn');

        if (openUploadBtn && uploadDialog) {
            openUploadBtn.addEventListener('click', () => uploadDialog.showModal());
        }

        const closeUploadModal = () => { if (uploadDialog) uploadDialog.close(); };
        if (closeUploadBtn) closeUploadBtn.addEventListener('click', closeUploadModal);
        if (cancelUploadBtn) cancelUploadBtn.addEventListener('click', closeUploadModal);

        // 2. Edit Dialog
        const editDialog = document.getElementById('editDialog');
        const closeEditBtn = document.getElementById('closeEditDialogBtn');
        const cancelEditBtn = document.getElementById('cancelEditDialogBtn');
        const editForm = document.getElementById('editDocumentForm');
        const editTitle = document.getElementById('edit_title');
        const editCategory = document.getElementById('edit_category_id');
        const editYear = document.getElementById('edit_academic_year');
        const editDesc = document.getElementById('edit_description');
        const editPortfolio = document.getElementById('edit_is_portfolio');

        document.querySelectorAll('.edit-doc-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const card = btn.closest('.document-item-card') || btn.closest('.document-row-item');
                const docId = card.getAttribute('data-id');
                const title = card.getAttribute('data-title');
                const catId = card.getAttribute('data-category-id');
                const year = card.getAttribute('data-academic-year');
                const desc = card.getAttribute('data-description');
                const isPort = card.getAttribute('data-is-portfolio') === '1';

                editForm.action = `/documents/${docId}`;
                editTitle.value = card.querySelector('h4')?.textContent.trim() || card.querySelector('.font-bold.text-slate-900')?.textContent.trim() || '';
                editCategory.value = catId;
                editYear.value = year;
                editDesc.value = desc;
                editPortfolio.checked = isPort;

                editDialog.showModal();
            });
        });

        const closeEditModal = () => { if (editDialog) editDialog.close(); };
        if (closeEditBtn) closeEditBtn.addEventListener('click', closeEditModal);
        if (cancelEditBtn) cancelEditBtn.addEventListener('click', closeEditModal);

        // Light dismiss for dialogs
        [uploadDialog, editDialog].forEach(dlg => {
            if (dlg && !('closedBy' in HTMLDialogElement.prototype)) {
                const outside = (e, targetDlg) => {
                    const r = targetDlg.getBoundingClientRect();
                    return e.clientX < r.left || e.clientX > r.right || e.clientY < r.top || e.clientY > r.bottom;
                };
                let pressedOutside = false;
                dlg.addEventListener('pointerdown', (e) => { pressedOutside = outside(e, dlg); });
                dlg.addEventListener('pointerup', (e) => { if (pressedOutside && outside(e, dlg)) dlg.close(); });
            }
        });

        // 3. Drag & Drop File Handling
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('document_file');
        const selectedFileInfo = document.getElementById('selectedFileInfo');
        const selectedFileName = document.getElementById('selectedFileName');
        const selectedFileSize = document.getElementById('selectedFileSize');

        if (dropZone && fileInput) {
            dropZone.addEventListener('click', () => fileInput.click());

            ['dragenter', 'dragover'].forEach(evt => {
                dropZone.addEventListener(evt, (e) => {
                    e.preventDefault();
                    dropZone.classList.add('border-blue-500', 'bg-blue-50/50');
                });
            });

            ['dragleave', 'drop'].forEach(evt => {
                dropZone.addEventListener(evt, (e) => {
                    e.preventDefault();
                    dropZone.classList.remove('border-blue-500', 'bg-blue-50/50');
                });
            });

            dropZone.addEventListener('drop', (e) => {
                if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                    fileInput.files = e.dataTransfer.files;
                    updateFileDisplay(e.dataTransfer.files[0]);
                }
            });

            fileInput.addEventListener('change', () => {
                if (fileInput.files && fileInput.files.length > 0) {
                    updateFileDisplay(fileInput.files[0]);
                }
            });

            function updateFileDisplay(file) {
                if (!file) return;
                selectedFileName.textContent = file.name;
                const sizeKb = (file.size / 1024).toFixed(1);
                selectedFileSize.textContent = `(${sizeKb >= 1024 ? (sizeKb / 1024).toFixed(2) + ' MB' : sizeKb + ' KB'})`;
                selectedFileInfo.classList.remove('hidden');
            }
        }

        // 4. Instant Search & Filtering
        const searchInput = document.getElementById('searchInput');
        const searchClearBtn = document.getElementById('searchClearBtn');
        const resultsCountDisplay = document.getElementById('resultsCountDisplay');
        const pillBtns = document.querySelectorAll('.category-pill-btn');
        const cards = document.querySelectorAll('.document-item-card');
        const tableRows = document.querySelectorAll('.document-row-item');

        let activeCategory = 'all';
        let searchQuery = '';

        function runFilter() {
            let visibleCount = 0;

            const filterItem = (el) => {
                const catId = el.getAttribute('data-category-id');
                const title = el.getAttribute('data-title') || '';
                const desc = (el.getAttribute('data-description') || '').toLowerCase();

                let matchesCat = false;
                if (activeCategory === 'all') {
                    matchesCat = true;
                } else if (activeCategory === 'ict') {
                    matchesCat = true; // ICT is the overarching subject
                } else {
                    matchesCat = (catId === activeCategory);
                }

                const matchesSearch = !searchQuery || title.includes(searchQuery) || desc.includes(searchQuery);

                if (matchesCat && matchesSearch) {
                    el.style.display = '';
                    return true;
                } else {
                    el.style.display = 'none';
                    return false;
                }
            };

            cards.forEach(card => {
                if (filterItem(card)) visibleCount++;
            });

            tableRows.forEach(row => {
                filterItem(row);
            });

            if (resultsCountDisplay) {
                resultsCountDisplay.textContent = `${visibleCount} លទ្ធផល`;
            }

            if (searchClearBtn) {
                if (searchQuery.length > 0) {
                    searchClearBtn.classList.remove('hidden');
                } else {
                    searchClearBtn.classList.add('hidden');
                }
            }
        }

        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                searchQuery = e.target.value.toLowerCase().trim();
                runFilter();
            });
        }

        if (searchClearBtn) {
            searchClearBtn.addEventListener('click', () => {
                searchInput.value = '';
                searchQuery = '';
                runFilter();
                searchInput.focus();
            });
        }

        pillBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                pillBtns.forEach(b => {
                    b.classList.remove('active', 'bg-[#1d3557]', 'text-white');
                    b.classList.add('bg-white', 'text-slate-700');
                });

                btn.classList.add('active', 'bg-[#1d3557]', 'text-white');
                btn.classList.remove('bg-white', 'text-slate-700');

                activeCategory = btn.getAttribute('data-category');
                runFilter();
            });
        });

        // Subtab helper
        window.filterByCategoryName = (keyword) => {
            searchInput.value = keyword;
            searchQuery = keyword.toLowerCase();
            runFilter();
        };

        window.setSubTab = (tab) => {
            document.querySelectorAll('.subtab-item').forEach(t => {
                t.classList.remove('active', 'text-blue-700', 'border-b-2', 'border-blue-700', 'font-semibold');
                t.classList.add('text-slate-500');
            });
            const activeTab = document.getElementById(`subtab-${tab}`);
            if (activeTab) {
                activeTab.classList.add('active', 'text-blue-700', 'border-b-2', 'border-blue-700', 'font-semibold');
                activeTab.classList.remove('text-slate-500');
            }
            if (tab === 'books') {
                searchInput.value = '';
                searchQuery = '';
                runFilter();
            }
        };

        // 5. Switch View (Grid vs Table)
        window.switchView = (mode) => {
            const gridView = document.getElementById('bookGridView');
            const tableView = document.getElementById('tableView');
            const gridBtn = document.getElementById('gridModeBtn');
            const tableBtn = document.getElementById('tableModeBtn');

            if (mode === 'grid') {
                gridView.classList.remove('hidden');
                tableView.classList.add('hidden');
                gridBtn.classList.add('bg-white', 'text-blue-700', 'shadow-sm', 'font-semibold');
                gridBtn.classList.remove('text-slate-600', 'font-medium');
                tableBtn.classList.remove('bg-white', 'text-blue-700', 'shadow-sm', 'font-semibold');
                tableBtn.classList.add('text-slate-600', 'font-medium');
            } else {
                gridView.classList.add('hidden');
                tableView.classList.remove('hidden');
                tableBtn.classList.add('bg-white', 'text-blue-700', 'shadow-sm', 'font-semibold');
                tableBtn.classList.remove('text-slate-600', 'font-medium');
                gridBtn.classList.remove('bg-white', 'text-blue-700', 'shadow-sm', 'font-semibold');
                gridBtn.classList.add('text-slate-600', 'font-medium');
            }
        };
    });
</script>
@endpush
