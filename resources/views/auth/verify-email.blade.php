@extends('layout.basic')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/auth/auth.css')}}">
    <link rel="stylesheet" href="{{asset('css/auth/login.css')}}">
@endsection
@section('title', 'ThesisMeet - ' . ucwords(__('auth.verification sent')))
@section('content')
    <div class="left-column">
        <img src="{{asset('image\banner.png')}}" alt="banner">
        <h1>{{ucwords(__('auth.verify your email'))}}</h1>
    </div>
    <img src="{{asset('image/book.png')}}" alt="book" class="book-bgr">
    <div class="right-column">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div class="upper-auth">
                <h1>{{ucwords(__('auth.verification sent'))}}</h1>
                <h2>{{ucfirst(__('auth.please click'))}}</h2>
                <p>{{ucfirst(__("auth.if you don't"))}}</p>
            </div>
            <div class="lower-auth">
                <button type="submit">{{ucwords(__('auth.resend verification email'))}}</button>
            </div>
        </form>
    </div>
@endsection