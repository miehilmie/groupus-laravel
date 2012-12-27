<!doctype html>
<html>
    <head>
        <title>GroupUs! | Optimized Academic Grouping System - Student</title>
        <link rel="icon" type="image/ico" href="{{ URL::to('favicon.ico') }}"/>


        @section('styles')
        {{ HTML::style('css/common.css') }}
        @yield_section

        @section('javascripts')
        @if(isset($production))
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        @endif
        <script>window.jQuery || document.write('<script src="{{ URL::to('js/jquery.js') }}"><\/script>')</script>       
        @yield_section

        
    </head>
    <body>
        <div id="header">
            <div id="logopanel">
                <a href="{{ URL::base(); }}">{{ HTML::image('img/logo.png') }}</a>{{ HTML::image('img/title-logo.png') }}
            </div>
            @yield('nav')
        </div>
        <div class="content">
            @yield('content')
        </div>
        <div class="footer">
            <span>copyright (c) groupus, 2012 all right reserved</span><br /><small>powered by <a href="http://facebook.com/miehilmie">Hilmi Hassan</a></small>
        </div>
    </body>
</html>