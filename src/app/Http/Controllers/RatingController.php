<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRatingRequest;
use App\Models\Rating;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    public function store(StoreRatingRequest $request, Transaction $transaction)
    {
        $user = Auth::user();

        if ($transaction->seller_id !== $user->id && $transaction->buyer_id !== $user->id) {
            abort(403);
        }

        $rateeId = $transaction->seller_id === $user->id
            ? $transaction->buyer_id
            : $transaction->seller_id;

        // 二重投稿チェック
        $already = Rating::where('transaction_id', $transaction->id)
            ->where('rater_id', $user->id)
            ->exists();
        if ($already) {
            return back()->with('status', 'すでに評価済みです。');
        }

        // 評価登録
        Rating::create([
            'transaction_id' => $transaction->id,
            'rater_id'       => $user->id,
            'ratee_id'       => $rateeId,
            'score'          => (int) $request->input('score'),
        ]);

        // 取引ステータス更新
        if ($transaction->status !== 'completed') {
            $transaction->update(['status' => 'completed']);
        }

        return redirect()
            ->route(Route::has('items.index') ? 'items.index' : 'mypage')
            ->with('status', '評価を送信しました。');
    }
}
