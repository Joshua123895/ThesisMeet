@extends('student.paper.show')
@section('notes')
    @if ($appointment->notes->isEmpty()) 
        <div class="notes glass center">
            <h1>{{__('consult.no notes from lecturer')}}</h1>
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