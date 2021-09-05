<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('javascript')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link href="/css/layout.css" rel="stylesheet" />

</head>

<body>
    <div id="app">
        @include('layouts.navbar')

        <main>
            <div class="row">
                <div class="col-md-2 pr-0">
                    <div class="card">
                        <div class="card-header">タグ一覧</div>
                        <div class="card-body full-height-card-body p-0">
                            <ul class="list-group">
                                <li class="list-group-item border-0">
                                    <a href="/" class="card-text d-block">すべて表示</a>
                                </li>
                                @foreach($tags as $tag)
                                <li class="list-group-item border-0">
                                    <a href="/?tag={{$tag->id}}" class="card-text d-block">{{$tag->name}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 p-0">
                    <div class="card">
                        <div class="card-header">メモ一覧</div>
                        <div class="card-body full-height-card-body p-0">
                            <ul class="list-group">
                                @foreach($memos as $memo)
                                <li class="list-group-item border-0">
                                    <a href="/edit/{{$memo->id}}"
                                        class="card-text d-block ellipsis">{{$memo->content}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 p-0">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
</body>

</html>
