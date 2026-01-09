@extends('layout.navbar')
@section('styles1')
    <link rel="stylesheet" href="{{asset('css/profile/lecturer.css')}}">
@endsection
@section('title', "ThesisMeet - " . __('home.edit profile'))
@section('content1')
    <form action="{{route('lecturer.profile.update')}}" 
            method="POST" 
            class="container" 
            enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="left-cont glass">
            <input type="file"
                id="photoInput"
                name="photo"
                accept="image/*"
                hidden>
            <label for="photoInput" id="profile" class="profile edit">
                <img id="photoPreview"
                    src="{{ asset('storage/' . $user->image_path) }}"
                    alt="profile">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-icon lucide-pencil"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
            </label>
            <div class="text">
                <h1>{{ucwords($user->name)}}</h1>
                <h3>{{$user->email}}</h3>
            </div>
            <div class="buttons">
                <button type="submit" class="button blue">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-save-icon lucide-save"><path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"/><path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7"/><path d="M7 3v4a1 1 0 0 0 1 1h7"/></svg>
                    {{ucfirst(__('home.save changes'))}}
                </button>
                <a href="{{route('lecturer.profile.show')}}" class="button red">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out"><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/></svg>
                    {{ucfirst(__('home.cancel'))}}
                </a>
            </div>
        </div>
        <div class="right-cont glass">
            <section class="upper-section">
                <section>
                    <h1>{{ucfirst(__('home.edit profile details'))}}</h1>
                </section>
                <section>
                    <div class="small-input">
                        <div class="labels">
                            <div class="item">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                <label for="name">{{ucfirst(__('auth.name'))}}</label>
                            </div>
                            <div class="item">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone-icon lucide-phone"><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"/></svg>
                                <label for="phone">{{ucfirst(__('home.phone number'))}}</label>
                            </div>
                        </div>
                        <div class="inputs">
                            <input  type="text"
                                    id="name"
                                    name="name"
                                    placeholder="James" 
                                    value="{{$user->name}}" 
                                    required>
                            <input  type="number" 
                                    id="phone"
                                    name="phone"
                                    placeholder="021234567890" 
                                    min="0" 
                                    max="999999999999"
                                    value="{{$user->phone}}" 
                                    required>
                        </div>
                    </div>
                    <div class="large-input">
                        {{ucfirst(__('home.profile description'))}}
                        
                        <textarea
                            placeholder="{{__('home.write something about yourself')}}"
                            rows="4"
                            name="profile"
                            required
                        >{{$user->profile}}</textarea>
                    </div>
                </section>
            </section>
        </div>
    </form>
    <script src="{{asset('js/profile.js')}}"></script>
@endsection