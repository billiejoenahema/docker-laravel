<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Styles -->
    <link rel="stylesheet"
        href="https://hypertext-candy.s3-ap-northeast-1.amazonaws.com/posts/vue-laravel-tutorial/app.css">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather|Roboto:400">
    <link rel="stylesheet" href="https://unpkg.com/ionicons@4.2.2/dist/css/ionicons.min.css">

</head>

<body id="body">
    <div id="app"></div>
</body>

</html>
