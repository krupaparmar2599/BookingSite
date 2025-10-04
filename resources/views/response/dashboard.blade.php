@extends('layouts.app')

@section('title', 'Registration Success')

@section('content')

<body>
    <div class="message-box">
        <h1>Login Successful!</h1>

        <p>Welcome, {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}!</p>
        <p>You are now on your Dashboard :) </p>

            <a href="{{ route('register') }}" class="home-button">Go to Register</a>
    </div>
</body>
@endsection