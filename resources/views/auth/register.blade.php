@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card shadow-sm custom_card">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">User Registration</h4>
            </div>
            <div class="card-body">
                <form id="registerForm" method="POST" action="{{ route('register.store') }}" data-parsley-validate>
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control form-control-sm"
                            required
                            data-parsley-pattern="^[A-Za-z]+$"
                            data-parsley-pattern-message="First name must contain only letters"
                            data-parsley-minlength="3"
                            data-parsley-minlength-message="First name must be at least 3 characters"
                            data-parsley-required-message="First name is required"
                            data-parsley-trigger="keyup"
                            value="{{ old('first_name') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control form-control-sm"
                            required
                            data-parsley-pattern="^[A-Za-z]+$"
                            data-parsley-pattern-message="Last name must contain only letters"
                            data-parsley-minlength="3"
                            data-parsley-minlength-message="Last name must be at least 3 characters"
                            data-parsley-required-message="Last name is required"
                            data-parsley-trigger="keyup"
                            value="{{ old('last_name') }}">
                    </div>

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
                    <div class="mb-3 position-relative">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password"
                            class="form-control form-control-sm"
                            required
                            data-parsley-minlength="6"
                            data-parsley-required-message="Password is required"
                            data-parsley-minlength-message="Password must be at least 6 characters"
                            data-parsley-trigger="keyup"
                            placeholder="Enter password">
                        <!-- Eye icon stick style -->
                        <span toggle="#password" class="toggle-password"
                            style="position:absolute; top:38px; right:10px; cursor:pointer;">
                            <i class="fa-solid fa-eye"></i>
                        </span>
                    </div>

                    <div class="mb-3 position-relative">
                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control form-control-sm"
                            required
                            data-parsley-equalto="#password"
                            data-parsley-equalto-message="Passwords do not match"
                            data-parsley-required-message="Confirm password is required"
                            data-parsley-trigger="keyup"
                            placeholder="Confirm password">
                        <!-- Eye icon stick style -->
                        <span toggle="#password_confirmation" class="toggle-password"
                            style="position:absolute; top:38px; right:10px; cursor:pointer;">
                            <i class="fa-solid fa-eye"></i>
                        </span>
                    </div>


                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-sm">Register</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                Already have an account? <a href="{{ route('login') }}">Login</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        $('#registerForm').parsley();
    });
</script>

<script>
    $(document).ready(function() {
        $('.toggle-password').click(function() {
            var input = $(this).siblings('input');
            var icon = $(this).find('i');

            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash'); // eye with slash
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye'); // normal eye
            }
        });
    });
</script>

@endpush