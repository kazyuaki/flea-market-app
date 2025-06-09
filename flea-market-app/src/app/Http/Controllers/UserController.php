<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\ProfileRequest;


class UserController extends Controller
{
    //プロフィール未設定の場合　初期設定画面にリダイレクト
    public function setup()
    {
        $user = Auth::user();

        if ($user->is_profile_set) {
            return redirect('/');
        }

        return view('user.setup', compact('user'));
    }

    public function storeProfile(ProfileRequest $request)
    {
        $user = Auth::user();

        $user->name = $request->name;
        $user->post_code = $request->post_code;
        $user->address = $request->address;
        $user->building_name = $request->building_name;

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile', 'public');
            $user->profile_image = $path;
        }

        $user->is_profile_set = true;
        $user->save();

        return redirect('/')->with('status', 'プロフィールを設定しました！');
    }

    // プロフィール画面（閲覧用） /mypage/index
    public function index(Request $request)
    {
        $user = auth()->user();
        $tab = $request->query('tab');

        if ($tab === 'buy') {
            $items = $user->purchasedItems()->latest()->get();
            $activeTab = 'buy';
        } elseif ($tab === 'sell') {
            $items = $user->items()->latest()->get();
            $activeTab = 'sell';
        } else {
            $items = [];
            $activeTab = 'profile';
        }
        return view('user.index', compact('user', 'items', 'activeTab'));
    }

    // プロフィール編集フォーム
    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    // プロフィール更新処理（POST） /mypage/edit
    public function update(ProfileRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->fill($request->only(['name']));

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $user->profile_image = $path;
        }

        $user->is_profile_set = true;
        $user->save();

        return redirect('/mypage')->with('status', 'プロフィールを更新しました！');
    }
}
