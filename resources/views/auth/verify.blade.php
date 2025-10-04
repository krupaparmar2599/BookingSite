@extends('layouts.app')

@section('title', 'Verify Account')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Enter Verification Code</h4>
            </div>
            <div class="card-body text-center">
                <form id="verifyForm" method="POST" action="{{ route('verification.check') }}">
                    @csrf

                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <input type="text" name="digit1" maxlength="1" class="form-control text-center otp-input" >
                        <input type="text" name="digit2" maxlength="1" class="form-control text-center otp-input" >
                        <input type="text" name="digit3" maxlength="1" class="form-control text-center otp-input" >
                        <input type="text" name="digit4" maxlength="1" class="form-control text-center otp-input" >
                    </div>

                    <div id="error-msg" class="text-danger small mb-2" style="display:none;">
                        Please enter all 4 digits.
                    </div>

                    <button type="submit" class="btn btn-success btn-sm w-100">Verify</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const inputs = document.querySelectorAll(".otp-input");
    const form = document.getElementById("verifyForm");
    const errorMsg = document.getElementById("error-msg");

    inputs.forEach((input, index) => {
        // Allow only digits
        input.addEventListener("input", function() {
            this.value = this.value.replace(/[^0-9]/g, ""); // remove non-digit

            if (this.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });

        // Backspace navigation
        input.addEventListener("keydown", function(e) {
            if (e.key === "Backspace" && this.value === "" && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });

    // Form validation
    form.addEventListener("submit", function(e) {
        let isValid = true;

        inputs.forEach(input => {
            if (input.value.trim() === "" || !/^\d$/.test(input.value)) {
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();
            errorMsg.style.display = "block";
        } else {
            errorMsg.style.display = "none";
        }
    });
});
</script>
@endpush
