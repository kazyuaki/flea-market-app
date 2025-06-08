@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/create.css' )}}">
@endsection

@section('content')
<div class="create">
    <div class="create__title">
        <h2>商品の出品</h2>
    </div>

    <form class="create__form" action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <h3 class="form-group__label">商品画像</h3>
            <div class="form-group__file">
                <label for="img" class="file-label">
                    画像を選択する
                    <input type="file" name="img" id="img" accept=".jpeg, .jpg, .png" hidden> </label>
            </div>
            @error('img')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-detail">
            <h3 class="form-section__heading">商品の詳細</h3>
            <div class="form-group">
                <h3>カテゴリー</h3>
                <div class="form-category">
                    @foreach ($categories as $category)
                    <input type="checkbox" id="cat{{ $category->id }}" name="categories[]" value="{{ $category->id }}" hidden>
                    <label for="cat{{ $category->id }}" class="category-label">{{ $category->content }}</label>
                    @endforeach
                </div>
                @error('categories')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-group__label" for="condition">商品の状態</label>
                <select name="condition" id="condition" class="form-group__select">
                    <option value="" selected disabled hidden>選択してください</option>
                    <option value="1">良好</option>
                    <option value="2">目立った傷や汚れなし</option>
                    <option value="3">やや傷や汚れあり</option>
                    <option value="4">状態が悪い</option>
                </select>
                @error('condition')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="form-title">
            <h3 class="form-section__heading">商品名と説明</h3>
            <div class="form-group">
                <label class="form-group__label" for="name">商品名</label>
                <input class="form-group__input" type="text" id="name" name="name">
                @error('name')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-group__label" for="brand">ブランド名</label>
                <input class="form-group__input" type="text" id="brand" name="brand">
            </div>

            <div class="form-group">
                <label class="form-group__label" for="detail">商品の説明</label>
                <textarea id="detail" name="detail" rows="6" class="form-group__textarea"></textarea>
                @error('detail')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-group__label" for="price">販売価格</label>
                <div class="form-group__price-wrapper">
                    <span class="form-group__yen">¥</span>
                    <input class="form-group__input" type="text" id="price" name="price">
                    @error('price')
                    <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <button class="create__button" type="submit">出品する</button>
        </div>
    </form>
</div>
</main>
@endsection