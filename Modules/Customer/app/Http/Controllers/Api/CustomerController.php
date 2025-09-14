<?php

namespace Modules\Customer\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Modules\Customer\Models\Customer;

use Modules\Booking\Models\Booking;

class CustomerController extends Controller
{

    public function showClientFromBooking($id)
    {
        $booking = Booking::findOrFail($id);

        $client = Customer::findOrFail($booking->customer_id);

        return response()->json(['client' => $client]);
    }


    public function index(Request $request)
    {
        $tenantId = auth()->user()->tenant_id;
        return Customer::where('tenant_id', $tenantId)->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
        ]);

        $data['tenant_id'] = auth()->user()->tenant_id;

        return Customer::create($data);
    }

    public function show(Customer $customer)
    {
        $this->authorizeCustomer($customer);
        return $customer;
    }


    public function update(Request $request, $id)
    {
        \Log::info('Update Request:', $request->all()); // Debug input

        $customer = Customer::findOrFail($id);

        $customer->name = $request->clientName;
        $customer->email = $request->clientPhone;
        $customer->phone = $request->clientEmail;

        $customer->save();

        $updatedCustomer = Customer::find($id);

        return response()->json([
            'message' => 'Customer updated',
            'customer' => $updatedCustomer,
        ]);
    }


    public function destroy(Customer $customer)
    {
        $this->authorizeCustomer($customer);
        $customer->delete();
        return response()->json(['message' => 'Customer deleted']);
    }

    private function authorizeCustomer(Customer $customer)
    {
        if ($customer->tenant_id !== auth()->user()->tenant_id) {
            abort(403, 'Unauthorized');
        }
    }
}
