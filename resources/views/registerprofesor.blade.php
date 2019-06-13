@extends('layouts.app')
@section('styles')
<style>
    #app {
        background-image: linear-gradient(to top, #97f6ee, #89ebf3, #83dff5, #84d2f3, #8bc4ee, #94c5ec, #9cc6e9, #a3c7e7, #b3d6ea, #c7e3ed, #dfeff2, #f8fbfb);
    }
</style>
@endsection 

@section('content')
<form class="form-horizontal" method="POST" action="{{ route('teachers.store') }}">
   {{ csrf_field() }}
   <registerprofesor></registerprofesor>
</form>
@endsection

