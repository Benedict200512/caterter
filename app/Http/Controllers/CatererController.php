<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatererProfile;
use App\Models\User;
use App\Notifications\AppNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CatererController extends Controller
{
    public function pendingList(): View
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $pendingCaterers = CatererProfile::where('status', 'pending')
            ->with('user')
            ->latest()
            ->get();

        return view('admin.verifications', compact('pendingCaterers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'business_name'   => 'required|string|max:255',
            'contact_number'  => ['required', 'string', 'regex:/^(\+63|0)[0-9]{10}$/'],
            'location'        => 'required|string|max:500',
            'specialty'       => 'required|string|min:20',
            'min_budget'      => 'required|numeric|min:1',
            'max_budget'      => 'required|numeric|min:1|gte:min_budget',
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:3072',
            'business_permit' => 'required|mimes:pdf,jpg,jpeg,png|max:5120',
            'sanitary_permit' => 'required|mimes:pdf,jpg,jpeg,png|max:5120',
            'government_id'   => 'required|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'business_name.required'   => 'Business name is required.',
            'contact_number.required'  => 'A catering contact number is required.',
            'contact_number.regex'     => 'Please enter a valid Philippine mobile number (e.g. 09XX XXX XXXX).',
            'location.required'        => 'Service area coverage is required.',
            'specialty.required'       => 'A sample menu or service description is required.',
            'specialty.min'            => 'Please provide a more detailed service description (at least 20 characters).',
            'min_budget.required'      => 'Starting price per guest is required.',
            'min_budget.min'           => 'Starting price per guest must be at least ₱1.',
            'max_budget.required'      => 'Maximum price per guest is required.',
            'max_budget.min'           => 'Maximum price per guest must be at least ₱1.',
            'max_budget.gte'           => 'Maximum price must be greater than or equal to the starting price.',
            'profile_picture.required' => 'A profile photo or business logo is required.',
            'profile_picture.max'      => 'Profile photo must not exceed 3MB.',
            'business_permit.required' => 'Business Permit or DTI Registration document is required.',
            'business_permit.max'      => 'Business Permit file must not exceed 5MB.',
            'sanitary_permit.required' => 'Sanitary Permit document is required.',
            'sanitary_permit.max'      => 'Sanitary Permit file must not exceed 5MB.',
            'government_id.required'   => 'A valid Government-Issued ID is required.',
            'government_id.max'        => 'Government ID file must not exceed 5MB.',
        ]);

        $profilePath        = $request->file('profile_picture')->store('profiles', 'public');
        $businessPermitPath = $request->file('business_permit')->store('permits', 'public');
        $sanitaryPath       = $request->file('sanitary_permit')->store('permits', 'public');
        $governmentIdPath   = $request->file('government_id')->store('permits', 'public');

        CatererProfile::create([
            'user_id'         => Auth::id(),
            'business_name'   => $request->business_name,
            'contact_number'  => $request->contact_number,
            'location'        => $request->location,
            'specialty'       => $request->specialty,
            'min_budget'      => $request->min_budget,
            'max_budget'      => $request->max_budget,
            'profile_picture' => $profilePath,
            'business_permit' => $businessPermitPath,
            'sanitary_permit' => $sanitaryPath,
            'government_id'   => $governmentIdPath,
            'status'          => 'pending',
        ]);

        // FIX #1: Role stays 'user' until admin approves.
        // DO NOT change role here. The user remains a regular user
        // and sees a "pending verification" state on their dashboard.

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new AppNotification([
                'title'   => 'New Caterer Application',
                'message' => $request->business_name . ' has submitted documents for verification.',
                'url'     => url('/admin/verifications'),
                'type'    => 'warning',
            ]));
        }

        return redirect('/dashboard')->with('success', 'Application submitted! Our team will review your documents within 3–5 business days.');
    }

    public function edit(): View
    {
        $user    = Auth::user();
        $caterer = $user->catererProfile;

        if (!$caterer) {
            abort(404, 'Caterer profile not found.');
        }

        return view('caterer.edit-profile', compact('caterer', 'user'));
    }

    public function update(Request $request): RedirectResponse
    {
        $caterer = Auth::user()->catererProfile;

        if (!$caterer) {
            abort(403, 'Unauthorized profile access.');
        }

        $request->validate([
            'business_name'  => 'required|string|max:255',
            'contact_number' => ['required', 'string', 'regex:/^(\+63|0)[0-9]{10}$/'],
            'location'       => 'required|string|max:500',
            'specialty'      => 'required|string|min:20',
            'min_budget'     => 'required|numeric|min:1',
            'max_budget'     => 'required|numeric|min:1|gte:min_budget',
            'profile_picture'=> 'nullable|image|mimes:jpeg,png,jpg|max:3072',
        ], [
            'contact_number.regex' => 'Please enter a valid Philippine mobile number.',
            'specialty.min'        => 'Please provide a more detailed service description (at least 20 characters).',
            'min_budget.required'  => 'Starting price per guest is required.',
            'min_budget.min'       => 'Starting price per guest must be at least ₱1.',
            'max_budget.required'  => 'Maximum price per guest is required.',
            'max_budget.gte'       => 'Maximum price must be greater than or equal to the starting price.',
            'profile_picture.max'  => 'Profile photo must not exceed 3MB.',
        ]);

        $data = $request->only([
            'business_name',
            'contact_number',
            'location',
            'specialty',
            'min_budget',
            'max_budget',
        ]);

        if ($request->hasFile('profile_picture')) {
            if ($caterer->profile_picture) {
                Storage::disk('public')->delete($caterer->profile_picture);
            }
            $data['profile_picture'] = $request->file('profile_picture')->store('profiles', 'public');
        }

        $caterer->update($data);

        return redirect('/dashboard')->with('success', 'Business information updated successfully.');
    }

    public function approve($id): RedirectResponse
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Only administrators can approve caterers.');
        }

        $caterer = CatererProfile::findOrFail($id);
        $caterer->update(['status' => 'verified']);

        // FIX #1: Set role to 'caterer' ONLY after admin approval
        $caterer->user->update(['role' => 'caterer']);

        $caterer->user->notify(new AppNotification([
            'title'   => 'Caterer Profile Approved',
            'message' => 'Congratulations! Your caterer profile for ' . $caterer->business_name . ' has been verified and is now live on CaterConnect.',
            'url'     => url('/dashboard'),
            'type'    => 'success',
        ]));

        return back()->with('success', $caterer->business_name . ' has been verified and is now live.');
    }

    /**
     * FIX #6 (High Priority): Admin can reject a caterer application with a reason.
     */
    public function reject(Request $request, $id): RedirectResponse
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Only administrators can reject caterers.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $caterer = CatererProfile::findOrFail($id);
        $caterer->update(['status' => 'rejected']);

        $caterer->user->notify(new AppNotification([
            'title'   => 'Caterer Application Rejected',
            'message' => 'Your application for ' . $caterer->business_name . ' was not approved. Reason: ' . $request->rejection_reason,
            'url'     => url('/become-caterer'),
            'type'    => 'danger',
        ]));

        return back()->with('success', $caterer->business_name . ' has been rejected.');
    }
    
}