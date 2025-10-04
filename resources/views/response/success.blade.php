@extends('layouts.app')

@section('title', 'Registration Success')

@section('content')
<div class="message-box">
    <h1>Registration Successful!</h1>

    @if(session('success'))
    <p>{{ session('success') }}</p>
    @endif

    @if(session('role') === 'customer')
    <a href="{{ route('home') }}" class="home-button">Go to Home</a>
    @elseif(session('role') === 'admin')
    <a href="{{ route('login') }}" class="home-button">Go to Login</a>
    @endif
</div>
@endsection