@extends('layouts.app')

@section('content')
   @if (!Auth::guest())
      <profileteachers teacher="{{$teacher->toJson()}}"></profileteachers>
   @endif
@endsection

