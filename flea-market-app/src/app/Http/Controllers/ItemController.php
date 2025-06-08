<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Item;
use App\Models\User;

class ItemController extends Controller
{

    public function index(Request $request)
    {
        if ($request->query('tab') === 'sell') {
            // 自分が出品した商品だけ
            $items = Item::where('user_id', auth()->id())->latest()->get();
            $activeTab = 'sell';
        } else {
            // お気に入りに登録した商品だけ
            $items = auth()->user()->favorites()->latest()->get();
            $activeTab = 'recommend';
        }

        return view('items.index', compact('items', 'activeTab'));
    }

    public function create()
    {

        $categories = Category::all();

        return view('items.create', compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        $item = Item::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'brand' => $request->brand,
            'price' => $request->price,
            'detail' => $request->detail,
            'condition' => $request->condition,
            'img' => $request->hasFile('img')
                ? $request->file('img')->store('items', 'public')
                : null,
        ]);
        // カテゴリーの中間テーブルへ登録
        $item->categories()->sync($request->categories);

        return redirect('/')->with('status', '商品を出品しました！');
    }
}
