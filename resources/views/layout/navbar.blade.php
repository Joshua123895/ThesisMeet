@extends('layout.basic')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/layout/navbar.css')}}">
    @yield('styles1')
@endsection
@section('content')  
    <nav>
        <img src="{{asset('image\logo-small.png')}}" alt="logo">
        <div>
            <form action="{{route('locale.toggle')}}" method="POST" class="lang-container">
                @csrf
                @if (app()->getLocale() === 'id')
                    <button type="submit">EN</button>
                    <button type="button">ID</button>
                @else
                    <button type="button">EN</button>
                    <button type="submit">ID</button>
                @endif
            </form>
            <ul>
                <li>
                    <a href="{{ auth('student')->check()
                        ? route('student.home')
                        : route('lecturer.home') }}"
                        class="{{ request()->routeIs('*.home') ? 'active' : '' }}">
                        {{ucfirst(__('home.home'))}}
                    </a>
                </li>
                <li>
                    <a href="{{ auth('student')->check()
                        ? route('student.find.schedule')
                        : ''}}"
                        class="{{ request()->routeIs('*.schedule') ? 'active' : '' }}">
                        {{ucfirst(__('home.schedule'))}}
                    </a>
                </li>
                <li>
                    <a href="{{ auth('student')->check()
                        ? route('student.about-us')
                        : route('lecturer.about-us') }}"
                        class="{{ request()->routeIs('*.about-us') ? 'active' : '' }}">
                        {{ucfirst(__('home.about us'))}}
                    </a>
                </li>
            </ul>
            <a href="{{ auth('student')->check()
                ? route('student.profile.show')
                : route('lecturer.profile.show') }}"
                class="profile-nav">
                @if ($user->image_path)
                    <img src="{{asset('storage/' . $user->image_path)}}" alt="profile">
                @else
                    <div class="default-profile {{ request()->routeIs('*.profile') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                @endif
            </a>
        </div>
    </nav>
    @yield('content1')
    @yield('script')
@endsection  