<?php

declare(strict_types=1);

use App\Http\Controllers\ConversationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::resource('members', MemberController::class)->only(['index']);
    Route::post('/members/{member}/conversations', [ConversationController::class, 'store'])
        ->name('members.conversations.store');
    Route::resource('conversations', ConversationController::class)->only(['index', 'show']);
    Route::resource('conversations.messages', MessageController::class)->only(['store']);
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';
