@extends('layouts.app')

@section('content')
@if (!Auth::guest())
   <administrador name={{ Auth::user()->name }}></administrador>
@endif
@endsection