@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user/index.css' )}}">
@endsection

@section('content')
<main>
    <div class="mypage__content">
        <div class="mypage__profile">
            <div class="user">
                <img class="user__avatar" src="{{ asset('storage/' . $user->profile_image) }}" alt="ユーザー写真">
                <h2>{{ $user->name }}</h2>
            </div>
            <div class="profile__button">
                <a href="{{ route('profile.edit') }}" class="profile__button-submit">プロフィールを編集</a>
            </div>
        </div>


        <nav class="nav">
            <a href="/mypage?tab=sell" class="{{ $activeTab === 'sell' ? 'active' : '' }}">出品した商品</a>
            <a href="/mypage?tab=buy" class="{{ $activeTab === 'buy' ? 'active' : '' }}">購入した商品</a>
        </nav>

        <div class="item-list">
            @forelse($items as $item)
            <div class="item">
                <img src="{{ asset('storage/' . $item->img) }}" alt="商品画像">
                <div class="item-name">{{ $item->name }}</div>
            </div>
            @empty
            @if ($activeTab === 'buy')
            <p>購入した商品はまだありません。</p>
            @elseif ($activeTab === 'sell')
            <p>出品した商品はまだありません。</p>
            @else
            <p>表示する商品がありません。</p>
            @endif
            @endforelse
        </div>
    </div>
</main>
@endsection