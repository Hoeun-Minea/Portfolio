<?php

use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

// 1. ផ្ទាំងគ្រប់គ្រងទូទៅ (Dashboard)
Route::get('/', [DocumentController::class, 'index'])->name('dashboard');

// 2. Route សម្រាប់ទទួល Upload ឯកសារ
Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');

// 3. Route សម្រាប់ទាញយកឯកសារ (Download)
Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');

// 4. Route សម្រាប់លុបឯកសារ
Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

// 5. ទំព័រ Portfolio សាធារណៈ សម្រាប់ដាក់ពាក្យការងារ
Route::get('/portfolio', [DocumentController::class, 'portfolio'])->name('portfolio.public');
