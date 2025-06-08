<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Verified;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

# トップページ（商品一覧）
Route::get('/', [ItemController::class, 'index'])->name('home');

# ゲスト専用（会員登録／ログイン）
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'store'])->name('register');

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

# 認証ユーザー専用
Route::middleware('auth')->group(function () {

    // マイページ・プロフィール
    Route::get('/mypage', [UserController::class, 'index'])->name('mypage');
    //初回プロフィール設定・保存
    Route::get('/mypage/profile/setup', [UserController::class, 'setup'])->name('profile.setup');
    Route::post('/mypage/profile/setup', [UserController::class, 'storeProfile'])->name('profile.store');
    //
    Route::get('/mypage/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [UserController::class, 'update'])->name('profile.update');
    // 出品関連
    Route::get('/sell', [ItemController::class, 'create'])->name('item.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('item.store');
});
