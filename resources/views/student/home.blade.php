@extends('layout.navbar')
@section('styles1')
    <link rel="stylesheet" href="{{asset('css/home/home.css')}}">
@endsection
@section('title', "ThesisMeet - " . __('home.thesis consultation'))
@section('content1')
    <section class="hero">
        <div>
            <h2>{{ucfirst(__('auth.welcome back'))}}, <span>{{ ucwords($user->name) }}.</span></h2>
            <h3>{{ucfirst(__('home.manage your'))}}</h3>
            <h1>{{__('home.thesis consultation')}}</h1>
        </div>
    </section>
    <section class="menus">
        <a href="{{route('student.consult.ongoing')}}" class="menu">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-user-icon lucide-book-user"><path d="M15 13a3 3 0 1 0-6 0"/><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"/><circle cx="12" cy="8" r="2"/></svg>
            <h3>{{ucwords(__('home.consultation scheduler'))}}</h3>
            <p>{{ucfirst(__('home.appoint your thesis consultation'))}}</p>
        </a>
        <a href="{{route('student.find.schedule')}}" class="menu">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock"><path d="M12 6v6l4 2"/><circle cx="12" cy="12" r="10"/></svg>
            <h3>{{ucwords(__('home.see lecturer schedule'))}}</h3>
            <p>{{ucfirst(__('home.see your lecturer schedule'))}}</p>
        </a>
        <a href="{{route('student.find.lecturer')}}" class="menu">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/></svg>
            <h3>{{ucwords(__('home.find lecturer'))}}</h3>
            <p>{{ucfirst(__('home.find your thesis lecturer'))}}</p>
        </a>
        <a href="{{route('student.thesis.show')}}"class="menu">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text-icon lucide-file-text"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
            <h3>{{ucwords(__('home.thesis manager'))}}</h3>
            <p>{{ucfirst(__('home.see your previous thesis'))}}</p>
        </a>
    </section>
@endsection