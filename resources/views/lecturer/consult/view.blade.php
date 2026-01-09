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
    @if ($appointment->notes->isEmpty()) 
        <div class="notes glass center">
            <h1>{{__('consult.no notes')}}</h1>
            <p>{{__('consult.start notes')}} 
                <a href="{{route('lecturer.consult.notes.create', $appointment)}}" class="button small blue">{{ucfirst(__('consult.here'))}} <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-open-icon lucide-book-open"><path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/></svg></a>
            </p>
        </div>
    @else
        <div class="notes glass">
            <h1>{{__('consult.lecturer comment')}}</h1>
            <p>{{$appointment->comments}}</p>
            <h1>{{__('consult.comments')}}:</h1>
            <ol>
                @foreach ($appointment->notes as $note)
                    <li>
                        {{ucfirst($note->note)}}
                    </li>
                @endforeach
            </ol>
        </div>
    @endif
@endsection