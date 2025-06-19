<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flea market</title>
    <link rel="stylesheet" href="{{ asset('css/app.common.css')}}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__logo">
                <img src="../../img/logo.svg" alt="COACHTECH" width="350">
            </div>
            <div class="search-bar">
                <input type="text" placeholder="なにをお探しですか？">
            </div>
            <div class="nav-links">
                @auth
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="logout-button">ログアウト</button>
                </form>
                <a href="/mypage">マイページ</a>

                <a href="/sell" class="sell-button">出品</a>
                @endauth

                @guest
                <a href="/login">ログイン</a>
                <a href="/mypage">マイページ</a> {{-- ← 表示だけしておく --}}
                <a href="/sell" class="sell-button">出品</a>
                @endguest
            </div>
        </div>
    </header>
        @yield('content')
</body>

</html>