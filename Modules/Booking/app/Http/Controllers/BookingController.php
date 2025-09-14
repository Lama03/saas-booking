<?php

namespace Modules\Booking\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Modules\Booking\Models\Booking;

class BookingController extends Controller
{

    public function create()
    {
        $services = Service::where('tenant_id', auth()->user()->tenant_id)->get();
        return view('bookings.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
        ]);

        $tenantId = auth()->user()->tenant_id;

        // Check for overlapping bookings for the same service
        $overlap = Booking::where('service_id', $request->service_id)
            ->where('tenant_id', $tenantId)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })->exists();

        if ($overlap) {
            return back()->withErrors('Selected time slot is already booked.');
        }

        Booking::create([
            'tenant_id' => $tenantId,
            'service_id' => $request->service_id,
            'customer_id' => auth()->id(),
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully!');
    }

    public function index()
    {
        $tenantId = auth()->user()->tenant_id;
        $bookings = Booking::where('tenant_id', $tenantId)->with('service')->get();
        return view('bookings.index', compact('bookings'));
    }
    


    public function show($id)
    {
        return view('booking::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('booking::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
