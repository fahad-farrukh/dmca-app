<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DMCA App</title>

        <link href="{{ url('/css/all.css') }}" rel="stylesheet">
    </head>
    <body>
        @include('flash::message')
        
        @include('partials.nav')

        <div class="container">
            @yield('content')
        </div>

        <div class="flash">
            Updated!
        </div>
        
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="{{ url('/js/all.js') }}"></script>
    </body>
</html>
