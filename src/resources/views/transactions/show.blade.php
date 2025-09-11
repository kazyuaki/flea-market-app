@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/transactions/show.css') }}">
@endsection

@section('content')
<div class="transaction-wrap">
    <aside class="transaction-side">
        @foreach($sidebar as $transactionItem)
        @php
        $partnerInSidebar = $transactionItem->seller_id === auth()->id()
        ? $transactionItem->buyer
        : $transactionItem->seller;
        $thumbnail = optional($transactionItem->item->images->first())->file_path;
        @endphp
        <a href="{{ route('transactions.show', $transactionItem->id) }}">
            <img class="transaction-thumb"
                src="{{ $thumbnail
                        ? (Str::startsWith($thumbnail,'http') ? $thumbnail : asset('storage/'.$thumbnail))
                        : asset('storage/default.png') }}"
                alt="商品画像">

            <div>
                <div class="transaction-item-name">{{ $transactionItem->item->name }}</div>
                <div class="transaction-partner">{{ $partnerInSidebar->name }}</div>
            </div>

            @if($transactionItem->unread_count > 0)
            <span class="transaction-badge">{{ $transactionItem->unread_count }}</span>
            @endif
        </a>
        @endforeach
    </aside>

    <section class="transaction-main">
        <div class="transaction-head">
            <div>
                <div class="transaction-head-title">{{ $transaction->item->name }}</div>
                <div class="transaction-head-partner">相手: {{ $partner->name }}</div>
            </div>
            <div class="transaction-head-time">
                {{ optional($transaction->last_message_at)->diffForHumans() }}
            </div>
        </div>

        <div class="transaction-thread">
            @foreach($messages as $message)
            <div class="msg {{ $message->user_id === auth()->id() ? 'me' : 'other' }}">
                <div class="msg-user">{{ $message->user->name }}</div>
                <div>{{ $message->body }}</div>

                @if($message->image_path)
                <img src="{{ Str::startsWith($message->image_path,'http')
                                    ? $message->image_path
                                    : asset('storage/'.$message->image_path) }}"
                    alt="添付画像">
                @endif

                <div class="msg-time">{{ $message->created_at->diffForHumans() }}</div>
            </div>
            @endforeach

            {{ $messages->links() }}
        </div>

        @if ($errors->any())
        <div class="form-errors">
            <ul>
                @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form class="transaction-form" method="post" enctype="multipart/form-data"
            action="{{ route('transactions.messages.store', $transaction->id) }}">
            @csrf
            <textarea name="body"
                placeholder="メッセージを入力（最大400文字）"
                maxlength="400"
                required>{{ old('body') }}</textarea>
            <input type="file" name="image" accept="image/png,image/jpeg">
            <button class="btn-primary">送信</button>
        </form>
    </section>
</div>
@endsection