@extends('layout.tabs')
@section('styles2')
    <link rel="stylesheet" href="{{asset('css/consult/show.css')}}">
@endsection
@section('title', 'ThesisMeet - ' . __('consult.scheduled appointment'))
@section('heading')
    {{ucfirst(__('consult.scheduled appointment'))}}
@endsection
@section('tabs')
    <div class="tabs">
        <a href="{{route('student.consult.ongoing')}}" class="{{ request()->routeIs('*.ongoing') ? 'active' : '' }}">{{ucfirst(__('consult.ongoing'))}}</a>
        <a href="{{route('student.consult.history')}}" class="{{ request()->routeIs('*.history') ? 'active' : '' }}">{{ucfirst(__('consult.history'))}}</a>
    </div>
@endsection
@section('inside')
    <div class="schedules">
        @foreach ($appointments as $appointment)
            <div class="schedule glass" style="animation-delay: {{ $loop->index * 0.12 }}s;">
                @if ($appointment->status === 'on review')
                    <div class="title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock"><path d="M12 6v6l4 2"/><circle cx="12" cy="12" r="10"/></svg>
                        {{ucfirst(__('consult.on review'))}}
                    </div>
                @elseif ($appointment->status === 'finished')
                    <div class="title finished">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
                        {{ucfirst(__('consult.finished'))}}
                    </div>
                @else
                    <div class="title cancelled">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                        {{ucfirst(__('consult.cancelled'))}}
                    </div>
                @endif
                <p><strong>
                    {{ $appointment->thesis->title }}
                </strong></p>
                <p>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    {{ $appointment->lecturer->name }}
                </p>
                <div class="in-between">
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock"><path d="M12 6v6l4 2"/><circle cx="12" cy="12" r="10"/></svg>
                        {{ucfirst(__('consult.start time'))}}: {{ \Carbon\Carbon::parse($appointment->start_time)->format('j M Y \a\t H:i') }}
                    </p>
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock"><path d="M12 6v6l4 2"/><circle cx="12" cy="12" r="10"/></svg>
                        {{ucfirst(__('consult.end time'))}}: {{ \Carbon\Carbon::parse($appointment->end_time)->format('j M Y \a\t H:i') }}
                    </p>
                </div>
                <p>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-notebook-pen-icon lucide-notebook-pen"><path d="M13.4 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7.4"/><path d="M2 6h4"/><path d="M2 10h4"/><path d="M2 14h4"/><path d="M2 18h4"/><path d="M21.378 5.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"/></svg>
                    {{ucfirst(__('consult.notes'))}}: {{$appointment->comments}}
                </p>
                <p>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin-icon lucide-map-pin"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                    @if (!$appointment->is_onsite)
                        <a href="{{$appointment->location}}">{{ucfirst(__('consult.online meeting'))}}</a>
                    @else
                        {{$appointment->location}}
                    @endif
                </p>
                @if ($appointment->thesis->paper_path)
                    <a href="{{ route('student.consult.paper', $appointment) }}" class="button blue">
                        {{ucfirst(__('consult.view paper'))}}
                    </a>
                @endif
            </div>
        @endforeach
    </div>
@endsection
@section('buttons')
    <a href="{{route('student.home')}}" class="button white">{{ucfirst(__('consult.back'))}}</a>
    <a href="{{route('student.consult.create')}}" class="button blue">{{ucfirst(__('consult.new appointment'))}} <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg></a>
@endsection