@extends('layouts.app')

@section('content')
@if (!Auth::guest())
   <profesor profesor_id={{ $profesor->id }}></profesor>
@endif
@endsection