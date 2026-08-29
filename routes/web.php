<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::middleware('auth')->prefix('admin')->group(function () {
    // お問い合わせ一覧
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    // お問い合わせ詳細
    Route::get('/contacts/{contact}', [AdminController::class, 'show'])->name('admin.show');
    // お問い合わせ削除
    Route::delete('/contacts/{contact}', [AdminController::class, 'destroy'])->name('admin.destroy');
    // お問い合わせ作成（準備中）
    Route::get('/contacts/create', fn () => 'お問い合わせ作成（準備中）')->name('contacts.create');
    // カテゴリー一覧（準備中）
    Route::get('/categories', fn () => 'カテゴリー一覧（準備中）')->name('categories.index');
});
