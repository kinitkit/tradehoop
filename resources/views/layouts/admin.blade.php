<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <!-- Icon -->
        <link rel="shortcut icon" type="image/png" href="{{'http://tradehoop.com/images/favicon.png'}}"/>

        <title>Tradehoop | Administration | @yield('title')</title>

        @include('includes.admin.heading')

        <style>
        </style>
    </head>
    <body>
        <?php if(session('tradehoopusername') != ''){ ?>
            @include('includes.admin.sidebar')
        <?php } ?>

        <div class="main">
            <?php if(session('tradehoopusername') != ''){ ?>
                <h2><span class="label label-info">@yield('page')</span></h2>
            <?php } ?>
            @yield('content')
        </div>

        <?php if(session('tradehoopusername') != ''){ ?>
            @include('includes.admin.footer')
        <?php } ?>
    </body>
</html>
<!-- LAYOUT -->