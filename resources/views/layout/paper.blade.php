@extends('layout.navbar')
@section('styles1')
    <link rel="stylesheet" href="{{asset('css/layout/paper.css')}}">
@endsection
@section('content1')
<div class="container">
    <div class="pdf-wrapper">
        @yield('pdf')
    </div>
    @yield('notes')
</div>
@endsection