@extends('layouts.app')
@section('styles')
<style>
    #app {
        background-image: linear-gradient(to right top, #e9f1f4, #e0f0f4, #d6eff3, #cceef0, #c3edeb);
    }
</style>
@endsection
@section('content')
<form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
   {{ csrf_field() }}
   <remembercomponent></remembercomponent>
</form>
@endsection
