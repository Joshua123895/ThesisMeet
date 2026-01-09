@extends('layout.navbar')
@section('styles1')
    <link rel="stylesheet" href="{{asset('css/profile/student.css')}}">
@endsection
@section('title', "ThesisMeet - " . __('home.profile'))
@section('content1')
    <div class="container glass">
        <div id="profile" class="profile">
            @if ($user->image_path)
                <img src="{{asset('storage/' . $user->image_path)}}" alt="profile">
            @else
                <h1 id="initial" data-name="{{ $user->name }}"></h1>
            @endif
        </div>
        <div class="upper-profile">
            <h1>{{$user->name}}</h1>
            <h3>{{ucwords($user->major)}}</h3>
            <div class="line"></div>
            <div class="info">
                <div class="info-label">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail-icon lucide-mail"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg>
                    {{ucfirst(__('home.email'))}}
                </div>
                {{$user->email}}
            </div>
            <div class="info">
                <div class="info-label">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-id-card-icon lucide-id-card"><path d="M16 10h2"/><path d="M16 14h2"/><path d="M6.17 15a3 3 0 0 1 5.66 0"/><circle cx="9" cy="11" r="2"/><rect x="2" y="5" width="20" height="14" rx="2"/></svg>
                    {{ucfirst(__('auth.student ID'))}}
                </div>
                {{$user->NIM}}
            </div>
        </div>
        <div class="lower-profile">
            <a href="{{route('student.profile.edit')}}" class="button blue">
                {{ucfirst(__('home.edit profile'))}}
            </a>
            <a href="/force-logout" class="button red">
                <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out"><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/></svg>
                {{ucfirst(__('home.log out'))}}
            </a>
        </div>
    </div>
    <script src="{{asset('js/profile-student.js')}}">
    </script>
@endsection