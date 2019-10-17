<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <link rel="apple-touch-icon" href="{{asset('images/icon.png')}}">
    <link rel="shortcut icon" href="{{asset('images/icon.png')}}">
    <script src="{{asset('js/jquery.js')}}"></script>
<?php
    //auto refresh
    //echo "<meta http-equiv='refresh' content='1' >";
?>
<!--<meta http-equiv="refresh" content="10" >-->
    <head>
        @include('inc.head')
    </head>
    <body>
        
        
        <div id="right-panel" class="right-panel">
        
        @yield('content')
        @include('inc.footer')
        </div>
    </body>
</html>
