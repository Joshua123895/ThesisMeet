@extends('layout.navbar')
@section('styles1')
    <link rel="stylesheet" href="{{asset('css/home/about-us.css')}}">
@endsection
@section('title', 'ThesisMeet - About Us')
@section('content1')
    <div class="container glass">
        <h1>{{ucwords(__('home.about us'))}}</h1>
        <p>{{__('about-us.p1')}}</p>
        <p>{{__('about-us.p2')}}</p>
        <p>{{__('about-us.p3')}}</p>
        <p>{{__('about-us.p4')}}</p>
    </div>
@endsection