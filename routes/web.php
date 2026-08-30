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

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/logout', function () {
    return view('auth.logout');
})->name('logout');

Route::middleware('auth')->prefix('admin')->group(function () {

    // 管理画面トップ（一覧）
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.contacts.index');

    // お問い合わせ詳細ページ
    Route::get('/contacts/{contact}', [AdminController::class, 'show'])->name('admin.contacts.show');

    // 管理画面検索
    Route::get('/query', [AdminController::class, 'query'])->name('admin.query');

    // お問い合わせ削除
    Route::delete('/contacts/{contact}', [AdminController::class, 'destroy'])->name('admin.contacts.destroy');
});
