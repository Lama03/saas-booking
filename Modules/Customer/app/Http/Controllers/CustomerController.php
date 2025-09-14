<?php

namespace Modules\Customer\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Modules\Customer\Models\Customer;

class CustomerController extends Controller
{
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

    public function update(Request $request, Customer $customer)
    {
        $this->authorizeCustomer($customer);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
        ]);

        $customer->update($data);
        return $customer;
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
