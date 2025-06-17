<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PurchaseController;
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
Route::get('/', [ItemController::class, 'index'])->name('items.index');

Route::get('/item/{item}', [ItemController::class, 'show'])->name('item.show');

Route::post('/purchase/confirm/{item}', [PurchaseController::class, 'confirm'])->name('purchase.confirm');

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
    //２回目以降プロフィール編集・更新
    Route::get('/mypage/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [UserController::class, 'update'])->name('profile.update');

    // 出品
    Route::get('/sell', [ItemController::class, 'create'])->name('item.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('item.store');

    //配送先変更
    Route::get('/purchase/address/{item}', [PurchaseController::class, 'editAddress'])->name('purchase.address.edit');
    Route::post('/purchase/address/{item}', [PurchaseController::class, 'updateAddress'])->name('purchase.address.update');

    //いいね・コメント送信
    Route::post('/item/{item}/favorite', [FavoriteController::class, 'toggle'])->name('items.favorite');
    Route::post('/item/{item_id}/comment', [CommentController::class, 'store'])->name('comment.store');
});
