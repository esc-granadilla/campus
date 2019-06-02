@extends('layouts.appstudents')

@section('content')
@if (!Auth::guest())
   <panelestudiante name={{ Auth::user()->name }}></panelestudiante>
@endif
@endsection