<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
        <!-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cosmo/bootstrap.min.css">
        <script type="text/javascript" src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script> -->


        <title>LiveCalendar - @yield('title')</title>
    </head>
    <body>
        
        @include('components.navbar')

        <div class="container-fluid u-fixed-navbar-offset" id="app">
            @yield('content')
        </div>


        <script>
            @yield('pre-vue-script')
        </script>

        <script type="text/javascript" src="{{ asset('js/app.js') }}" async></script>

        <script>
            @yield('post-vue-script')
        </script>
    </body>
</html>