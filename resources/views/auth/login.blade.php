@extends('layouts.app')

@section('content')
   <form class="form-horizontal" method="POST" action="{{ route('login') }}">
      {{ csrf_field() }}
      <login></login>
   </form>
@endsection
