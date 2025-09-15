<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRatingRequest;
use App\Models\Rating;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class RatingController extends Controller
{
    public function store(StoreRatingRequest $request, Transaction $transaction)
    {
        $user = Auth::user();

        // 当事者チェック
        if ($transaction->seller_id !== $user->id && $transaction->buyer_id !== $user->id) {
            abort(403);
        }

        // 2重投稿を防止
        $already = Rating::where('transaction_id', $transaction->id)
            ->where('rater_id', $user->id)
            ->exists();

        if ($already) {
            return redirect()
                ->route('transactions.show', $transaction->id)
                ->with('status', 'この取引の評価は送信済みです。');
        }

        // 相手を特定
        $rateeId = $transaction->seller_id === $user->id
            ? $transaction->buyer_id
            : $transaction->seller_id;

        // 保存
        Rating::create([
            'transaction_id' => $transaction->id,
            'rater_id'       => $user->id,
            'ratee_id'       => $rateeId,
            'score'          => $request->input('score'),
        ]);

        // 商品一覧へリダイレクト（なければマイページ）
        $redirectRoute = Route::has('items.index') ? 'items.index' : 'mypage';
        return redirect()->route($redirectRoute)->with('status', '評価を送信しました。');
    }
}


