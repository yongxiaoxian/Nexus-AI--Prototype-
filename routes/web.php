<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ChatbotController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/features', [PageController::class, 'features'])->name('features');
Route::get('/pricing', [PageController::class, 'pricing'])->name('pricing');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/demo', [PageController::class, 'demo'])->name('demo');
Route::get('/demo/ocr', [PageController::class, 'ocr'])->name('demo.ocr');

Route::post('/api/chat', [ChatbotController::class, 'chat'])->name('api.chat');
Route::post('/api/ocr', [ChatbotController::class, 'ocrAnalyze'])->name('api.ocr');
