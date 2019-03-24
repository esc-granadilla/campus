@extends('layouts.app') @section('styles')
<style>
    #app {
        background-image: url('images/fondoregistroestudiantes.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center top;
        background-attachment: fixed;
    }
</style>
@endsection @section('content')
<form class="form-horizontal" method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}
    <registerstudents></registerstudents>
</form>
@endsection