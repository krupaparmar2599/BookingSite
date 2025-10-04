@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card shadow-sm custom_card">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">User Login</h4>
            </div>
            <div class="card-body">
                <form id="LoginForm" method="POST" action="{{ route('login.check') }}" data-parsley-validate>
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control form-control-sm"
                            required
                            data-parsley-type="email"
                            data-parsley-type-email-message="Please enter a valid email address"
                            data-parsley-required-message="Email is required"
                            data-parsley-trigger="keyup"
                            value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" id="password" name="password"
                            class="form-control form-control-sm"
                            required
                            data-parsley-required-message="Password is required"
                            data-parsley-trigger="keyup">
                    </div>


                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-sm">Login</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                Don't have an account? <a href="{{ route('register') }}">Register</a>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        $('#LoginForm').parsley();
    });
</script>
@endpush