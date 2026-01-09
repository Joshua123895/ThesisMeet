@extends('layout.navbar')
@section('styles1')
    <link rel="stylesheet" href="{{asset('css/find/lecturer.css')}}">
@endsection
@section('title', 'ThesisMeet - Find Students')
@section('content1')
    <div class="container glass">
        <div class="heading">
            <a href="{{route('lecturer.home')}}" class="button white">Back</a>
            <h1>
                {{__('thesis.students')}}
            </h1>
            <div class="search-bar glass">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/></svg>
                <input type="text" name="search" id="search" placeholder="{{__('consult.search students')}}">
            </div>
        </div>
        <div class="inner" id="studentContainer">
            @foreach ($students as $student)
                <div class="profile glass" style="animation-delay: {{$loop->index * 0.12}}s">
                    {{-- profile image, name, student number (NIM), major, and email. --}}
                    @if ($student->image_path)
                        <img src="{{asset('storage/' . $student->image_path)}}" alt="profile">
                    @else
                        <div class="student-profile">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                    @endif
                    <div class="profile-info">
                        <h1>{{$student->name}}</h1>
                        <h2>{{$student->NIM}}</h2>
                        
                    </div>
                    <h3>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-graduation-cap-icon lucide-graduation-cap"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>
                        {{ucwords($student->major)}}
                    </h3>
                    <h3 class="reverse">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail-icon lucide-mail"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg>
                        {{$student->email}}
                    </h3>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        window.SEARCH_URL = "{{ route('lecturer.find.student.search') }}";
    </script>
    <script src="{{asset('js/find-student.js')}}"></script>
@endsection