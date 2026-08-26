<?php

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

Route::middleware('auth')->group(function () {
    Route::get('/admin', fn () => ' 管理者一覧（準備中）')->name('admin.index');
    Route::get('/categories', fn () => 'カテゴリー一覧（準備中）')->name('categories.index');
});
