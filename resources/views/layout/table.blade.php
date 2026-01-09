@extends('layout.tabs')
@section('styles2')
    <link rel="stylesheet" href="{{asset('css/layout/table.css')}}">
@endsection
@section('inside')
    <div class="table-container">
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        @yield('thead')
                    </tr>
                </thead>
                <tbody>
                    @yield('tbody')
                </tbody>
            </table>
        </div>
    </div>
@endsection