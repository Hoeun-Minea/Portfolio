<?php

use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

// 1. ផ្ទាំងគ្រប់គ្រងទូទៅ (Dashboard)
Route::get('/', [DocumentController::class, 'index'])->name('dashboard');

// 2. Route សម្រាប់បង្ហាញព័ត៌មាន និង Preview ឯកសារ (ដូច sala.moeys.gov.kh)
Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');

// 3. Route សម្រាប់ Upload ឯកសារ
Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');

// 4. Route សម្រាប់កែប្រែឯកសារ
Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');

// 5. Route សម្រាប់ទាញយកឯកសារ (Download)
Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');

// 6. Route សម្រាប់ Raw File Stream / Preview ឯកសារផ្ទាល់
Route::get('/documents/{document}/preview', [DocumentController::class, 'preview'])->name('documents.preview');
Route::get('/documents/{document}/raw', [DocumentController::class, 'preview'])->name('documents.raw');

// 7. Route សម្រាប់លុបឯកសារ
Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

// 8. ទំព័រ Portfolio សាធារណៈ សម្រាប់ដាក់ពាក្យការងារ
Route::get('/portfolio', [DocumentController::class, 'portfolio'])->name('portfolio.public');
