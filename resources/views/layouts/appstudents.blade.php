<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Campus Granadilla Norte') }}</title>

    <!-- Styles -->
    @yield('styles')
    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <!--<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">-->
    <link href="{{ asset('css/vuetify.min.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="/favicon.ico">
</head>
<body>
    <div id="app">
        @if (Auth::guest())
            <Appstudents login="false"  name=""></Appstudents>
        @else
            <Appstudents login="true"  name={{ Auth::user()->name }}></Appstudents>
            <form id="logout-form2" action="{{ route('logout') }}" method="POST" style="display: none;">
               {{ csrf_field() }}
            </form>
        @endif
        <v-app>
         <v-content>
            <div style="padding-top: 64px; height: 100%;">
               @yield('content')
            </div>
         </v-content>
      </v-app>
    </div>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
