<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@if(Session::has('guild'))
    <meta name="guild_id" content="{{ Session::get('guild')->guildId }}">
@endif
    <title>{{ config('app.name') }}</title>
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}?v=1.0">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/qtip2/3.0.3/jquery.qtip.min.css">
</head>
<body>
    <div id="app">
        <section class="content">
            @yield('content')
        </section>
    </div>
    <!-- Scripts -->
    <script type="text/javascript" src="//code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}?v=1.0"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/qtip2/3.0.3/jquery.qtip.min.js"></script>

    </script>
    <script>
    $(document).ready(function() {
        $('[data-tip!=""]').qtip({
            content: {
                attr: 'data-tip'
            },
            position: {
                target: 'mouse',
                adjust: { x: 15, y: 0 }
            },
            style: {
                tip: {
                    corner: false
                },
                classes: 'tooltip qtip-dark qtip-shadow'
            }
        })
    });
    </script>
</body>
</html>
