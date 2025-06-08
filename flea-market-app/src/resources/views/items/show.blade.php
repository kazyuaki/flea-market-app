@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show/index.css' )}}">
@endsection
<main>
    <div class="item-detail">
        <div class="item-detail__image-box">
            <div class="item-detail__image">
                <img src="#" alt="商品画像">
            </div>
        </div>

        <div class="item-detail__info">
            <section class="item-purchase">
                <h2 class="item-title">商品名がここに入る</h2>
                <p class="item-brand">ブランド名</p>
                <div class="item-price">
                    <p>¥47,000</p>
                    <p class="tax">（税込）</p>
                </div>
                <div class="item-reactions">
                    <button class="reaction-favorite">★</button>
                    <button class="reaction-comment">💬</button>
                </div>

                <div class="item-purchase__button">
                    <button>購入手続きへ</button>
                </div>
            </section>

            <section class="item-info">
                <h3>商品説明</h3>
                <p>カラー：グレー</p>
                <p>
                    新品<br>
                    商品の状態は良好です。傷もありません。<br><br>
                    購入後、即発送いたします。
                </p>
            </section>

            <section class="item-details">
                <h3>商品の情報</h3>
                <table>
                    <tr>
                        <th>カテゴリ</th>
                        <td>洋服 メンズ</td>
                    </tr>
                    <tr>
                        <th>商品の状態</th>
                        <td>良好</td>
                    </tr>
                </table>
            </section>

            <section class="item-comments">
                <h3>コメント（1）</h3>
                <div class="comment">
                    <img class="comment__avatar" src="#" alt="ユーザー写真">
                    <p class="comment__user">admin</p>
                </div>
                <p class="comment__text">こちらにコメントが入ります。</p>

                <form class="comment-form">
                    <label for="comment">商品へのコメント</label>
                    <textarea id="comment" name="comment" rows="10"></textarea>
                    <button type="submit" class="comment-form__button">コメントを送信する</button>
                </form>
            </section>
        </div>
    </div>
</main>
@section('content')