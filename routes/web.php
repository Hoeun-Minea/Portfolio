<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

// 1. ផ្ទាំងគ្រប់គ្រងទូទៅ (Dashboard) - សាធារណៈអាចមើលបាន
Route::get('/', [DocumentController::class, 'index'])->name('dashboard');

// 2. Route សម្រាប់បង្ហាញព័ត៌មាន និង Preview ឯកសារ (ដូច sala.moeys.gov.kh)
Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');

// 3. Route សម្រាប់ទាញយកឯកសារ (Download)
Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');

// 4. Route សម្រាប់ Raw File Stream / Preview ឯកសារផ្ទាល់
Route::get('/documents/{document}/preview', [DocumentController::class, 'preview'])->name('documents.preview');
Route::get('/documents/{document}/raw', [DocumentController::class, 'preview'])->name('documents.raw');

// 5. ទំព័រ Portfolio សាធារណៈ សម្រាប់ដាក់ពាក្យការងារ
Route::get('/portfolio', [DocumentController::class, 'portfolio'])->name('portfolio.public');

// --- AUTHENTICATION (Google, Telegram, Teacher Login) ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
Route::get('/auth/telegram/callback', [AuthController::class, 'handleTelegramCallback'])->name('auth.telegram.callback');
Route::get('/auth/quick-teacher', [AuthController::class, 'quickTeacherLogin'])->name('auth.quick-teacher');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- PROTECTED ACTIONS (ទាមទារចូលគណនី Auth: Upload, Edit, Delete) ---
Route::middleware('auth')->group(function () {
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
});

