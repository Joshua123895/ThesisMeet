@extends('layout.navbar')
@section('styles1')
    <link rel="stylesheet" href="{{asset('css/layout/tabs.css')}}">
    @yield('styles2')
@endsection
@section('content1')
    <div class="wrapper">
        <h1>@yield('heading')</h1>
        @yield('tabs')
        <div class="container glass">
            @yield('inside')
            <div class="buttons">
                @yield('buttons')
            </div>
        </div>
    </div>
@endsection