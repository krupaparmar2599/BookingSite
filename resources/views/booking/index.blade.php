@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h3>Your Bookings</h3>
        <a href="{{ route('booking.process') }}" class="btn btn-outline-secondary btn-sm">Back to Form</a>
    </div>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Booking Date</th>
                <th>Booking Type</th>
                <th>Slot</th>
                <th>From Time</th>
                <th>To Time</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
            <tr>
                <td>{{ $booking->id }}</td>
                <td>{{ $booking->booking_date }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $booking->booking_type)) }}</td>
                <td> {{ $booking->booking_slot ? ucwords(str_replace('_', ' ', $booking->booking_slot)) : '-' }}</td>

                <td>{{ $booking->from_time ?? '-' }}</td>
                <td>{{ $booking->to_time ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No bookings found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection