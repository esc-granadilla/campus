@extends('layouts.appstudents')

@section('content')
@if (!Auth::guest())
   <estudiante estudiante_id={{ $estudiante->id }}></estudiante>
@endif
@endsection