<?php

namespace Modules\Service\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Service\Models\Service;
use Modules\Service\Models\Staff;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $tenantId = $request->query('tenant_id');

        if (!$tenantId) {
            return response()->json(['error' => 'Tenant ID missing'], 400);
        }

        $services = Service::with(relations: ['staff'])->where('tenant_id', operator: $tenantId)->get();

        return response()->json(['services' => $services]);
    }



    public function showStaffList($tenantId)
    {
        $staff = Staff::whereHas('services', function ($query) use ($tenantId) {
            $query->where('tenant_id', $tenantId);
        })->get();

        return response()->json(['staff' => $staff]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('service::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('service::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('service::edit');
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'category' => 'required|string',
            'duration' => 'required|integer',
            'price' => 'required|numeric',
            'status' => 'required|in:active,inactive',
            'staff' => 'array',
            'staff.*' => 'integer|exists:staff,id',
        ]);

        // Update service data
        $service->update([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'description' => $request->description,
            'duration' => $validated['duration'],
            'price' => $validated['price'],
            'status' => $validated['status'],
        ]);

        // Sync staff relationships
        $service->staff()->sync($validated['staff'] ?? []);

        return response()->json([
            'message' => 'Service updated successfully',
            'service' => $service->load('staff'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    }
}
