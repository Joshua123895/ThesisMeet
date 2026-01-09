@extends('layout.calendar')
@section('title')
    ThesisMeet - {{__('consult.lecturer schedule')}}
@endsection
@section('buttons')
    <a href="{{route('student.consult.create')}}" class="button blue">
        {{ucfirst(__('consult.new appointment'))}}
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
    </a>
    <a href="{{route('student.home')}}" class="button white">
        <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out"><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/></svg>
        {{ucfirst(__('consult.back'))}}
    </a>
@endsection
@section('calendar-route')
    {{ route('student.find.schedule.event') }}
@endsection