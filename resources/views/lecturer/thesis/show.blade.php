@extends('layout.table')
@section('title')
    ThesisMeet - {{__('thesis.thesis manager')}}
@endsection
@section('heading')
    {{__('thesis.thesis manager')}}
@endsection
@section('thead')
    <th style="width: 40%">{{__('thesis.thesis title')}}</th>
    <th>{{__('thesis.students')}}</th>
    <th>{{__('thesis.lecturers')}}</th>
    <th>{{__('thesis.status')}}</th>
    <th colspan="2">{{__('thesis.action')}}</th>
@endsection
@section('tbody')
    @forelse ($theses as $thesis)
        <tr>
            <td>{{ $thesis->title }}</td>

            <td>
                @foreach ($thesis->students as $student)
                    {{ $student->name }}<br>
                @endforeach
            </td>

            <td>
                @foreach ($thesis->lecturers as $lecturer)
                    {{ $lecturer->name }} {{$lecturer->id === $user->id ? __('thesis.you') : ''}}<br>
                @endforeach
            </td>
            <td>
                {{-- {{$thesis->pivot->status}} --}}
                @if ($thesis->display_status === 'on going')
                    <span class="blue">
                @elseif ($thesis->display_status === 'requested')
                    <span class="gray">
                @elseif ($thesis->display_status === 'finished')
                    <span class="green">
                @else
                    <span class="red">
                @endif
                    {{__('thesis.' . $thesis->display_status)}}
                </span>
            </td>
            @if ($thesis->display_status === 'requesting')
                <td>
                    <a href="#"
                        class="action-btn"
                        data-url="{{ route('lecturer.thesis.accept', $thesis) }}"
                        data-action="accept">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
                    </a>
                </td>
                <td>
                    <a href="#"
                        class="action-btn"
                        data-url="{{ route('lecturer.thesis.reject', $thesis) }}"
                        data-action="reject">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </a>
                </td>
            @elseif ($thesis->paper_path)
                <td>
                    <a href="{{route('lecturer.thesis.paper', $thesis)}}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                    </a>
                </td>
                <td>
                    @if ($thesis->pivot->position === 1 && $thesis->is_done === 0)
                        <a href="#"
                            class="action-btn"
                            data-url="{{ route('lecturer.thesis.approve', $thesis) }}"
                            data-action="approve">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-signature-icon lucide-signature"><path d="m21 17-2.156-1.868A.5.5 0 0 0 18 15.5v.5a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1c0-2.545-3.991-3.97-8.5-4a1 1 0 0 0 0 5c4.153 0 4.745-11.295 5.708-13.5a2.5 2.5 0 1 1 3.31 3.284"/><path d="M3 21h18"/></svg>
                        </a>
                    @else
                        <a href="{{route('lecturer.thesis.paper.download', $thesis)}}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download-icon lucide-download"><path d="M12 15V3"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m7 10 5 5 5-5"/></svg>
                        </a>
                    @endif
                </td>
            @endif
        </tr>
    @empty
        <tr>
            <td colspan="6">
                No thesis have been created. Start a new thesis!
            </td>
        </tr>
    @endforelse
@endsection
@section('buttons')
    <a href="{{route('lecturer.home')}}" class="button white">Back</a>
@endsection
@section('script')
    <div class="modal-overlay hidden" id="confirm-overlay"></div>

    <div class="modal hidden" id="confirm-modal">
        <h1 id="confirm-title">{{__('thesis.are you sure')}}</h1>
        <p id="confirm-message"></p>

        <div class="buttons">
            <button class="button blue" id="confirm-cancel">{{__('thesis.cancel')}}</button>
            <a class="button red" id="confirm-proceed">{{__('thesis.proceed')}}</a>
        </div>
    </div>
<script>
    const actionButtons = document.querySelectorAll('.action-btn');

    const confirmOverlay = document.getElementById('confirm-overlay');
    const confirmModal = document.getElementById('confirm-modal');
    const confirmMessage = document.getElementById('confirm-message');
    const confirmProceed = document.getElementById('confirm-proceed');
    const confirmCancel = document.getElementById('confirm-cancel');
    const messages = {
        'accept': `{{__('thesis.accept message lecturer')}}`,
        'reject': `{{__('thesis.reject message lecturer')}}`,
        'approve': `{{__('thesis.approve message')}}`,
    }
    actionButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            const url = btn.dataset.url;
            const action = btn.dataset.action;

            confirmMessage.textContent = messages[action];

            confirmProceed.href = url;

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