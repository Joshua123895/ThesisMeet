@extends('layout.basic')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/auth/auth.css')}}">
    <link rel="stylesheet" href="{{asset('css/auth/login.css')}}">
@endsection
@section('title', 'ThesisMeet - ' . ucfirst(__('auth.login')))
@section('content')
    <div class="left-column">
        <img src="{{asset('image\banner.png')}}" alt="banner">
        <h1>{{ucwords(__('auth.welcome back'))}}</h1>
        <form action="{{route('locale.toggle')}}" method="POST" class="lang-container white">
            @csrf
            @if (app()->getLocale() === 'id')
                <button type="submit">EN</button>
                <button type="button">ID</button>
            @else
                <button type="button">EN</button>
                <button type="submit">ID</button>
            @endif
        </form>
    </div>
    <img src="{{asset('image/book.png')}}" alt="book" class="book-bgr">
    <div class="right-column">
        <form method="POST" action="/login">
            @csrf
            <div class="upper-auth">
                <h2>{{ucfirst(__('auth.login'))}}</h2>
                <span class="line"></span>
                <div class="input-group">
                    <label>{{ucfirst(__('auth.i am a'))}}</label>
                    <select name="role" required>
                        <option value="student">{{__('auth.student')}}</option>
                        <option value="lecturer">{{__('auth.lecturer')}}</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>{{ucfirst(__('auth.email'))}}</label>
                    <input type="email" name="email"
                            placeholder="anonymous@domain.com" required>
                </div>
                <div class="input-group">
                    <label>{{ucfirst(__('auth.password'))}}</label>
                    <input type="password" name="password"
                    placeholder="password123" required>
                    <a href="{{ route('password.request') }}">{{ucwords(__('auth.forgot password'))}}?</a>
                </div>
            </div>
            <div class="lower-auth">
                <span class="line"></span>
                <button>
                    {{ucfirst(__('auth.login'))}}
                </button>
                <p>{{ucfirst(__("auth.don't have account"))}}? <a href="{{route('register')}}">{{ucfirst(__('auth.register'))}}</a></p>
            </div>
        </form>
    </div>
@endsection