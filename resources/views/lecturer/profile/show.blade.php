@extends('layout.navbar')
@section('styles1')
    <link rel="stylesheet" href="{{asset('css/profile/lecturer.css')}}">
@endsection
@section('title', "ThesisMeet - " . __('home.profile'))
@section('content1')
    <section class="container">
        <div class="left-cont glass">
            <div class="profile">
                @if ($user->image_path)
                    <img src="{{asset('storage/' . $user->image_path)}}" alt="profile">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                @endif
            </div>
            <div class="text">
                <h1>{{ucwords($user->name)}}</h1>
                <h3>{{$user->email}}</h3>
            </div>
            <div class="buttons">
                <a href="{{route('lecturer.profile.edit')}}" class="button blue">
                    {{ucfirst(__('home.edit profile'))}}
                </a>
                <a href="/force-logout" class="button red">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out"><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/></svg>
                    {{ucfirst(__('home.log out'))}}
                </a>
            </div>
        </div>
        <div class="right-cont glass">
            <section>
                <h1>{{ucfirst(__('home.profile details'))}}</h1>
            </section>
            <section>
                <h2>{{ucfirst(__('home.about me'))}}</h2>
                <p>{{$user->profile}}</p>
            </section>
            <section>
                <h2>{{ucfirst(__('home.contact information'))}}</h2>
                <div class="in-rows">
                    <div class="item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail-icon lucide-mail"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg>
                        <div class="item-info">
                            <h3>{{ucfirst(__('home.email'))}}</h3>
                            <p>{{$user->email}}</p>
                        </div>
                    </div>
                    <div class="item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone-icon lucide-phone"><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"/></svg>
                        <div class="item-info">
                            <h3>{{ucfirst(__('home.phone'))}}</h3>
                            <p>{{$user->phone}}</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection