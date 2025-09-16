@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/transactions/show.css') }}">
@endsection

@section('content')
<div id="transaction-root" class="transaction-wrap" data-transaction-id="{{ $transaction->id }}">
    <aside class="transaction-side">
        <div class="transaction-side__title">その他の取引</div>
        @foreach ($sidebarTransactions as $sidebarTx)
        @php
        $partnerOfSidebar = $sidebarTx->seller_id === auth()->id()
        ? $sidebarTx->buyer
        : $sidebarTx->seller;
        $thumb = optional($sidebarTx->item->images->first())->file_path;
        @endphp

        <a href="{{ route('transactions.show', $sidebarTx->id) }}"
            class="transaction-side__link {{ $sidebarTx->id === $transaction->id ? 'is-active' : '' }}">
            <img class="transaction-thumb"
                src="{{ $thumb && Str::startsWith($thumb,'http')
                            ? $thumb
                            : ($thumb ? asset('storage/'.$thumb) : asset('storage/default.png')) }}"
                alt="">
            <div class="transaction-side__meta">
                <div class="transaction-item-name">{{ $sidebarTx->item->name }}</div>
                <div class="transaction-partner">{{ $partnerOfSidebar->name }}</div>
            </div>
            @if($sidebarTx->unread_count > 0)
            <span class="transaction-badge">{{ $sidebarTx->unread_count }}</span>
            @endif
        </a>
        @endforeach
    </aside>

    <section class="transaction-main">

        <header class="transaction-head">
            <div class="transaction-head__left">
                <div class="transaction-head__avatar"></div>
                <div class="transaction-head__titles">
                    <div class="transaction-head__heading">
                        「{{ $partner->name }}」さんとの取引画面
                    </div>
                    <div class="transaction-head-time">
                        {{ optional($transaction->last_message_at)->diffForHumans() }}
                    </div>
                </div>
            </div>

            @if($transaction->buyer_id === auth()->id())
            {{-- 購入者側：完了ボタンを表示 --}}
            <a href="#complete-modal" class="transaction-finish-btn">取引を完了する</a>
            @else
            {{-- 出品者側：評価モーダルを表示 --}}
            <div id="complete-modal" class="modal" aria-modal="true" role="dialog">
                <div class="modal__dialog">
                    <h3 class="modal__title">取引が完了しました。</h3>

                    <form method="post" action="{{ route('transactions.ratings.store', $transaction->id) }}" class="rating-form">
                        @csrf
                        <div class="modal__rating">
                            <p class="modal__caption">今回の取引相手はどうでしたか？</p>

                            <div class="stars" role="radiogroup" aria-label="評価を選択">
                                <input type="radio" id="star5" name="score" value="5" required>
                                <label for="star5" title="5">★</label>

                                <input type="radio" id="star4" name="score" value="4">
                                <label for="star4" title="4">★</label>

                                <input type="radio" id="star3" name="score" value="3">
                                <label for="star3" title="3">★</label>

                                <input type="radio" id="star2" name="score" value="2">
                                <label for="star2" title="2">★</label>

                                <input type="radio" id="star1" name="score" value="1">
                                <label for="star1" title="1">★</label>
                            </div>
                        </div>

                        <div class="modal__actions">
                            <button type="submit" class="modal__primary">送信する</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </header>

        <div class="transaction-product">
            @php
            $mainThumb = optional($transaction->item->images->first())->file_path;
            @endphp
            <img class="transaction-product__image"
                src="{{ $mainThumb && Str::startsWith($mainThumb,'http')
                        ? $mainThumb
                        : ($mainThumb ? asset('storage/'.$mainThumb) : asset('storage/default.png')) }}"
                alt="">
            <div class="transaction-product__info">
                <div class="transaction-product__name">{{ $transaction->item->name }}</div>
                <div class="transaction-product__price">¥{{ number_format($transaction->item->price) }}</div>
            </div>
        </div>

        <div class="transaction-thread">
            @foreach ($messages as $message)
            @php
            $isMine = $message->user_id === auth()->id();
            $avatar = optional($message->user)->profile_image
            ? asset('storage/'.$message->user->profile_image)
            : asset('img/noimage.png');
            @endphp

            <div class="message-row {{ $isMine ? 'is-me' : 'is-other' }}">
                <div class="message-user">
                    <img class="message-avatar" src="{{ $avatar }}" alt="">
                    <div class="message-username">{{ $message->user->name }}</div>
                </div>

                <div class="message-content">
                    <div class="message-bubble">
                        @if (session('edit_message_id') == $message->id)
                        <form class="message-edit"
                            method="post"
                            action="{{ route('transactions.messages.update', [$transaction->id, $message->id]) }}">
                            @csrf
                            @method('PATCH')
                            <input type="text" name="body"
                                value="{{ old('body', $message->body) }}"
                                maxlength="400" required>
                            <div class="message-edit__actions">
                                <button type="submit" class="message-action-link">保存</button>
                                <a href="{{ route('transactions.show', $transaction->id) }}"
                                    class="message-action-link">キャンセル</a>
                            </div>
                        </form>
                        @else
                        <div class="message-body">{{ $message->body }}</div>
                        @if ($message->image_path)
                        <img class="message-image"
                            src="{{ Str::startsWith($message->image_path,'http')
                                                ? $message->image_path
                                                : asset('storage/'.$message->image_path) }}"
                            alt="">
                        @endif
                        @endif
                    </div>

                    @if ($isMine && session('edit_message_id') != $message->id)
                    <div class="message-actions-row {{ $isMine ? 'is-me' : '' }}">
                        <form method="post"
                            action="{{ route('transactions.messages.edit', [$transaction->id, $message->id]) }}">
                            @csrf
                            <button type="submit" class="message-action-link">編集</button>
                        </form>
                        <form method="post"
                            action="{{ route('transactions.messages.destroy', [$transaction->id, $message->id]) }}"
                            onsubmit="return confirm('このメッセージを削除しますか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="message-action-link">削除</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach

            {{ $messages->links() }}
        </div>

        <form id="transaction-form"
            class="transaction-form"
            method="post"
            enctype="multipart/form-data"
            action="{{ route('transactions.messages.store', $transaction->id) }}">
            @csrf
            <div class="transaction-form__row">
                @error('body')
                <p class="form-error">{{ $message }}</p>
                @enderror
                <input id="message-input"
                    class="transaction-form__input"
                    type="text"
                    name="body"
                    placeholder="取引メッセージを記入してください"
                    maxlength="400"
                    value="{{ old('body') }}">

                <div class="transaction-form__controls">
                    @error('image')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                    <label class="transaction-form__upload">
                        画像を追加
                        <input type="file" name="image" accept="image/png,image/jpeg" hidden>
                    </label>

                    <button type="submit" class="transaction-form__send" title="送信" aria-label="送信">
                        <img src="{{ asset('img/input-button.png') }}" alt="" class="transaction-form__send-icon">
                    </button>
                </div>
            </div>
        </form>
    </section>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const autoOpen = @json(!empty($autoOpenRatingModal) && $autoOpenRatingModal);
        if (autoOpen && location.hash !== '#complete-modal') {
            location.hash = '#complete-modal';
        }
    });
</script>
<script src="{{ asset('js/transaction.js') }}"></script>
@endsection