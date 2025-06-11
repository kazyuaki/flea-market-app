 @extends('layouts/app')

 @section('css')
 <link rel="stylesheet" href="{{ asset('css/items/index.css' )}}">
 @endsection

 @section('content')
 <div class="tab-menu">
     <a href="{{ route('items.index') }}" class="tab-link {{ $activeTab === 'recommend' ? 'active' : '' }}">おすすめ</a>
     <a href="{{ route('items.index', ['tab' => 'mylist']) }}" class="tab-link {{ $activeTab === 'mylist' ? 'active' : '' }}">マイリスト</a>
 </div>

 <div class="item-list">
     @forelse($items as $item)
     <div class="item">
         <a href="{{ route('item.show', ['item' => $item->id]) }}">
             @if (Str::startsWith($item->img, 'http'))
             <img src="{{ $item->img }}" alt="商品画像">
             @else
             <img src="{{ asset('storage/' . $item->img) }}" alt="商品画像">
             @endif
             <div class="item-name">{{ $item->name }}</div>
         </a>
     </div>
     @empty
     <p>
         @if($activeTab === 'recommend')
         お気に入りにした登録はありません。
         @else
         出品した商品はありません。
         @endif
     </p>
     @endforelse
 </div>
 @endsection