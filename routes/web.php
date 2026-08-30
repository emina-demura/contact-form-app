<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// お問い合わせフォーム（一般ユーザが利用）
// お問い合わせフォーム入力ページ（GET /）
Route::get('/', [ContactController::class, 'index'])->name('contacts.index');

// お問い合わせフォーム確認ページ（POST /contacts/confirm）
Route::post('/contacts/confirm', [ContactController::class, 'confirm'])->name('contacts.confirm');

// 完了サンクスページ（GET /thanks）
Route::get('/thanks', [ContactController::class, 'thanks'])->name('contacts.thanks');

// 検索（ユーザー側）
Route::get('/contacts/search', [ContactController::class, 'search'])->name('contacts.search');

// ログインとログイン後のページ（管理者が利用）
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
