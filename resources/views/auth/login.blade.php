@extends('layouts.app')
@section('styles')
<style>
    #app {
        background-image: linear-gradient(to right top, #051937, #004d7a, #008793, #00bf72, #a8eb12);
    }
</style>
@endsection
@section('content')
   <form class="form-horizontal" method="POST" action="{{ route('login') }}">
      {{ csrf_field() }}
      <login></login>
   </form>
@endsection
