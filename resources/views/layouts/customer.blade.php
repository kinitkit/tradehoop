<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <!-- Icon -->
        <link rel="shortcut icon" type="image/png" href="{{'http://tradehoop.com/images/favicon.png'}}"/>

        <title>Tradehoop | @yield('title')</title>

        @include('includes.customer.heading')

        <style>
        </style>
    </head>
    <body>
        @include('includes.customer.head')
    </body>
</html>
<!-- LAYOUT -->