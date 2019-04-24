@extends('layouts.app')

@section('content')
@if (!Auth::guest())
   <panelprofesor data={{ $data }}></panelprofesor>
@endif
@endsection