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