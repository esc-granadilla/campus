@extends('layouts.app')

@section('content')
@if (!Auth::guest())
   <panelprofesor name={{ Auth::user()->name }}></panelprofesor>
@endif
@endsection