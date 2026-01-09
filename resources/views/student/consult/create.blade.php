@extends('layout.navbar')
@section('styles1')
    <link rel="stylesheet" href="{{asset('css/consult/create.css')}}">
@endsection
@section('title', 'ThesisMeet - ' . __('consult.reserve an appointment'))
@section('content1')
    <form action="{{route('student.consult.store')}}" class="glass" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <h1>{{ucfirst(__('consult.reserve an appointment'))}}</h1>
        <div class="filled">
            <div class="column">
                <div class="label">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <label for="lecturer">{{ucfirst(__('consult.lecturer'))}}</label>
                </div>
                <select name="lecturer" id="lecturer" required>
                    @foreach ($lecturers as $lecturer)
                        <option value="{{$lecturer->id}}">{{ucwords($lecturer->name)}}</option>
                    @endforeach
                </select>
                <div class="label">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock"><path d="M12 6v6l4 2"/><circle cx="12" cy="12" r="10"/></svg>
                    <label>{{ucfirst(__('consult.time'))}}</label>
                </div>
                <div class="time-range">
                    <input type="text" value="10" name="start_hh" class="number" inputmode="numeric" pattern="[0-9]{2}" maxlength="2" placeholder="HH" required>
                    <span>:</span>
                    <input type="text" value="00" name="start_mm" class="number" inputmode="numeric" pattern="[0-9]{2}" maxlength="2" placeholder="MM" required>

                    <span>-</span>

                    <input type="text" value="12" name="end_hh" class="number" inputmode="numeric" pattern="[0-9]{2}" maxlength="2" placeholder="HH" required>
                    <span>:</span>
                    <input type="text" value="00" name="end_mm" class="number" inputmode="numeric" pattern="[0-9]{2}" maxlength="2" placeholder="MM" required>
                </div>
                <div class="label">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sticky-note-icon lucide-sticky-note"><path d="M21 9a2.4 2.4 0 0 0-.706-1.706l-3.588-3.588A2.4 2.4 0 0 0 15 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2z"/><path d="M15 3v5a1 1 0 0 0 1 1h5"/></svg>
                    {{ucfirst(__('consult.attach paper'))}}
                </div>
                <div class="pdf-upload">
                    <input 
                        type="file" 
                        name="proposal_pdf"
                        id="pdfInput"
                        accept="application/pdf"
                        required
                        hidden
                    >

                    <label for="pdfInput" class="pdf-dropzone" id="pdfDropzone">
                        <div class="pdf-placeholder" id="pdfPlaceholder">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-cloud-upload-icon lucide-cloud-upload"><path d="M12 13v8"/><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/><path d="m8 17 4-4 4 4"/></svg>
                            <p>{{ucfirst(__('consult.upload pdf here'))}}</p>
                            <span>{{ucfirst(__('consult.click or drag drop'))}}</span>
                        </div>

                        <div class="pdf-file" id="pdfFile">
                            <p id="pdfFileName"></p>
                        </div>
                    </label>
                </div>
            </div>
            <div class="column">
                <div class="label">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-icon lucide-calendar"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
                    {{ucfirst(__('consult.date'))}}
                </div>
                <div class="time-range">
                    
                    <input type="text" value="01" name="day" class="number" inputmode="numeric" pattern="[0-9]{2}" maxlength="2" placeholder="DD" required>
                    <span>/</span>
                    <input type="text" value="01" name="month" class="number" inputmode="numeric" pattern="[0-9]{2}" maxlength="2" placeholder="MM" required>
                    <span>/</span>
                    <input type="text" value="2026" name="year" class="number" inputmode="numeric" pattern="[0-9]{4}" maxlength="4" placeholder="YYYY" required>
                </div>
                <div class="in-half">
                    <div>
                        <div class="label">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-icon lucide-building"><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M12 6h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M16 6h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/><path d="M8 6h.01"/><path d="M9 22v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/><rect x="4" y="2" width="16" height="20" rx="2"/></svg>
                            {{ucfirst(__('consult.onsite'))}}
                        </div>
                        <input type="checkbox" name="onsite" value="true">
                    </div>
                    <div class="location">
                        <div class="label">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin-icon lucide-map-pin"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                            {{ucfirst(__('consult.location'))}}
                        </div>
                        <input type="text" name="location" placeholder="{{__('consult.classroom or link here')}}" required>
                    </div>
                </div>
                <div class="label">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-notebook-pen-icon lucide-notebook-pen"><path d="M13.4 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7.4"/><path d="M2 6h4"/><path d="M2 10h4"/><path d="M2 14h4"/><path d="M2 18h4"/><path d="M21.378 5.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"/></svg>
                    {{ucfirst(__('consult.appointment notes'))}}
                </div>
                <textarea name="notes" placeholder="{{__('consult.reviewing something')}}" required>{{__('consult.reviewing something')}}</textarea>
            </div>
        </div>
        <div class="buttons">
            <a href="{{route('student.consult.ongoing')}}" class="button white">{{ucfirst(__('consult.back'))}}</a>
            <button type="submit" class="button blue">
                {{ucfirst(__('consult.submit'))}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" troke-linecap="round" stroke-linejoin="round" class="lucide lucide-send-icon lucide-send"><path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"/><path d="m21.854 2.147-10.94 10.939"/></svg>
            </button>
        </div>
    </form>
    <script>
const input = document.getElementById('pdfInput');
const dropzone = document.getElementById('pdfDropzone');
const placeholder = document.getElementById('pdfPlaceholder');
const fileBox = document.getElementById('pdfFile');
const fileName = document.getElementById('pdfFileName');

// Handle file select
input.addEventListener('change', () => {
    if (input.files.length > 0) {
        fileName.textContent = input.files[0].name;
        placeholder.style.display = 'none';
        fileBox.style.display = 'block';
    }
});

// Drag & drop behavior
dropzone.addEventListener('dragover', e => {
    e.preventDefault();
    dropzone.classList.add('dragover');
});

dropzone.addEventListener('dragleave', () => {
    dropzone.classList.remove('dragover');
});

dropzone.addEventListener('drop', e => {
    e.preventDefault();
    dropzone.classList.remove('dragover');

    if (e.dataTransfer.files.length > 0) {
        input.files = e.dataTransfer.files;
        fileName.textContent = e.dataTransfer.files[0].name;
        placeholder.style.display = 'none';
        fileBox.style.display = 'block';
    }
});
</script>
@endsection