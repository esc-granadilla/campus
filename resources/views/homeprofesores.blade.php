@extends('layouts.app')

@section('content')
@if (!Auth::guest())
   <profesor></profesor>
@endif
@endsection