<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/layout/basic.css')}}">
    @yield('styles')
    <link rel="icon" type="image/x-icon" href="{{asset('image/logo-small.png')}}">
    <title>@yield('title')</title>
</head>
<body>
    @if ($errors->any())
        <div class="alert alert-error">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <strong>
                @if (count($errors->all()) > 1)
                    {{count($errors->all())}} {{__('auth.errors occured')}}
                @else
                    {{ucfirst(__('auth.error occured'))}}
                @endif
            </strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-error">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            {{ session('error') }}
        </div>
    @endif
    @yield('content')
</body>
</html>