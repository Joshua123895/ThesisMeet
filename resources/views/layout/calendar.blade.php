@extends('layout.navbar')
@section('styles1')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <link rel="stylesheet" href="{{asset('css/find/calendar.css')}}">
@endsection
@section('content1')
    <div class="container glass">
        <div class="left">
            <div class="upper">
                <h1>{{__('schedule.lecturer schedule')}}</h1>
    
                <select id="lecturerSelect">
                    <option value="">-- {{ucwords(__('schedule.choose lecturer'))}} --</option>
                    @foreach ($lecturers as $lecturer)
                        <option value="{{ $lecturer->id }}">
                            {{ $lecturer->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="lower">
                @yield('buttons')
            </div>
        </div>
    
        <div class="right glass">
            <div class="calendar-toolbar"></div>
            <div id="calendar"></div>
        </div>
    </div>
    <script>
        window.calendarEventRoute = @json($__env->yieldContent('calendar-route'));
        window.APP_LOCALE = "{{ app()->getLocale() }}";
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            locale: window.APP_LOCALE,
            initialView: 'timeGridWeek',
            allDaySlot: false,
            eventDisplay: 'block',
            // slotMinHeight: 128,
            // slotDuration: '00:15:00',
            height: '90%',
            fixedWeekCount: false,

            dayMaxEventRows: true,
            expandRows: true,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'timeGridWeek,dayGridMonth',
            }
        });

        calendar.render();

        const toolbar = calendarEl.querySelector('.fc-header-toolbar');
        document.querySelector('.calendar-toolbar').appendChild(toolbar);

        document.getElementById('lecturerSelect').addEventListener('change', function () {
            const lecturerId = this.value;

            calendar.removeAllEvents();

            if (!lecturerId) return;

            // calendar.addEventSource(
            //     window.calendarEventRoute + '?lecturer_id=' + lecturerId
            // );
            calendar.addEventSource({
                    url: window.calendarEventRoute,
                    method: 'GET',
                    extraParams: {
                        lecturer_id: lecturerId
                    }
                });
        });
    });
    </script>
@endsection
