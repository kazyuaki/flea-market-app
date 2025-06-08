 @extends('layouts/app')

 @section('css')
 <link rel="stylesheet" href="{{ asset('css/items/index.css' )}}">
 @endsection

 @section('content')
 <div class="tab-menu">
     <a href="{{ url('/') }}" class="tab {{ $activeTab === 'recommend' ? 'active' : '' }}">おすすめ</a>
     <a href="{{ url('/?tab=sell') }}" class="tab {{ $activeTab === 'sell' ? 'active' : '' }}">マイリスト</a>
 </div>

 <div class="item-list">
     @forelse($items as $item)
     <div class="item">
         <img src="{{ asset('storage/' . $item->img) }}" alt="商品画像">
         <div class="item-name">{{ $item->name }}</div>
     </div>
     @empty
        <p> @if($activeTab === 'recommend')
                お気に入りにした登録はありません。
            @else
                出品した商品はありません。
            @endif
        </p>
    @endforelse
 </div>
 @endsection('content')