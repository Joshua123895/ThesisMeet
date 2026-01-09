@extends('layout.navbar')
@section('styles1')
    <link rel="stylesheet" href="{{asset('css/thesis/create.css')}}">
@endsection
@section('title')
    ThesisMeet - {{__('thesis.new thesis')}}
@endsection
@section('content1')
    <form action="{{route('student.thesis.store')}}" method="POST" class="container glass">
        @csrf
        <h1>{{__('thesis.create new thesis')}}</h1>
        <div class="input-group">
            <div class="label">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-line-icon lucide-pencil-line"><path d="M13 21h8"/><path d="m15 5 4 4"/><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/></svg>
                {{__('thesis.thesis name')}}
            </div>
            <input type="text" name="name" placeholder="{{__('thesis.research about something')}}" required>
        </div>
        <div class="two">
            <div class="search">
                <div class="label">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
                    {{__('thesis.students')}}
                </div>
                <input
                    type="text"
                    id="student-input"
                    placeholder="{{__('thesis.search')}}"
                    autocomplete="off">
                <div class="results" id="student-results"></div>
                <div class="selected" id="selected-student"></div>
            </div>
            <div class="search">
                <div class="label">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
                    {{__('thesis.lecturers')}}
                </div>
                <div class="search-result">
                    <input
                        type="text"
                        id="lecturer-input"
                        placeholder="{{__('thesis.search')}}"
                        autocomplete="off">
                    <div class="results" id="lecturer-results"></div>
                </div>
                <div class="selected" id="selected-lecturer"></div>
            </div>
        </div>
        <div class="buttons">
            <a href="" class="button white">{{__('thesis.back')}}</a>
            <button class="button blue" type="submit">{{__('thesis.submit')}}</button>
        </div>
    </form>
    <script>
    const lecturerLink = `{{route('student.thesis.lecturer.search')}}`;
    const studentLink = `{{route('student.thesis.student.search')}}`;
    function selectResult(name) {
        const inputName = name+'-input';
        const resultsName = name+'-results';
        const selectedName = 'selected-'+name;
        console.log(inputName, resultsName, selectedName);
        const input = document.getElementById(inputName);
        const results = document.getElementById(resultsName);
        const selected = document.getElementById(selectedName);
    
        const selectedIds = new Set();
    
        input.addEventListener('input', () => {
            const q = input.value.trim();
            if (q.length < 2) {
                results.innerHTML = '';
                return;
            }
    
            fetch(`${name === 'lecturer'? lecturerLink : studentLink}?q=${encodeURIComponent(q)}`)
                .then(r => r.json())
                .then(data => {
                    results.innerHTML = '';
    
                    data.forEach(l => {
                        if (selectedIds.has(l.id)) return;
    
                        results.innerHTML += `
                            <div class="result-item" data-id="${l.id}" data-name="${l.name}">
                                ${l.name}
                            </div>
                        `;
                    });
                });
        });
    
        results.addEventListener('click', e => {
            const item = e.target.closest('.result-item');
            if (!item) return;
    
            const id = item.dataset.id;
            const label = item.dataset.name;
    
            selectedIds.add(Number(id));
    
            selected.innerHTML += `
                <div class="tag" data-id="${id}">
                    ${label}
                    <span type="button" class="close-button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </span>
                    <input type="hidden" name="${name}s[]" value="${id}">
                </div>
            `;
    
            input.value = '';
            results.innerHTML = '';
        });
    
        selected.addEventListener('click', e => {
            const closeBtn = e.target.closest('.close-button');
            if (!closeBtn) return;

            const tag = closeBtn.closest('.tag');
            selectedIds.delete(Number(tag.dataset.id));
            tag.remove();
        });
    }
    selectResult('lecturer');
    selectResult('student');
    </script>

@endsection