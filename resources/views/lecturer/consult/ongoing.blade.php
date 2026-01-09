@extends('layout.table')
@section('title')
    ThesisMeet - {{__('consult.ongoing')}}
@endsection
@section('heading')
    {{ucfirst(__('consult.ongoing'))}}
@endsection
@section('tabs')
    <div class="tabs">
        <a href="{{route('lecturer.consult.review')}}">{{ucfirst(__('consult.on review'))}}</a>
        <a href="{{route('lecturer.consult.ongoing')}}" class='active'>{{ucfirst(__('consult.ongoing'))}}</a>
        <a href="{{route('lecturer.consult.history')}}">{{ucfirst(__('consult.history'))}}</a>
    </div>
@endsection
@section('thead')
    <th style="width: 40%;">{{ucfirst(__('consult.thesis'))}}</th>
    <th>{{__('consult.students')}}</th>
    <th style="width: 10%">{{__('consult.time')}}</th>
    <th>{{__('consult.location')}}</th>
    <th>{{ucfirst(__('consult.notes'))}}</th>
    <th colspan="3">{{__('consult.action')}}</th>
@endsection
@section('tbody')
    @forelse ($appointments as $a)
        <tr>
            <td>
                {{$a->thesis->title}}
            </td>
            <td>
                @foreach ($a->thesis->students as $s)
                    {{$s->name}} <br>
                @endforeach
            </td>
            <td>
                {{ \Carbon\Carbon::parse($a->start_time)->format('j M Y') }} <br>
                {{ \Carbon\Carbon::parse($a->start_time)->format('H:i') }}
                -
                {{ \Carbon\Carbon::parse($a->end_time)->format('H:i') }}
            </td>
            <td>
                @if ($a->is_onsite)
                    {{$a->location}}
                @else
                    <a class="link" href="{{$a->location}}">{{ucfirst(__('consult.online meeting'))}}</a>
                @endif
            <td>
                {{$a->comments}}
            </td>
            <td>
                <a href="{{ route('lecturer.consult.notes', $a) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                </a>
            </td>
            <td>
                <a href="{{ route('lecturer.consult.notes.create', $a) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-open-icon lucide-book-open"><path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/></svg>
                </a>
            </td>
            <td>
                <a href="#"
                    class="action-btn"
                    data-url="{{ route('lecturer.consult.ongoing.reject', $a) }}"
                    data-action="reject">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ban-icon lucide-ban"><path d="M4.929 4.929 19.07 19.071"/><circle cx="12" cy="12" r="10"/></svg>
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8">
                {{__('consult.no appointment')}}
            </td>
        </tr>
    @endforelse
@endsection
@section('buttons')
    <a href="{{route('lecturer.home')}}" class="button white">{{ucfirst(__('consult.back'))}}</a>
@endsection
@section('script')
    <div class="modal-overlay hidden" id="confirm-overlay"></div>

    <form class="modal hidden" id="confirm-modal" method="POST" action="">
        @csrf
        @method('put')
        <h1 id="confirm-title">{{__('consult.are you sure')}}</h1>
        <p id="confirm-message"></p>
        <div id="confirm-addition"></div>
        <div class="buttons">
            <a href="#" class="button blue" id="confirm-cancel">{{__('consult.cancel')}}</a>
            <button class="button red" type="submit">{{__('consult.proceed')}}</button>
        </div>
    </form>
<script>
    const actionButtons = document.querySelectorAll('.action-btn');

    const confirmOverlay = document.getElementById('confirm-overlay');
    const confirmModal = document.getElementById('confirm-modal');
    const confirmMessage = document.getElementById('confirm-message');
    const confirmAddition = document.getElementById('confirm-addition');
    const confirmProceed = document.getElementById('confirm-proceed');
    const confirmCancel = document.getElementById('confirm-cancel');
    const messages = {
        'reject': "{{__('consult.reject message')}}",
    }
    const additions = {
        'reject': `
                <textarea name="reason" placeholder="{{__('consult.reason placeholder')}}" required></textarea>
                `,
    }
    actionButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            const url = btn.dataset.url;
            const action = btn.dataset.action;

            confirmMessage.textContent = messages[action];

            confirmAddition.innerHTML = additions[action];
            confirmModal.action = url;
            // confirmProceed.href = url;

            confirmModal.classList.remove('hidden');
            confirmOverlay.classList.remove('hidden');
        });
    });

    confirmCancel.addEventListener('click', () => {
        confirmModal.classList.add('hidden');
        confirmOverlay.classList.add('hidden');
    });
</script>

@endsection