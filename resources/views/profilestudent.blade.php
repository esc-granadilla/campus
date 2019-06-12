@extends('layouts.appstudents')

@section('content')
   @if (!Auth::guest())
      <profilestudents student="{{$student}}"></profilestudents>
   @endif
@endsection

