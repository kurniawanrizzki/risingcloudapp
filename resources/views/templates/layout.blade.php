<!doctype html>
<html lang="{{ app()->getLocale() }}">
    
    <head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>
            {{env('APP_NAME')}}  
            @section('title')
                -
            @show
        </title>

        <!-- Bootstrap Core CSS -->
        <link href="{{asset('dist/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="{{asset('dist/vendor/metisMenu/metisMenu.min.css')}}" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="{{asset('dist/css/sb-admin-2.css')}}" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="{{asset('dist/vendor/font-awesome/v5.0.8/web-fonts-with-css/css/fontawesome-all.min.css')}}" rel="stylesheet" type="text/css">
        
    </head>
    
    <body>
        
        <div class="content">
            @yield("content")
        </div>

        <!-- jQuery -->
        <script src="{{asset('dist/vendor/jquery/jquery.min.js')}}"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="{{asset('dist/vendor/bootstrap/js/bootstrap.min.js')}}"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="{{asset('dist/vendor/metisMenu/metisMenu.min.js')}}"></script>

        <!-- Custom Theme JavaScript -->
        <script src="{{asset('dist/js/sb-admin-2.js')}}"></script>

    </body>

</html>

