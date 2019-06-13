@extends('layouts.appstudents')

@section('content')
   @if (!Auth::guest())
      <profilestudents student="{{$student->toJson()}}"></profilestudents>
   @endif
@endsection

