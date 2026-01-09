@extends('layout.basic')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/auth/auth.css')}}">
    <link rel="stylesheet" href="{{asset('css/auth/register.css')}}">
@endsection
@section('title', 'ThesisMeet - ' . ucfirst(__('auth.register')))
@section('content')
    <div class="container" id="container">
        <form class="student" method="POST" action="/register/student">
            @csrf
            <div class="upper-auth">
                <h2>{{ucwords(__('auth.student registration'))}}</h2>
                <div class="input-group">
                    <label>{{ucwords(__('auth.name'))}}</label>
                    <input type="text" name="name"
                            placeholder="James" required>
                </div>
                <div class="input-group">
                    <label>{{ucwords(__('auth.email'))}}</label>
                    <input type="email" name="email"
                            placeholder="anonymous@domain.com" required>
                </div>
                <div class="input-group">
                    <label>{{ucwords(__('auth.password'))}}</label>
                    <input type="password" name="password"
                    placeholder="password123" required>
                </div>
                <div class="input-group">
                    <label>{{ucwords(__('auth.student ID'))}}</label>
                    <input type="number" name="nim"
                            placeholder="2701234567" min="0" max="9999999999"
                            required>
                </div>
                <div class="input-group">
                    <label>{{ucwords(__('auth.major'))}}</label>
                    <select name="major" required>
                        <option value='computer science'> Computer Science </option>
                        <option value='international business management'> International Business Management </option>
                        <option value='information systems'> Information Systems </option>
                        <option value='digital marketing'> Digital Marketing </option>
                        <option value='data science'> Data Science </option>
                        <option value='business analytics'> Business Analytics </option>
                    </select>
                </div>

            </div>
            <div class="lower-auth">
                <button>
                    {{ucwords(__('auth.register'))}}
                </button>
                <p>{{ucfirst(__('auth.already have an account'))}}? <a href="{{route('login')}}">{{ucfirst(__('auth.login'))}}</a></p>
            </div>
        </form>

        <form class="lecturer" method="POST" action="/register/lecturer" enctype="multipart/form-data">
            @csrf
            <div class="upper-auth">
                <h2>{{ucwords(__('auth.lecturer registration'))}}</h2>
                <div class="input-group">
                    <label>{{ucfirst(__('auth.name'))}}</label>
                    <input type="text" name="name"
                            placeholder="James" required>
                </div>
                <div class="input-group">
                    <label>{{ucfirst(__('auth.email'))}}</label>
                    <input type="email" name="email"
                            placeholder="anonymous@domain.com" required>
                </div>
                <div class="input-group">
                    <label>{{ucfirst(__('auth.password'))}}</label>
                    <input type="password" name="password"
                    placeholder="password123" required>
                </div>
                <div class="input-half no-margin">
                    <div class="input-group">
                        <label>{{ucwords(__('auth.phone number'))}}</label>
                        <input type="number" name="phone"
                                placeholder="021234567890" min="0" max="999999999999"
                                required>
                    </div>
                    <div class="input-group big-input no-margin">
                        <div class="input-half">
                            <div class="input-group no-margin">

                                <label>{{ucwords(__('auth.profile picture'))}}</label>
                                <div class="file-input">
                                    <input
                                        type="file"
                                        name="photo"
                                        id="photo"
                                        accept="image/*"
                                        required
                                    />
                                    <span class="file-placeholder">{{ucwords(__('auth.choose image'))}}</span>
                                </div>
                            </div>
    
                            <div class="image-preview">
                                <img id="preview" alt="Preview" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="input-group">
                    <label>{{ucwords(__('auth.profile description'))}}</label>
                    <textarea
                        placeholder="{{ucfirst(__('auth.write something about yourself'))}}..."
                        rows="4"
                        name="profile"
                        required
                    ></textarea>
                </div>
            </div>
            <div class="lower-auth">
                <button>
                    {{ucwords(__('auth.register'))}}
                </button>
                <p>{{ucfirst(__('auth.already have an account'))}}? <a href="{{route('login')}}">{{ucfirst(__('auth.login'))}}</a></p>
            </div>
        </form>

        <div class="overlay">
            <h1>
                {{ucfirst(__('auth.create account for'))}}<br>
                <span class="change-class">
                    <span class="change-track">
                        <span class="change-item">{{ucfirst(__('auth.student'))}}?</span>
                        <span class="change-item">{{ucfirst(__('auth.lecturer'))}}?</span>
                    </span>
                </span>
            </h1>
            <button onclick="toggle()">{{ucfirst(__('auth.click here'))}}</button>
            
        </div>
    </div>
    <script src="{{asset('js/register.js')}}"></script>
@endsection