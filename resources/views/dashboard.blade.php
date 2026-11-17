@extends('layouts.app')

@section('title', 'ផ្ទាំងគ្រប់គ្រងឯកសារ — ហឿន មិនា | ICT')

@section('content')
<div class="space-y-8">

    <!-- Hero Banner with Greeting and Teacher Info -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-950 via-primary-950 to-primary-900 text-white p-6 sm:p-8 lg:p-10 shadow-xl border border-slate-800">
        <!-- Background decorative ambient circles -->
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-primary-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/3 -bottom-20 w-80 h-80 bg-indigo-500/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="max-w-2xl space-y-3">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs text-primary-200 font-medium">
                    <i class="fa-solid fa-laptop-code text-amber-300"></i>
                    <span>គ្រប់គ្រង និងរៀបចំដោយ ហឿន មិនា | ICT</span>
                </div>
                <h2 class="font-khmer-muol text-2xl sm:text-3xl text-white leading-normal">
                    សួស្តីលោកគ្រូ ហឿន មិនា!
                </h2>
                <p class="text-sm sm:text-base text-slate-300 font-normal leading-relaxed">
                    គ្រប់គ្រងភ័ស្តុតាងការងារ កិច្ចតែងការបង្រៀនព័ត៌មានវិទ្យា (ICT) ស្លាយមេរៀន ឯកសាររដ្ឋបាល និងរៀបចំ Portfolio ផ្ទាល់ខ្លួនប្រកបដោយវិជ្ជាជីវៈ។
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <button type="button" id="openUploadDialogBtn" class="inline-flex items-center space-x-2.5 px-6 py-3.5 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-400 text-white text-sm font-semibold rounded-2xl shadow-lg shadow-primary-700/40 hover:shadow-xl hover:shadow-primary-600/50 hover:-translate-y-0.5 active:translate-y-0 active:scale-95 transition-all duration-200">
                    <i class="fa-solid fa-cloud-arrow-up text-lg"></i>
                    <span>+ បញ្ចូលឯកសារថ្មី</span>
                </button>
            </div>
        </div>
    </div>

    <!-- 1. Statistics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        
        <!-- Total Documents -->
        <div class="group relative overflow-hidden bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">ឯកសារសរុប</span>
                    <h3 class="text-3xl font-extrabold text-slate-900 mt-2 tracking-tight">{{ $totalDocuments }}</h3>
                    <p class="text-xs text-slate-400 mt-1 flex items-center gap-1">
                        <i class="fa-solid fa-file-lines text-primary-500"></i> ឯកសារបានផ្ទុកទាំងអស់
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-primary-50 text-primary-600 flex items-center justify-center text-2xl shadow-sm border border-primary-100 group-hover:scale-110 group-hover:bg-primary-600 group-hover:text-white transition duration-300">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
            </div>
        </div>

        <!-- Portfolio Documents -->
        <div class="group relative overflow-hidden bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">ស្នាដៃ Portfolio</span>
                    <h3 class="text-3xl font-extrabold text-emerald-600 mt-2 tracking-tight">{{ $totalPortfolios }}</h3>
                    <p class="text-xs text-slate-400 mt-1 flex items-center gap-1">
                        <i class="fa-solid fa-award text-emerald-500"></i> បង្ហាញជាសាធារណៈ
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl shadow-sm border border-emerald-100 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition duration-300">
                    <i class="fa-solid fa-medal"></i>
                </div>
            </div>
        </div>

        <!-- Categories Count -->
        <div class="group relative overflow-hidden bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200 sm:col-span-2 lg:col-span-1">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-indigo-600 uppercase tracking-wider">ប្រភេទឯកសារ</span>
                    <h3 class="text-3xl font-extrabold text-indigo-700 mt-2 tracking-tight">{{ $categories->count() }}</h3>
                    <p class="text-xs text-slate-400 mt-1 flex items-center gap-1">
                        <i class="fa-solid fa-tags text-indigo-500"></i> ប្រភេទនៃការបង្រៀន ICT
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl shadow-sm border border-indigo-100 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition duration-300">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Category Pills Quick Filter -->
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <h4 class="font-khmer-muol text-sm text-slate-700">ស្ថិតិ និងច្រោះតាមប្រភេទឯកសារ</h4>
            <span class="text-xs text-slate-400">ចុចដើម្បីច្រោះមើល</span>
        </div>
        
        <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
            <button type="button" data-category="all" class="category-filter-btn active inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold bg-primary-600 text-white shadow-sm border border-primary-600 transition flex-shrink-0">
                <i class="fa-solid fa-border-all"></i>
                <span>ទាំងអស់</span>
                <span class="px-2 py-0.5 rounded-full bg-white/20 text-white text-[10px]">{{ $totalDocuments }}</span>
            </button>

            @foreach($categories as $cat)
                <button type="button" data-category="{{ $cat->id }}" class="category-filter-btn inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold bg-white text-slate-700 hover:bg-slate-100 hover:text-primary-700 border border-slate-200/80 shadow-sm transition flex-shrink-0">
                    <span>{{ $cat->name }}</span>
                    <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px]">{{ $cat->documents_count }}</span>
                </button>
            @endforeach
        </div>
    </div>

    <!-- 2. Recent Documents Table Section -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        
        <!-- Table Toolbar & Instant Search Bar -->
        <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/50">
            <div>
                <h3 id="documents-table-title" class="font-khmer-muol text-lg text-slate-900">បញ្ជីឯកសារ និងស្នាដៃការងារ</h3>
                <p class="text-xs text-slate-500 mt-0.5">ឯកសារការងារដែលបានផ្ទុកក្នុងប្រព័ន្ធដោយ ហឿន មិនា | ICT</p>
            </div>

            <!-- Instant Search Input -->
            <div class="flex items-center gap-3">
                <div class="relative w-full sm:w-72">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" id="searchInput" placeholder="ស្វែងរកតាមចំណងជើង..." class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500 transition shadow-sm">
                </div>
            </div>
        </div>

        <!-- Accessible Responsive Table Wrapper (Modern Web Guidance) -->
        <div tabindex="0" role="region" aria-labelledby="documents-table-title" class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 text-xs font-semibold border-b border-slate-200/80">
                        <th scope="col" class="py-4 px-6">ឯកសារ</th>
                        <th scope="col" class="py-4 px-4">ប្រភេទ</th>
                        <th scope="col" class="py-4 px-4">ឆ្នាំសិក្សា</th>
                        <th scope="col" class="py-4 px-4">ទំហំ</th>
                        <th scope="col" class="py-4 px-4 text-center">Portfolio</th>
                        <th scope="col" class="py-4 px-6 text-right">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody id="documentsTableBody" class="divide-y divide-slate-100">
                    @forelse($recentDocuments as $doc)
                        <tr class="document-row hover:bg-slate-50/70 transition duration-150" 
                            data-category-id="{{ $doc->category_id }}" 
                            data-title="{{ strtolower($doc->title) }}"
                            data-id="{{ $doc->id }}"
                            data-academic-year="{{ $doc->academic_year }}"
                            data-description="{{ $doc->description ?? '' }}"
                            data-is-portfolio="{{ $doc->is_portfolio ? '1' : '0' }}">
                            
                            <!-- Document Title & Icon -->
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-3.5">
                                    <!-- Dynamic File Icon based on extension -->
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm border 
                                        @if($doc->file_type === 'pdf') bg-rose-50 border-rose-100 text-rose-600
                                        @elseif(in_array($doc->file_type, ['doc', 'docx'])) bg-blue-50 border-blue-100 text-blue-600
                                        @elseif(in_array($doc->file_type, ['ppt', 'pptx'])) bg-amber-50 border-amber-100 text-amber-600
                                        @elseif(in_array($doc->file_type, ['xls', 'xlsx'])) bg-emerald-50 border-emerald-100 text-emerald-600
                                        @else bg-slate-50 border-slate-200 text-slate-500 @endif">
                                        
                                        @if($doc->file_type === 'pdf')
                                            <i class="fa-solid fa-file-pdf text-lg"></i>
                                        @elseif(in_array($doc->file_type, ['doc', 'docx']))
                                            <i class="fa-solid fa-file-word text-lg"></i>
                                        @elseif(in_array($doc->file_type, ['ppt', 'pptx']))
                                            <i class="fa-solid fa-file-powerpoint text-lg"></i>
                                        @elseif(in_array($doc->file_type, ['xls', 'xlsx']))
                                            <i class="fa-solid fa-file-excel text-lg"></i>
                                        @else
                                            <i class="fa-solid fa-file-lines text-lg"></i>
                                        @endif
                                    </div>

                                    <div class="min-w-0">
                                        <p class="font-semibold text-slate-900 truncate max-w-sm hover:text-primary-600 transition">{{ $doc->title }}</p>
                                        @if($doc->description)
                                            <p class="text-xs text-slate-400 truncate max-w-sm mt-0.5">{{ $doc->description }}</p>
                                        @else
                                            <p class="text-[11px] text-slate-400 mt-0.5">ផ្ទុកឡើងកាលពី {{ $doc->created_at->format('d/m/Y') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Category Badge -->
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200/60">
                                    {{ $doc->category->name }}
                                </span>
                            </td>

                            <!-- Academic Year -->
                            <td class="py-4 px-4 text-xs font-medium text-slate-600">
                                <span class="inline-flex items-center gap-1">
                                    <i class="fa-regular fa-calendar text-[10px] text-slate-400"></i>
                                    {{ $doc->academic_year }}
                                </span>
                            </td>

                            <!-- File Size -->
                            <td class="py-4 px-4 text-xs font-mono text-slate-500">
                                {{ $doc->file_size }}
                            </td>

                            <!-- Portfolio Indicator -->
                            <td class="py-4 px-4 text-center">
                                @if($doc->is_portfolio)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                        <i class="fa-solid fa-circle-check text-[10px] text-emerald-500"></i> បង្ហាញ
                                    </span>
                                @else
                                    <span class="text-slate-300 text-xs">-</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-right space-x-1.5 whitespace-nowrap">
                                <!-- Preview Button (for PDF & images) -->
                                @if(in_array($doc->file_type, ['pdf', 'jpg', 'jpeg', 'png', 'webp']))
                                    <a href="{{ route('documents.preview', $doc) }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition border border-indigo-200/60 shadow-sm" title="មើលឯកសារផ្ទាល់">
                                        <i class="fa-solid fa-eye text-[11px]"></i>
                                        <span class="hidden sm:inline">មើល</span>
                                    </a>
                                @endif

                                <!-- Download Button -->
                                <a href="{{ route('documents.download', $doc) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-semibold text-primary-700 bg-primary-50 hover:bg-primary-100 rounded-xl transition border border-primary-200/60 shadow-sm" title="ទាញយកឯកសារ">
                                    <i class="fa-solid fa-download text-[11px]"></i>
                                    <span class="hidden sm:inline">ទាញយក</span>
                                </a>

                                <!-- Edit Button -->
                                <button type="button" class="edit-doc-btn p-2 text-amber-600 hover:text-amber-800 hover:bg-amber-50 rounded-xl transition" title="កែប្រែព័ត៌មាន">
                                    <i class="fa-regular fa-pen-to-square text-sm"></i>
                                </button>

                                <!-- Delete Form Button -->
                                <form action="{{ route('documents.destroy', $doc) }}" method="POST" class="inline-block" onsubmit="return confirm('តើលោកគ្រូ ហឿន មិនា ពិតជាចង់លុបឯកសារ «{{ $doc->title }}» នេះមែនទេ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-xl transition" title="លុបឯកសារ">
                                        <i class="fa-regular fa-trash-can text-sm"></i>
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr id="noDocumentsRow">
                            <td colspan="6" class="py-16 text-center text-slate-400">
                                <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-300 mx-auto flex items-center justify-center text-3xl mb-3">
                                    <i class="fa-solid fa-folder-open"></i>
                                </div>
                                <h4 class="font-khmer-muol text-base text-slate-700 mb-1">មិនទាន់មានឯកសារនៅឡើយទេ</h4>
                                <p class="text-xs text-slate-400 mb-4">ចាប់ផ្តើមផ្ទុកឯកសារកិច្ចតែងការ ICT ឬស្នាដៃការងារដំបូងរបស់អ្នក</p>
                                <button type="button" onclick="document.getElementById('openUploadDialogBtn').click()" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white text-xs font-semibold rounded-xl hover:bg-primary-700 shadow-sm transition">
                                    <i class="fa-solid fa-cloud-arrow-up"></i> បញ្ចូលឯកសារឥឡូវនេះ
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($recentDocuments->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/40">
                {{ $recentDocuments->links() }}
            </div>
        @endif
    </div>

</div>

<!-- 3. Modern Accessible Native <dialog> Modal for Upload -->
<dialog id="uploadDialog" closedby="any" aria-labelledby="dialog-title" class="p-0 rounded-3xl bg-white shadow-2xl border border-slate-200/80 w-full max-w-xl mx-auto my-auto overflow-hidden">
    <div class="flex flex-col">
        
        <!-- Dialog Header -->
        <div class="px-6 py-5 bg-gradient-to-r from-slate-950 to-primary-950 text-white flex items-center justify-between border-b border-slate-800">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-primary-600/40 text-primary-300 flex items-center justify-center border border-primary-500/30">
                    <i class="fa-solid fa-cloud-arrow-up text-sm"></i>
                </div>
                <div>
                    <h3 id="dialog-title" class="font-khmer-muol text-base text-white">បញ្ចូលឯកសារការងារថ្មី</h3>
                    <p class="text-[11px] text-slate-400">គ្រប់គ្រង និងរៀបចំដោយ ហឿន មិនា | ICT</p>
                </div>
            </div>
            
            <button type="button" id="closeUploadDialogBtn" class="text-slate-400 hover:text-white p-2 rounded-xl hover:bg-white/10 transition">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Dialog Form -->
        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf

            <!-- 1. Document Title -->
            <div>
                <label for="title" class="block text-xs font-semibold text-slate-700 mb-1.5">ចំណងជើងឯកសារ <span class="text-rose-500">*</span></label>
                <input type="text" name="title" id="title" required placeholder="ឧ. កិច្ចតែងការបង្រៀនកុំព្យូទ័រ និងបណ្តាញ ថ្នាក់ទី១០" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none text-xs text-slate-800 transition">
            </div>

            <!-- 2. Category & Academic Year (Grid 2 cols) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="category_id" class="block text-xs font-semibold text-slate-700 mb-1.5">ប្រភេទឯកសារ <span class="text-rose-500">*</span></label>
                    <select name="category_id" id="category_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none text-xs text-slate-800 transition">
                        <option value="">-- សូមជ្រើសរើសប្រភេទ --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="academic_year" class="block text-xs font-semibold text-slate-700 mb-1.5">ឆ្នាំសិក្សា <span class="text-rose-500">*</span></label>
                    <input type="text" name="academic_year" id="academic_year" required value="2024-2025" placeholder="ឧ. 2024-2025" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none text-xs text-slate-800 transition">
                </div>
            </div>

            <!-- 3. Drag & Drop File Zone -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">ជ្រើសរើស File ឯកសារ <span class="text-rose-500">*</span></label>
                <div id="dropZone" class="group relative flex flex-col items-center justify-center p-6 border-2 border-dashed border-slate-200 hover:border-primary-500 bg-slate-50/60 hover:bg-primary-50/30 rounded-2xl transition cursor-pointer text-center">
                    <div class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center text-primary-500 mb-2 group-hover:scale-110 transition">
                        <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                    </div>
                    <p class="text-xs font-semibold text-slate-700 group-hover:text-primary-600 transition">
                        ចុចទីនេះ ឬអូសទម្លាក់ File ចូលទីនេះ
                    </p>
                    <p class="text-[11px] text-slate-400 mt-1">
                        ទទួលស្គាល់ PDF, Word, PowerPoint, Excel, Images (ទំហំអតិបរមា 30MB)
                    </p>

                    <!-- Selected File Info Pill -->
                    <div id="selectedFileInfo" class="hidden mt-3 inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-primary-100 text-primary-800 text-xs font-medium">
                        <i class="fa-solid fa-file-check text-primary-600"></i>
                        <span id="selectedFileName"></span>
                        <span id="selectedFileSize" class="text-primary-500 text-[10px]"></span>
                    </div>

                    <input id="document_file" name="document_file" type="file" required class="hidden" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.jpg,.jpeg,.png,.webp,.zip">
                </div>
            </div>

            <!-- 4. Description Field -->
            <div>
                <label for="description" class="block text-xs font-semibold text-slate-700 mb-1.5">ការបរិយាយសង្ខេប (Optional)</label>
                <textarea name="description" id="description" rows="2" placeholder="ព័ត៌មានលម្អិតបន្ថែមអំពីឯកសារនេះ..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none text-xs text-slate-800 transition"></textarea>
            </div>

            <!-- 5. Portfolio Checkbox Toggle Switch -->
            <label class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 cursor-pointer hover:bg-slate-100/60 transition">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center">
                        <i class="fa-solid fa-medal text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-800">កំណត់ជាឯកសារស្នាដៃ (Portfolio)</p>
                        <p class="text-[11px] text-slate-400">បង្ហាញជាសាធារណៈលើទំព័រ Showcase ស្នាដៃរបស់លោកគ្រូ ហឿន មិនា</p>
                    </div>
                </div>
                <input type="checkbox" name="is_portfolio" id="is_portfolio" value="1" class="w-4 h-4 rounded text-primary-600 focus:ring-primary-500 border-slate-300">
            </label>

            <!-- Dialog Action Buttons -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-end space-x-3">
                <button type="button" id="cancelUploadDialogBtn" class="px-5 py-2.5 text-xs font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition">
                    បោះបង់
                </button>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary-600 hover:bg-primary-700 active:scale-95 text-white text-xs font-semibold rounded-xl shadow-md shadow-primary-700/30 transition">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>រក្សាទុកឯកសារ</span>
                </button>
            </div>
        </form>

    </div>
</dialog>

<!-- 4. Edit Document Modal Dialog -->
<dialog id="editDialog" closedby="any" aria-labelledby="edit-dialog-title" class="p-0 rounded-3xl bg-white shadow-2xl border border-slate-200/80 w-full max-w-xl mx-auto my-auto overflow-hidden">
    <div class="flex flex-col">
        <!-- Edit Dialog Header -->
        <div class="px-6 py-5 bg-gradient-to-r from-slate-950 to-amber-950 text-white flex items-center justify-between border-b border-slate-800">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-amber-600/40 text-amber-300 flex items-center justify-center border border-amber-500/30">
                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                </div>
                <div>
                    <h3 id="edit-dialog-title" class="font-khmer-muol text-base text-white">កែប្រែព័ត៌មានឯកសារ</h3>
                    <p class="text-[11px] text-slate-400">ធ្វើបច្ចុប្បន្នភាពព័ត៌មានឯកសារការងារ</p>
                </div>
            </div>
            
            <button type="button" id="closeEditDialogBtn" class="text-slate-400 hover:text-white p-2 rounded-xl hover:bg-white/10 transition">
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
            <label class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 cursor-pointer hover:bg-slate-100/60 transition">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center">
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
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-amber-600 hover:bg-amber-700 active:scale-95 text-white text-xs font-semibold rounded-xl shadow-md shadow-amber-700/30 transition">
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
        // 1. Upload Dialog Management
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

        // 2. Edit Dialog Management
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
                const row = btn.closest('.document-row');
                const docId = row.getAttribute('data-id');
                const title = row.querySelector('.font-semibold.text-slate-900').textContent.trim();
                const catId = row.getAttribute('data-category-id');
                const year = row.getAttribute('data-academic-year');
                const desc = row.getAttribute('data-description');
                const isPort = row.getAttribute('data-is-portfolio') === '1';

                editForm.action = `/documents/${docId}`;
                editTitle.value = title;
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
                    dropZone.classList.add('border-primary-500', 'bg-primary-50/50');
                });
            });

            ['dragleave', 'drop'].forEach(evt => {
                dropZone.addEventListener(evt, (e) => {
                    e.preventDefault();
                    dropZone.classList.remove('border-primary-500', 'bg-primary-50/50');
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

        // 4. Instant Search & Category Filtering
        const searchInput = document.getElementById('searchInput');
        const filterBtns = document.querySelectorAll('.category-filter-btn');
        const documentRows = document.querySelectorAll('.document-row');

        let currentCategory = 'all';
        let searchQuery = '';

        function filterDocuments() {
            documentRows.forEach(row => {
                const rowCat = row.getAttribute('data-category-id');
                const rowTitle = row.getAttribute('data-title') || '';

                const matchesCat = (currentCategory === 'all' || rowCat === currentCategory);
                const matchesSearch = rowTitle.includes(searchQuery);

                if (matchesCat && matchesSearch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                searchQuery = e.target.value.toLowerCase().trim();
                filterDocuments();
            });
        }

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => {
                    b.classList.remove('bg-primary-600', 'text-white');
                    b.classList.add('bg-white', 'text-slate-700');
                });
                btn.classList.add('bg-primary-600', 'text-white');
                btn.classList.remove('bg-white', 'text-slate-700');

                currentCategory = btn.getAttribute('data-category');
                filterDocuments();
            });
        });
    });
</script>
@endpush
