@extends('layout.table')
@section('title')
    ThesisMeet - {{__('consult.on review')}}
@endsection
@section('heading')
    {{ucfirst(__('consult.on review'))}}
@endsection
@section('tabs')
    <div class="tabs">
        <a href="{{route('lecturer.consult.review')}}" class='active'>{{ucfirst(__('consult.on review'))}}</a>
        <a href="{{route('lecturer.consult.ongoing')}}">{{ucfirst(__('consult.ongoing'))}}</a>
        <a href="{{route('lecturer.consult.history')}}">{{ucfirst(__('consult.history'))}}</a>
    </div>
@endsection
@section('thead')
    <th style="width: 40%;">{{ucfirst(__('consult.thesis'))}}</th>
    <th>{{__('consult.students')}}</th>
    <th style="width: 10%">{{__('consult.time')}}</th>
    <th>{{__('consult.location')}}</th>
    <th>{{ucfirst(__('consult.notes'))}}</th>
    <th colspan="2">{{__('consult.action')}}</th>
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
                <a href="#"
                    class="action-btn"
                    data-url="{{ route('lecturer.consult.review.accept', $a) }}"
                    data-action="accept">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
                </a>
            </td>
            <td>
                <a href="#"
                    class="action-btn"
                    data-url="{{ route('lecturer.consult.review.reject', $a) }}"
                    data-action="reject">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7">
                {{__('consult.all reviewed')}}
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
        'accept': "{{__('consult.accept message')}}",
        'reject': "{{__('consult.reject message')}}",
    }
    const additions = {
        'accept': '',
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