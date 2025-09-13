<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionMessageRequest;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\TransactionMessage;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);

        $user = Auth::user();
        $partner = $transaction->seller_id === $user->id ? $transaction->buyer : $transaction->seller;

        $messages = $transaction->messages()->with('user')->orderBy('created_at')->paginate(20);

        $transaction->messages()
            ->whereNull('read_at')
            ->where('user_id', '!=', $user->id)
            ->update(['read_at' => Carbon::now()]);

        $sidebar = \App\Models\Transaction::with(['item.images', 'seller', 'buyer'])
            ->where(fn($q)=>$q->where('seller_id',$user->id)->orWhere('buyer_id', $user->id))
            ->where('status', 'ongoing')
            ->withCount(['messages as unread_count' => fn($q) => $q->whereNull('read_at')->where('user_id', '!=', $user->id)])
            ->orderByDesc('last_message_at')
            ->get();

        return view('transactions.show', compact('transaction','partner','messages','sidebar'));
    }

    public function store(StoreTransactionMessageRequest $request, Transaction $transaction)
    {
        $this->authorize('message', $transaction);

        $data = $request->validated();

        $imagePath = null;
        if($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chat_images', 'public');
        }

        TransactionMessage::create([
            'transaction_id' => $transaction->id,
            'user_id' => Auth::id(),
            'body' => $data['body'],
            'image_path' => $imagePath,
        ]);

        $transaction->update(['last_message_at' => Carbon::now()]);
    }
}
