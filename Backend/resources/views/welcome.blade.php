@extends('layouts.master')

@section('title','Campus Granadilla Norte')

@section('css')
    <!--<link rel="stylesheet" href="{{ URL::asset('css/welcome.css') }}">-->
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
@endsection

@section('body')
    <div id="app">
        <header-component></header-component>
        <main-component></main-component>
        <footer-component></footer-component>
    </div>
    
    
    <script src="{{asset('js/app.js')}}"></script>
@endsection
