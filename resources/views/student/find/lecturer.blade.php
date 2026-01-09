@extends('layout.navbar')
@section('styles1')
    <link rel="stylesheet" href="{{asset('css/find/student.css')}}">
@endsection
@section('title', 'ThesisMeet - ' . __('consult.lecturers'))
@section('content1')
    <div class="container glass">
        <div class="heading">
            <a href="{{route('student.home')}}" class="button white">{{ucfirst(__('consult.back'))}}</a>
            <h1>
                {{ucfirst(__('consult.lecturers'))}}
            </h1>
            <div class="search-bar glass">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/></svg>
                <input type="text" name="search" id="search" placeholder="{{__('consult.search lecturers')}}">
            </div>
        </div>
        <div class="inner" id="lecturerContainer">
            @foreach ($lecturers as $lecturer)
                <div class="profile glass" style="animation-delay: {{$loop->index * 0.12}}s">
                    <div class="left">
                        <img src="{{asset('storage/' . $lecturer->image_path)}}" alt="profile image">
                    </div>
                    <div class="right">
                        <div class="upper">
                            <h1>{{$lecturer->name}}</h1>
                            <p>{{$lecturer->profile}}</p>
                            <div class="in-rows">
                                <div class="item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail-icon lucide-mail"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg>
                                    <div class="item-info">
                                        <h3>{{ucwords(__('auth.email'))}}</h3>
                                        <p>{{$lecturer->email}}</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone-icon lucide-phone"><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"/></svg>
                                    <div class="item-info">
                                        <h3>{{ucwords(__('auth.phone number'))}}</h3>
                                        <p>{{$lecturer->phone}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reverse">
                            @if ($lecturer->is_assigned)
                                <a href="{{route('student.consult.create')}}" class="button blue">
                                    {{ucfirst(__('consult.reserve appointment'))}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                </a>
                            @endif
                            <a href="{{route('student.find.schedule')}}" class="button white">
                                {{ucfirst(__('consult.see schedule'))}}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- @foreach ($unassignedLecturers as $lecturer)
            <h1>{{$lecturer->name}}</h1>
        @endforeach --}}
    </div>
    <script>
        window.SEARCH_URL = "{{ route('student.find.lecturer.search') }}";
        const consultCreateUrl = "{{ route('student.consult.create') }}";
        const seeScheduleUrl = "{{ route('student.find.schedule') }}";
        window.LANG = {
            'email': "{{ucwords(__('auth.email'))}}",
            'phone number': "{{ucwords(__('auth.phone number'))}}",
        };
    </script>
    <script src="{{asset('js/find-lecturer.js')}}"></script>
@endsection