<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Str;
// use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Item;
// use App\Models\Order;


class ItemController extends Controller
{
    //商品一覧
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $tab = $request->query('tab');
        $keyword = $request->query('keyword');

        if ($tab === 'mylist') {
            if (!auth()->check()) {
                $items = collect();
            } else {
                $items = $user->favorites()
                    ->where('items.user_id', '!=', $user->id)
                    ->when($keyword, function ($query, $keyword) {
                        $query->where('name', 'like', '%' . $keyword . '%');
                    })
                    ->with('images')
                    ->latest()
                    ->get();
            }
            $activeTab = 'mylist';
        } else {
            $items = Item::when($keyword, function ($query, $keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
                ->when(auth()->check(), function ($query) use ($user) {
                    $query->where('user_id', '!=', $user->id);
                })
                ->with('images')
                ->latest()
                ->get();
            $activeTab = 'recommend';
        }

        //購入したitem_id一覧
        $purchasedItemIds = auth()->check()
            ? $user->orders()->pluck('item_id')->toArray()
            : [];

        return view('items.index', compact('items', 'activeTab', 'purchasedItemIds'));
    }

    //商品詳細画面の表示
    public function show(Item $item)
    {

        //ルートで$item を受け取っている場合（暗黙の結合）
        $item->load(['categories', 'favorites', 'comments.user', 'images','order']);
        return view('items.show', compact('item'));
    }

    //商品出品画面の表示
    public function create()
    {
        $categories = Category::all();

        return view('items.create', compact('categories'));
    }
    //出品商品の情報を保存
    public function store(ExhibitionRequest $request)
    {
        $item = Item::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'brand' => $request->brand,
            'price' => $request->price,
            'detail' => $request->detail,
            'condition' => $request->condition,
        ]);
        // カテゴリーの中間テーブルへ登録
        $item->categories()->sync($request->categories);

        // 画像を保存
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('items', 'public');
                $item->images()->create(['file_path' => $path]);
            }
        }

        return redirect('/')->with('status', '商品を出品しました！');
    }
}
