<?php

namespace Modules\Booking\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Modules\Booking\Models\Booking;
use Modules\Service\Models\Service;
use Modules\Tenant\Models\TenantSetting;
use Modules\Customer\Models\Customer;
use Modules\Payment\Models\Payment;



use DB;
class BookingController extends Controller
{

    public function create()
    {
        $services = Service::where('tenant_id', auth()->user()->tenant_id)->get();
        return view('bookings.create', compact('services'));
    }


    public function store(Request $request)
    {
        // Create or find customer
        $customer = Customer::firstOrCreate(
            ['email' => $request->email],
            ['name' => $request->name, 'phone' => $request->phone, 'tenant_id' => $request->tenant_id]
        );

        // Create booking
        $booking = Booking::create([
            'tenant_id' => $request->tenant_id,
            'service_id' => $request->service_id,
            'customer_id' => $customer->id,
            'booked_date' => $request->booked_date,
            'booked_time' => $request->booked_time,
        ]);

           $payment = Payment::create([
            'booking_id'      => $booking->id,
            'payment_status'  => 'pending', // يبدأ كـ pending
            'payment_method'  => 'cash',
            'total'           => 0,
            'transaction_id'  => "1234",
            'metadata'        => "1234",
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking created successfully',
            'booking' => $booking,
        ]);
    }

    public function index(Request $request)
    {
        $tenantId = $request->query('tenant_id');

        $bookings = Booking::with(['service', 'customer', 'payment'])
            ->where('tenant_id', $tenantId)
            ->get();

        return response()->json($bookings);
    }



    public function show($id)
    {

        $booking = Booking::with('service')->findOrFail($id);


        return response()->json(['booking' => $booking]);

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
    public function update(Request $request, $id)
    {
        \Log::info('Update Request:', $request->all()); // Debug input

        $booking = Booking::findOrFail($id);

        $booking->booked_date = $request->date;
        $booking->booked_time = $request->time;
        $booking->service_id = $request->serviceId;


        $booking->status = $request->status ?? $booking->status;

        $booking->save();

        $updatedBooking = Booking::with(['service', 'customer', 'payment'])
            ->where('tenant_id', $booking->tenant_id)
            ->where('id', $id) // ⬅️ Add this line to filter by specific booking
            ->first();

        return response()->json([
            'message' => 'Booking updated',
            'booking' => $updatedBooking,
        ]);
    }

    public function updateStatus(Request $request, $id, $status)
    {
        $booking = Booking::findOrFail($id);

        // Set status to 'confirmed'
        $booking->status = $status;
        $booking->save();

        $confirmedBooking = DB::table('bookings')
            ->join('customers', 'bookings.customer_id', '=', 'customers.id')
            ->join('services', 'bookings.service_id', '=', 'services.id')
            ->leftJoin('payments', 'bookings.id', '=', 'payments.booking_id')
            ->where('bookings.id', $booking->id)
            ->select(
                'bookings.id',
                'bookings.booking_code',
                'customers.name as customerName',
                'customers.phone',
                'services.name as service',
                'bookings.booked_date',
                'bookings.booked_time',
                'bookings.status',
                'payments.payment_status as paymentStatus',
                'payments.payment_method as paymentMethod',
                'payments.total'
            )
            ->first(); // Get single record

        return response()->json([
            'message' => 'Booking confirmed',
            'booking' => $confirmedBooking,
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    }

    public function Home($tenantId)
    {

        $tenantSettings = TenantSetting::where('tenant_id', $tenantId)->first();

        return response()->json([
            'tenantSettings' => $tenantSettings,
        ]);
    }



    public function test(Request $request)
    {
        // Create or find customer
        $customer = Customer::firstOrCreate(
            ['email' => "tech@jumppeak.net"],
            ['name' => "لمى عباس", 'phone' => "50950123456", 'tenant_id' => 1]
        );

        // Create booking
        $booking = Booking::create([
            'tenant_id' => 1,
            'service_id' => 3,
            'customer_id' => $customer->id,
            'booked_date' => "2025-09-01",
            'booked_time' => "5:00 PM",
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking created successfully',
            'booking' => $booking,
        ]);
    }

}
