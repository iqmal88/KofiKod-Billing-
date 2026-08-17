<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanySettingController extends Controller
{
    public function index()
    {
        $company = CompanySetting::first();

        if (!$company) {
            $company = CompanySetting::create([
                'company_name' => 'KOFI AND KOD',
            ]);
        }

        return view('company-settings.index', compact('company'));
    }

    public function update(Request $request)
    {
        $company = CompanySetting::first();

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_tagline' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
            'address' => 'nullable|string',

            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
            'bank_holder' => 'nullable|string|max:255',

            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'signature' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'terms_conditions' => 'nullable|string',
        ]);

        if ($request->hasFile('logo')) {

            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }

            $validated['logo'] = $request
                ->file('logo')
                ->store('company/logo', 'public');
        }

        if ($request->hasFile('signature')) {

            if ($company->signature) {
                Storage::disk('public')->delete($company->signature);
            }

            $validated['signature'] = $request
                ->file('signature')
                ->store('company/signature', 'public');
        }

        $company->update($validated);

        return back()->with(
            'success',
            'Company settings updated successfully.'
        );
    }
}