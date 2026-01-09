@extends('layout.navbar')
@section('styles1')
    <link rel="stylesheet" href="{{asset('css/profile/student.css')}}">
@endsection
@section('title', "ThesisMeet - " . __('home.edit profile'))
@section('content1')
    <form action="{{route('student.profile.update')}}"
            method="POST" 
            class="container glass" 
            enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="file"
            id="photoInput"
            name="photo"
            accept="image/*"
            hidden>
        <label for="photoInput" id="profile" class="profile edit">
            @if ($user->image_path)
                <img id="photoPreview" src="{{asset('storage/' . $user->image_path)}}" alt="profile">
            @else
                <h1 id="initial" data-name="{{ $user->name }}"></h1>
            @endif
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-icon lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
        </label>
        <div class="upper-profile in-rows">
            <div class="labels">
                <div class="info-label big">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <label for="name">{{ucfirst(__('auth.name'))}}</label>
                </div>
                <div class="info-label big">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-graduation-cap-icon lucide-graduation-cap"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>
                    <label for="major">{{ucfirst(__('home.major'))}}</label>
                </div>
                <div class="info-label big">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-id-card-icon lucide-id-card"><path d="M16 10h2"/><path d="M16 14h2"/><path d="M6.17 15a3 3 0 0 1 5.66 0"/><circle cx="9" cy="11" r="2"/><rect x="2" y="5" width="20" height="14" rx="2"/></svg>
                    <label for="NIM">{{ucfirst(__('auth.student ID'))}}</label>
                </div>
            </div>
            <div class="inputs">
                <input  type="text"
                        id="name"
                        name="name"
                        placeholder="James" 
                        value="{{$user->name}}" 
                        required>
                <select name="major" id="major" required>
                        <option value='computer science'> Computer Science </option>
                        <option value='international business management'> International Business Management </option>
                        <option value='information systems'> Information Systems </option>
                        <option value='digital marketing'> Digital Marketing </option>
                        <option value='data science'> Data Science </option>
                        <option value='business analytics'> Business Analytics </option>
                </select>
                <input type="number" 
                        name="nim"
                        id="NIM"
                        placeholder="2701234567" 
                        min="0" 
                        max="9999999999"
                        value="{{$user->NIM}}" 
                        required>
            </div>
        </div>
        <div class="lower-profile">
            <button type="submit" class="button blue">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-save-icon lucide-save"><path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"/><path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7"/><path d="M7 3v4a1 1 0 0 0 1 1h7"/></svg>
                {{ucfirst(__('home.save changes'))}}
            </button>
            <a href="{{route('student.profile.show')}}" class="button red">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out"><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/></svg>
                {{ucfirst(__('home.cancel'))}}
            </a>
        </div>
    </form>
    <script src="{{asset('js/profile-student.js')}}">
    </script>
    <script src="{{asset('js/profile.js')}}">
    </script>
@endsection