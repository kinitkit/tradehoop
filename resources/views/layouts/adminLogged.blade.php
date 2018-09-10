<?php
    if(session('tradehoopusername') == ''){
        header('Location: admin');
        die();
    }
?>

<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Icon -->
        <link rel="shortcut icon" type="image/png" href="{{'http://tradehoop.com/images/favicon.png'}}"/>

        <title>Tradehoop | Administration | @yield('title')</title>

        @include('includes.admin.heading')

        <style>
        </style>
    </head>
    <body>
        <div class="main">
            <?php if(session('tradehoopusername') != ''){ ?>
                <div class="col-md-2 adminSidebar">
                    @include('includes.admin.sidebar')
                </div>
            <?php } ?>
            <div class="col-md-10 mainContent">
                <?php if(session('tradehoopusername') != ''){ ?>
                    <h2><span class="label label-info">@yield('page')</span></h2>
                    <?php echo '<span class="label label-primary">' . ((session('message')) ? "<big>" . session('message') . "</big>" : '') . '</span>'; ?>
                <?php } ?>
                @yield('content')
            </div>
        </div>

        <?php if(session('tradehoopusername') != ''){ ?>
            @include('includes.admin.footer')
        <?php } ?>
    </body>
</html>
<!-- LAYOUT -->