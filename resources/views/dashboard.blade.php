@extends('layouts.app')

@section('title', 'ផ្ទាំងគ្រប់គ្រងឯកសារគ្រូ')

@section('content')
    <!-- ផ្នែកក្បាល និងប៊ូតុងបើក Modal -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-6 border-b border-slate-200 gap-4">
        <div>
            <h2 class="font-khmer-muol text-2xl text-blue-900 leading-normal">ផ្ទាំងគ្រប់គ្រង និងឯកសារបង្រៀន</h2>
            <p class="text-slate-500 text-sm mt-1">គ្រប់គ្រងភ័ស្តុតាងការងារ កិច្ចតែងការ និងស្នាដៃវិជ្ជាជីវៈផ្ទាល់ខ្លួន</p>
        </div>
        <div>
            <!-- ប៊ូតុង + បញ្ចូលឯកសារថ្មី -->
            <button id="openModalBtn" type="button" class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition hover:shadow focus:ring-2 focus:ring-blue-400">
                <i class="fa-solid fa-circle-plus mr-2 text-base"></i>
                + បញ្ចូលឯកសារថ្មី
            </button>
        </div>
    </div>

    <!-- ១. កាតបង្ហាញតួលេខស្ថិតិ (Statistics Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 my-8">
        <!-- កាតឯកសារសរុប -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">ឯកសារសរុបទាំងអស់</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $totalDocuments }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-xl">
                <i class="fa-solid fa-folder-open"></i>
            </div>
        </div>

        <!-- កាតឯកសារ Portfolio -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">ស្នាដៃ (Portfolio) បង្ហាញ</p>
                <h3 class="text-3xl font-bold text-emerald-600 mt-2">{{ $totalPortfolios }}</h3>
            </div>
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center text-xl">
                <i class="fa-solid fa-medal"></i>
            </div>
        </div>

        <!-- កាតចំនួនប្រភេទឯកសារ -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">ប្រភេទឯកសារសរុប</p>
                <h3 class="text-3xl font-bold text-indigo-600 mt-2">{{ $categories->count() }}</h3>
            </div>
            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center text-xl">
                <i class="fa-solid fa-layer-group"></i>
            </div>
        </div>
    </div>

    <!-- ស្ថិតិឯកសារតាមប្រភេទនីមួយៗ -->
    <div class="mb-8">
        <h4 class="font-khmer-muol text-sm text-slate-700 mb-3">ស្ថិតិតាមប្រភេទ</h4>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
            @foreach($categories as $category)
                <div class="bg-white p-3.5 rounded-lg border border-slate-200 text-center">
                    <p class="text-xs text-slate-500 truncate" title="{{ $category->name }}">{{ $category->name }}</p>
                    <p class="text-lg font-bold text-blue-700 mt-1">{{ $category->documents_count }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- ២. តារាងបញ្ជីឯកសារថ្មីៗ (Recent Documents Table) -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h3 class="font-khmer-muol text-base text-blue-900">បញ្ជីឯកសារថ្មីៗ</h3>
            <span class="text-xs text-slate-500">បង្ហាញ {{ $recentDocuments->count() }} នៃ {{ $totalDocuments }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200">
                        <th class="py-3 px-6">ចំណងជើងឯកសារ</th>
                        <th class="py-3 px-4">ប្រភេទ</th>
                        <th class="py-3 px-4">ឆ្នាំសិក្សា</th>
                        <th class="py-3 px-4">ទំហំ</th>
                        <th class="py-3 px-4 text-center">Portfolio</th>
                        <th class="py-3 px-6 text-right">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentDocuments as $doc)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-6 font-medium text-slate-900 flex items-center space-x-3">
                                <!-- Icon តាមកន្ទុយ File -->
                                @if(in_array($doc->file_type, ['pdf']))
                                    <i class="fa-solid fa-file-pdf text-red-500 text-xl"></i>
                                @elseif(in_array($doc->file_type, ['doc', 'docx']))
                                    <i class="fa-solid fa-file-word text-blue-500 text-xl"></i>
                                @elseif(in_array($doc->file_type, ['ppt', 'pptx']))
                                    <i class="fa-solid fa-file-powerpoint text-amber-500 text-xl"></i>
                                @else
                                    <i class="fa-solid fa-file-lines text-slate-400 text-xl"></i>
                                @endif
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $doc->title }}</p>
                                    @if($doc->description)
                                        <p class="text-xs text-slate-400 truncate max-w-xs">{{ $doc->description }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-700 text-xs rounded-full font-medium">
                                    {{ $doc->category->name }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 text-xs">{{ $doc->academic_year }}</td>
                            <td class="py-3.5 px-4 text-slate-500 text-xs">{{ $doc->file_size }}</td>
                            <td class="py-3.5 px-4 text-center">
                                @if($doc->is_portfolio)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-100 text-emerald-800">
                                        <i class="fa-solid fa-check mr-1 text-[10px]"></i> បង្ហាញ
                                    </span>
                                @else
                                    <span class="text-slate-400 text-xs">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-6 text-right space-x-2">
                                <!-- Download Button -->
                                <a href="{{ route('documents.download', $doc) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 px-2 py-1 text-xs font-medium bg-blue-50 rounded hover:bg-blue-100 transition" title="ទាញយក">
                                    <i class="fa-solid fa-download mr-1"></i> ទាញយក
                                </a>

                                <!-- Delete Form Button -->
                                <form action="{{ route('documents.destroy', $doc) }}" method="POST" class="inline-block" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបឯកសារនេះមែនទេ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700 p-1 rounded hover:bg-rose-50 text-xs transition" title="លុប">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">
                                <i class="fa-solid fa-folder-open text-4xl mb-2 text-slate-300 block"></i>
                                មិនទាន់មានឯកសារនៅឡើយទេ។ សូមចុចប៊ូតុង "+ បញ្ចូលឯកសារថ្មី" ដើម្បីបញ្ចូល!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($recentDocuments->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $recentDocuments->links() }}
            </div>
        @endif
    </div>

    <!-- ៣. Upload Modal (Tailwind + Vanilla JS) -->
    <div id="uploadModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-xl overflow-hidden transform transition-all">
            
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-blue-700 text-white flex items-center justify-between">
                <h3 class="font-khmer-muol text-base">បញ្ចូលឯកសារការងារថ្មី</h3>
                <button type="button" id="closeModalBtn" class="text-blue-200 hover:text-white transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf

                <!-- ១. ចំណងជើងឯកសារ -->
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-1">ចំណងជើងឯកសារ <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="title" required placeholder="ឧ. កិច្ចតែងការគណិតវិទ្យា ថ្នាក់ទី១០" class="w-full px-3.5 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                </div>

                <!-- ២. ប្រភេទឯកសារ និង ឆ្នាំសិក្សា (Grid ២ ជួរ) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-slate-700 mb-1">ប្រភេទឯកសារ <span class="text-rose-500">*</span></label>
                        <select name="category_id" id="category_id" required class="w-full px-3.5 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                            <option value="">-- សូមជ្រើសរើស --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="academic_year" class="block text-sm font-medium text-slate-700 mb-1">ឆ្នាំសិក្សា <span class="text-rose-500">*</span></label>
                        <input type="text" name="academic_year" id="academic_year" required value="2024-2025" placeholder="ឧ. 2024-2025" class="w-full px-3.5 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
                    </div>
                </div>

                <!-- ៣. ជ្រើសរើស File -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">ជ្រើសរើស File ឯកសារ <span class="text-rose-500">*</span></label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-lg hover:border-blue-500 transition cursor-pointer" onclick="document.getElementById('document_file').click();">
                        <div class="space-y-1 text-center">
                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-400"></i>
                            <div class="flex text-sm text-slate-600 justify-center">
                                <span class="text-blue-600 font-semibold hover:underline">ជ្រើសរើសឯកសារ</span>
                            </div>
                            <p class="text-xs text-slate-500">PDF, Word, PPTX, Excel (ទំហំអតិបរមា 20MB)</p>
                            <p id="fileNameDisplay" class="text-xs text-blue-600 font-medium mt-2 hidden"></p>
                        </div>
                    </div>
                    <input id="document_file" name="document_file" type="file" required class="hidden" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.jpg,.jpeg,.png">
                </div>

                <!-- ៤. បរិយាយបន្ថែម -->
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1">ការបរិយាយសង្ខេប (Optional)</label>
                    <textarea name="description" id="description" rows="2" placeholder="ព័ត៌មានលម្អិតបន្ថែមអំពីឯកសារ..." class="w-full px-3.5 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm"></textarea>
                </div>

                <!-- ៥. Checkbox កំណត់ជា Portfolio -->
                <div class="flex items-center space-x-3 bg-blue-50 p-3 rounded-lg border border-blue-200">
                    <input type="checkbox" name="is_portfolio" id="is_portfolio" value="1" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                    <label for="is_portfolio" class="text-sm font-medium text-blue-900 cursor-pointer">
                        កំណត់ជា "ឯកសារស្នាដៃ (Portfolio)" សម្រាប់បង្ហាញជាសាធារណៈ
                    </label>
                </div>

                <!-- Modal Actions -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                    <button type="button" id="cancelModalBtn" class="px-4 py-2 text-sm text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition">
                        បោះបង់
                    </button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                        <i class="fa-solid fa-save mr-1.5"></i> រក្សាទុកឯកសារ
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Vanilla JavaScript សម្រាប់គ្រប់គ្រង Modal
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('uploadModal');
        const openBtn = document.getElementById('openModalBtn');
        const closeBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelModalBtn');
        const fileInput = document.getElementById('document_file');
        const fileNameDisplay = document.getElementById('fileNameDisplay');

        // បើក Modal
        if (openBtn) {
            openBtn.addEventListener('click', () => {
                modal.classList.remove('hidden');
            });
        }

        // បិទ Modal
        const closeModal = () => {
            modal.classList.add('hidden');
        };

        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

        // បិទ Modal នៅពេលចុចលើផ្ទៃខាងក្រៅ (Backdrop)
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });

        // បង្ហាញឈ្មោះឯកសារដែលបានជ្រើសរើស
        if (fileInput) {
            fileInput.addEventListener('change', () => {
                if (fileInput.files.length > 0) {
                    fileNameDisplay.textContent = 'ឯកសារដែលបានរើស៖ ' + fileInput.files[0].name;
                    fileNameDisplay.classList.remove('hidden');
                } else {
                    fileNameDisplay.classList.add('hidden');
                }
            });
        }
    });
</script>
@endpush
