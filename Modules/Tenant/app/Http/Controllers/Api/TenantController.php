<?php

namespace Modules\Tenant\App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\TenantSetting;

use Illuminate\Http\Request;


class TenantController extends Controller
{
    public function index()
    {
        return response()->json(Tenant::all());
    }


    public function show($tenantId)
    {
        $tenant = Tenant::with(relations: 'admin')
            ->findOrFail($tenantId);

        return response()->json(['tenant' => $tenant]);

    }

    public function update(Request $request, $id)
    {
        $tenant = Tenant::findOrFail($id);

        // Handle tenant logo upload
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $tenant->logo = $path;
        }

        // Update tenant fields
        if ($request->has('businessName')) {
            $tenant->name = $request->input('businessName');
        }
        $tenant->save();

        // Update tenant admin user (assumes 1 tenant_admin per tenant)
        $admin = $tenant->users()->where('tenant_id', $id)->first();

        if ($admin) {
            if ($request->has('adminName')) {
                $admin->name = $request->input('adminName');
            }
            if ($request->has('email')) {
                $admin->email = $request->input('email');
            }
            if ($request->has('phone')) {
                $admin->phone = $request->input('phone');
            }
            $admin->save();
        }

        return response()->json([
            'message' => 'Tenant and admin updated successfully',
            'tenant' => $tenant,
            'admin' => $admin,
        ]);
    }


    public function settings($tenantId)
    {

        $tenantSettings = TenantSetting::where('tenant_id', $tenantId)->first();


        if (!$tenantSettings) {
            $tenantSettings = TenantSetting::create([
                'tenant_id' => $tenantId,
                'page_title' => 'Book Your Appointment in 60 Seconds', // replace with default
            ]);
        }

        return response()->json([
            'tenantSettings' => $tenantSettings,
        ]);
    }


    public function updateSettings(Request $request, $tenantId)
    {

        $branding = TenantSetting::updateOrCreate(
            ['tenant_id' => $tenantId],
            [
                'primary_color' => $request->primary_color,
                'secondary_color' => $request->secondary_color,
                'page_title' => $request->page_title,
                'page_description' => $request->page_description,
                'booked_today' => $request->booked_today,
                'service_providers' => $request->service_providers,
                'average_booking_time' => $request->average_booking_time,
                'footer_text' => $request->footer_text,
                'footer_email' => $request->footer_email,
                'footer_phone' => $request->footer_phone,
                'footer_av_time' => $request->footer_av_time,
                'footer_location' => $request->footer_location,
                'header_image' => $request->header_image,
            ]
        );

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('images', 'public');
            $branding->logo = $path;
            $branding->save();
        }



        if ($request->hasFile('header_image')) {
            $path = $request->file('header_image')->store('images', 'public');
            $branding->header_image = $path;
            $branding->save();
        }

        return response()->json(['message' => 'Branding saved', 'branding' => $branding]);
    }


    public function showBySlug($slug)
    {
        $tenant = Tenant::where('slug', $slug)->firstOrFail();
        return response()->json($tenant);
    }


    public function services($tenantId)
    {
        $services = Tenant::findOrFail($tenantId)->services;
        return response()->json($services);
    }

    public function getTheme($tenantId)
    {
        $settings = TenantSetting::where('tenant_id', $tenantId)->first();

        return response()->json([
            'primary_color' => $settings->primary_color ?? '#2563eb',
            'secondary_color' => $settings->secondary_color ?? '#9333ea',
        ]);
    }
}