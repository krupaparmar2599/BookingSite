@extends('layouts.app')

@section('title', 'Booking Form')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('booking.index') }}" class="btn btn-outline-secondary btn-sm">See Bookings</a>
        </div>

        <div class="card shadow-sm custom_card">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Create Booking</h4>
            </div>

            <div class="card-body">
                <form id="bookingForm" method="POST" action="{{ route('booking.store') }}" data-parsley-validate>
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Customer Name</label>
                        <input type="text" name="customer_name" class="form-control form-control-sm"
                            required
                            data-parsley-pattern="^[A-Za-z ]+$"
                            data-parsley-pattern-message="Name must contain only letters"
                            data-parsley-minlength="3"
                            data-parsley-required-message="Customer name is required"
                            data-parsley-trigger="keyup"
                            value="{{ old('customer_name') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Customer Email</label>
                        <input type="email" name="customer_email" class="form-control form-control-sm"
                            required
                            data-parsley-type="email"
                            data-parsley-type-email-message="Please enter a valid email address"
                            data-parsley-required-message="Email is required"
                            data-parsley-trigger="keyup"
                            value="{{ old('customer_email') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Booking Date</label>
                        <input type="text" id="booking_date" name="booking_date" class="form-control form-control-sm"
                            required
                            data-parsley-required-message="Booking date is required"
                            value="{{ old('booking_date') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Booking Type</label>
                        <select name="booking_type" id="booking_type" class="form-select form-select-sm" required
                            data-parsley-required-message="Booking type is required">
                            <option value="">-- Select Booking Type --</option>
                            <option value="full_day">Full Day</option>
                            <option value="half_day">Half Day</option>
                            <option value="custom">Custom</option>
                        </select>
                    </div>

                    <!-- Booking Slot (visible only if Half Day) -->
                    <div class="mb-3 d-none" id="slotWrapper">
                        <label class="form-label">Booking Slot</label>
                        <select name="booking_slot" id="booking_slot" class="form-select form-select-sm">
                            <option value="">-- Select Slot --</option>
                            <option value="first_half">First Half</option>
                            <option value="second_half">Second Half</option>
                        </select>
                    </div>

                    <!-- Booking From & To Time (visible only if Custom) -->
                    <div class="row d-none" id="timeWrapper">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">From Time</label>
                            <input type="text" id="from_time" name="from_time" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">To Time</label>
                            <input type="text" id="to_time" name="to_time" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-sm">Book Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        $('#bookingForm').parsley();

        // Show/hide fields based on booking type
        $('#booking_type').on('change', function() {
            let type = $(this).val();

            if (type === 'half_day') {
                $('#slotWrapper').removeClass('d-none');
                $('#slotWrapper select').attr('required', 'required'); // make required

                $('#timeWrapper').addClass('d-none');
                $('#timeWrapper input').removeAttr('required'); // remove required

            } else if (type === 'custom') {
                $('#slotWrapper').addClass('d-none');
                $('#slotWrapper select').removeAttr('required');

                $('#timeWrapper').removeClass('d-none');
                $('#timeWrapper input').attr('required', 'required'); // both times required

            } else {
                $('#slotWrapper').addClass('d-none');
                $('#slotWrapper select').removeAttr('required');

                $('#timeWrapper').addClass('d-none');
                $('#timeWrapper input').removeAttr('required');
            }

            // re-validate form when type changes
            $('#bookingForm').parsley().reset();
        });
    });
</script>


<script>
    // Date picker 
    flatpickr("#booking_date", {
        dateFormat: "Y-m-d",
        minDate: "today"
    });

    // From Time
    const fromPicker = flatpickr("#from_time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        onChange: function(selectedDates) {
            if (selectedDates.length > 0) {
                const fromTime = selectedDates[0];
                // set minTime for to_time after fromTime
                toPicker.set("minTime", fromTime);

                // if already selected to_time is less than from_time → reset it
                if (toPicker.selectedDates.length > 0) {
                    if (toPicker.selectedDates[0] < fromTime) {
                        toPicker.clear(); // reset to_time
                    }
                }
            }
        }
    });

    // To Time
    const toPicker = flatpickr("#to_time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });
</script>
@endpush