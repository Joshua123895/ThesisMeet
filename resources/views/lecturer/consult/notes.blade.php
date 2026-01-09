@extends('layout.paper')
@section('title')
ThesisMeet - {{$appointment->thesis->title}}
@endsection
@section('pdf')
<iframe
    id="pdfFrame"
    src="{{ asset('storage/' . $appointment->paper_path) }}"
    loading="lazy">
</iframe>
@endsection
@section('notes')
    <form class="notes glass separate" action="{{route('lecturer.consult.notes.update', $appointment)}}" method="POST">
        @csrf
        @method('put')
        <div class="form-inside">
            <h1>{{__('consult.lecturer comment')}}</h1>
            <input type="text" name="comment" placeholder="{{__('consult.short comment')}}" value="{{$appointment->comments}}">
            <h1>{{__('consult.comments')}}:</h1>
            <ol id="notes-list">
                @foreach ($appointment->notes as $note)
                    <li>
                        <span>{{ ucfirst($note->note) }}</span>
                        <button type="button" class="delete-note">×</button>
    
                        <input type="hidden" name="notes[]" value="{{ $note->note }}">
                    </li>
                @endforeach
            </ol>
    
            <button type="button" id="add-note" class="button blue">
                {{ucfirst(__('consult.new note'))}} 
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            </button>
        </div>

        <div class="buttons">
            <a href="{{route('lecturer.consult.ongoing')}}" class="button white">
                {{ucfirst(__('consult.back'))}}
            </a>
            <button type="submit" class="button blue">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-save-icon lucide-save"><path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"/><path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7"/><path d="M7 3v4a1 1 0 0 0 1 1h7"/></svg>
                {{ucfirst(__('consult.save notes'))}}
            </button>
        </div>
    </form>
@endsection
@section('script')
<script>
const notesList = document.getElementById('notes-list');
const addNoteBtn = document.getElementById('add-note');

addNoteBtn.addEventListener('click', () => {
    if (document.querySelector('.note-input')) return;

    const li = document.createElement('li');
    li.classList.add('note-input');

    li.innerHTML = `
        <input type="text" placeholder="Type note and press Enter" required>
    `;

    notesList.appendChild(li);

    const input = li.querySelector('input');
    input.focus();

    input.addEventListener('keydown', e => {
        if (e.key === 'Enter') {
            e.preventDefault();

            const value = input.value.trim();
            if (!value) return;

            li.innerHTML = `
                <span>${value}</span>
                <button type="button" class="delete-note">×</button>
                <input type="hidden" name="notes[]" value="${value}">
            `;
            li.classList.remove('note-input');
        }
    });
});

notesList.addEventListener('click', e => {
    if (e.target.classList.contains('delete-note')) {
        e.target.closest('li').remove();
    }
});
</script>

@endsection