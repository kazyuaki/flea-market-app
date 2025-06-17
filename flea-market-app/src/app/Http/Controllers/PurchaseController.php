<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;


class PurchaseController extends Controller
{
    public function confirm(Item $item)
    {
        return view('purchase.confirm', compact('item'));
    }

    public function editAddress(Item $item)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        return view('purchase.address', compact('item', 'user'));
    }

    public function updateAddress(AddressRequest $request, Item $item)
    {

        // /** @var \App\Models\User $user */
        // $user = auth()->user();

        // $user->update([
        //     'post_code' => $request->post_code,
        //     'address' => $request->address,
        //     'building_name' => $request->building_name,
        // ]);

        // return redirect()->route('purchase.confirm', ['item' => $item->id])->with('status', '住所情報を更新しました');
        
        dd('リクエスト到達！');
    }
    
}
