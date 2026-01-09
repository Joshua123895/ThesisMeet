@extends('layout.basic')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/auth/auth.css')}}">
    <link rel="stylesheet" href="{{asset('css/auth/login.css')}}">
@endsection
@section('title', 'ThesisMeet - ' . ucwords(__('auth.reset password')))
@section('content')
    <div class="left-column">
        <img src="{{asset('image\banner.png')}}" alt="banner">
        <h1>{{ucwords(__('auth.reset password'))}}</h1>
    </div>
    <img src="{{asset('image/book.png')}}" alt="book" class="book-bgr">
    <div class="right-column">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="upper-auth">
                <h2>{{ucwords(__('auth.new password'))}}</h2>
                <span class="line"></span>

                <div class="input-group">
                    <label>{{ucwords(__('auth.email'))}}</label>
                    <input type="email" name="email"
                            value="{{ $email }}"
                            readonly>
                </div>
                <div class="input-group">
                    <label>{{ucwords(__('auth.new password'))}}</label>
                    <input type="password" name="password"
                            placeholder="{{ucfirst(__('auth.enter new password'))}}"
                            required>
                </div>
                <div class="input-group">
                    <label>{{ucwords(__('auth.confirm password'))}}</label>
                    <input type="password" name="password_confirmation"
                            placeholder="{{ucfirst(__('auth.confirm new password'))}}"
                            required>
                </div>
            </div>
            <div class="lower-auth">
                <span class="line"></span>
                <button type="submit">
                    {{ucwords(__('auth.reset password'))}}
                </button>
                <p>{{ucfirst(__('auth.remember your password'))}}? <a href="{{ route('login') }}">{{ucwords(__('auth.login'))}}</a></p>
            </div>
        </form>
    </div>
@endsection
