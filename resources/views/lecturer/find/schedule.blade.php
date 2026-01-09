@extends('layout.calendar')
@section('title')
    ThesisMeet - {{__('schedule.lecturer schedule')}}
@endsection
@section('buttons')
    <a href="#"
        class="action-btn button blue">
        <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings-icon lucide-settings"><path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915"/><circle cx="12" cy="12" r="3"/></svg>
        {{__('schedule.set office hour')}}
    </a>
    <a href="{{route('lecturer.home')}}" class="button white">
        <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out"><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/></svg>
        {{ucfirst(__('consult.back'))}}
    </a>
@endsection
@section('calendar-route')
    {{ route('lecturer.find.schedule.event') }}
@endsection
@section('script')
    <div class="modal-overlay hidden" id="confirm-overlay"></div>

    <form action="{{route('lecturer.office.set')}}" method="POST" class="modal hidden" id="confirm-modal">
        @csrf
        @method('put')
        <h1 id="confirm-title">{{__('schedule.fill office')}}</h1>

        <div id="schedule-container" class="modal-container"></div>

        <button type="button" id="add-schedule" class="button blue">+ {{__('schedule.add schedule')}}</button>
        <br>
        <div class="buttons">
            <button type="button" class="button blue" id="confirm-cancel">{{__('consult.cancel')}}</button>
            <button type="submit" class="button red" id="confirm-proceed">{{__('consult.proceed')}}</button>
        </div>
    </div>
<script>
    const actionButtons = document.querySelectorAll('.action-btn');

    const confirmOverlay = document.getElementById('confirm-overlay');
    const confirmModal = document.getElementById('confirm-modal');
    const confirmCancel = document.getElementById('confirm-cancel');
    actionButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            const url = btn.dataset.url;
            const action = btn.dataset.action;

            confirmModal.classList.remove('hidden');
            confirmOverlay.classList.remove('hidden');
        });
    });

    confirmCancel.addEventListener('click', () => {
        confirmModal.classList.add('hidden');
        confirmOverlay.classList.add('hidden');
    });
    let scheduleIndex = 0;
    document.getElementById('add-schedule').addEventListener('click', () => {
        document.getElementById('schedule-container').insertAdjacentHTML(
            'beforeend',
            `
            <div class="schedule-row">
                <select name="schedules[${scheduleIndex}][day]" required>
                    <option value="">{{__('schedule.day')}}</option>
                    <option value="1">{{__('schedule.mon')}}</option>
                    <option value="2">{{__('schedule.tue')}}</option>
                    <option value="3">{{__('schedule.wed')}}</option>
                    <option value="4">{{__('schedule.thu')}}</option>
                    <option value="5">{{__('schedule.fri')}}</option>
                    <option value="6">{{__('schedule.sat')}}</option>
                    <option value="0">{{__('schedule.sun')}}</option>
                </select>
                <input type="time" name="schedules[${scheduleIndex}][start]" required>
                <input type="time" name="schedules[${scheduleIndex}][end]" required>
                <button type="button" class="remove">✕</button>

            </div>
            `
        );
        scheduleIndex++;
    });


    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove')) {
            e.target.closest('.schedule-row').remove();
        }
    });
</script>
@endsection