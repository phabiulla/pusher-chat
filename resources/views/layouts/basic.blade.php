<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Hareeph') }}</title>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        @yield('header_script')
    </head>
    <body>
        <div id="app">
            @yield('content')
        </div>

        <!-- Scripts -->
        <script src="/node_modules/select2/dist/js/select2.min.js"></script>
        <script src="{{ asset('js/app.js') }}"></script>

        @yield('footer_script')

    </body>
</html>
