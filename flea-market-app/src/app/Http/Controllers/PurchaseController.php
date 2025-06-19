<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function confirm(Request $request, Item $item)
    {
        if ($request->isMethod('post')) {
            $payment_method = $request->input('payment_method');
            session(['payment_method' => $payment_method]);
            return redirect()->route('purchase.confirm', ['item' => $item->id]);
        }

        $user = auth()->user();
        $payment_method = session('payment_method', '未選択'); // セッションから取得

        return view('purchase.confirm', compact('item', 'user', 'payment_method'));
    }

    public function editAddress(Item $item)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        return view('purchase.address', compact('item', 'user'));
    }

    public function updateAddress(AddressRequest $request, Item $item)
    {

        /** @var \App\Models\User $user */
        $user = auth()->user();

        $user->update([
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building_name' => $request->building_name,
        ]);

        return redirect()
            ->route('purchase.confirm', ['item' => $item->id])
            ->with('status', '住所情報を更新しました')
            ->with('payment_method', '未選択'); // ← セッションに入れて渡す
    }

    public function complete(Request $request, Item $item)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $methodMap = [
            'コンビニ払い' => 1,
            'カード払い' =>2
        ];

        $payment_method_str = session('payment_method', '未選択');
        $payment_method = $methodMap[$payment_method_str] ?? null;

        if($payment_method === null) {
            return redirect()->back()->withErrors('支払い方法が無効です');
        }

        $user->orders()->create([
            'item_id' => $item->id,
            'payment_method' => $payment_method,
            'shipping_post_code' => $user->post_code,
            'shipping_address' => $user->address,
            'shipping_building' => $user->building_name,
        ]);

        // セッション削除（任意）
        $request->session()->forget('payment_method');

        return redirect()->route('items.index')->with('status', '購入が完了しました！');
    }
}
