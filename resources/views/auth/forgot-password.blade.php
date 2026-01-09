@extends('layout.basic')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/auth/auth.css')}}">
    <link rel="stylesheet" href="{{asset('css/auth/login.css')}}">
@endsection
@section('title', 'ThesisMeet - ' . ucwords(__('auth.forgot password')))
@section('content')
    <div class="left-column">
        <img src="{{asset('image\banner.png')}}" alt="banner">
        <h1>{{ucwords(__('auth.forgot password'))}}</h1>
    </div>
    <img src="{{asset('image/book.png')}}" alt="book" class="book-bgr">
    <div class="right-column">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="upper-auth">
                <h2>{{ucwords(__('auth.reset password'))}}</h2>
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
                            placeholder="anonymous@domain.com"
                            required>
                </div>
                <p>
                    {{ucfirst(__('auth.desc forgot'))}}
                </p>
            </div>
            <div class="lower-auth">
                <span class="line"></span>
                <button type="submit">
                    {{ucwords(__('auth.send reset link'))}}
                </button>
                <p>
                    {{ucfirst(__('auth.remember your password'))}}?
                    <a href="{{ route('login') }}">{{ucfirst(__('auth.login'))}}</a>
                </p>
            </div>
        </form>
    </div>
@endsection
