<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{

    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->orderBy('booking_date', 'desc')
            ->get();

        return view('booking.index', compact('bookings'));
    }

    public function process()
    {
        return view('booking.booking');
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_date' => 'required|date',
            'booking_type' => 'required|in:full_day,half_day,custom',
            'booking_slot' => 'nullable|in:first_half,second_half',
            'from_time'    => 'nullable|date_format:H:i',
            'to_time'      => 'nullable|date_format:H:i|after:from_time',
        ]);

        $userId = Auth::id();
        $date = $request->booking_date;

        $query = Booking::where('booking_date', $date);

        if ($request->booking_type === 'full_day') {
            $exists = $query->exists();
        } elseif ($request->booking_type === 'half_day') {
            $exists = $query->where(function ($q) use ($request) {
                $q->where('booking_type', 'full_day')
                    ->orWhere(function ($q2) use ($request) {
                        $q2->where('booking_type', 'half_day')
                            ->where('booking_slot', $request->booking_slot);
                    })
                    ->orWhere(function ($q3) use ($request) {
                        if ($request->booking_slot === 'first_half') {
                            $q3->where('booking_type', 'custom')
                                ->whereBetween('from_time', ['08:00', '12:00']);
                        } else {
                            $q3->where('booking_type', 'custom')
                                ->whereBetween('from_time', ['12:00', '18:00']);
                        }
                    });
            })->exists();
        } elseif ($request->booking_type === 'custom') {
            $from = $request->from_time;
            $to   = $request->to_time;

            $exists = $query->where(function ($q) use ($from, $to) {
                $q->where('booking_type', 'full_day')
                    ->orWhere(function ($q2) use ($from, $to) {
                        $q2->where('booking_type', 'half_day')
                            ->whereIn('booking_slot', ['first_half', 'second_half']);
                    })
                    ->orWhere(function ($q3) use ($from, $to) {
                        $q3->where('booking_type', 'custom')
                            ->where(function ($q4) use ($from, $to) {
                                $q4->whereBetween('from_time', [$from, $to])
                                    ->orWhereBetween('to_time', [$from, $to]);
                            });
                    });
            })->exists();
        } else {
            $exists = false;
        }

        if ($exists) {
            return redirect()->back()->with('error', 'Booking failed! The selected slot overlaps with an existing booking.');
        }

        Booking::create([
            'user_id'       => $userId,
            'booking_date'  => $request->booking_date,
            'booking_type'  => $request->booking_type,
            'booking_slot'  => $request->booking_type === 'half_day' ? $request->booking_slot : null,
            'from_time'     => $request->booking_type === 'custom' ? $request->from_time : null,
            'to_time'       => $request->booking_type === 'custom' ? $request->to_time : null,
        ]);
        // dd("done");
        return redirect()->route('booking.index')->with('success', 'Booking placed successfully!');
    }
}
