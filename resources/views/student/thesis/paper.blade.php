@extends('layout.paper')
@section('title')
ThesisMeet - {{$thesis->title}}
@endsection
@section('pdf')
<iframe
    id="pdfFrame"
    src="{{ asset('storage/' . $thesis->paper_path) }}"
    loading="lazy">
</iframe>
@endsection