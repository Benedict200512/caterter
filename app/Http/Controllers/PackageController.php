<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\CatererProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    private function getCatererProfile()
    {
        $profile = CatererProfile::where('user_id', Auth::id())->first();

        if (!$profile) {
            abort(redirect()->route('caterer.apply')
                ->with('error', 'You need to register as a caterer first before managing packages.'));
        }

        return $profile;
    }

    public function index()
    {
        return redirect()->route('dashboard');
    }

    public function create()
    {
        $catererProfile = $this->getCatererProfile();
        return view('caterer.packages.form', compact('catererProfile'));
    }

    public function store(Request $request)
    {
        $catererProfile = $this->getCatererProfile();

        $data = $request->validate([
            'name'            => 'required|string|max:150',
            'description'     => 'nullable|string|max:800',
            'price_per_guest' => 'required|numeric|min:1',
            'min_guests'      => 'required|integer|min:1',
            'max_guests'      => 'nullable|integer|min:1|gte:min_guests',
            'inclusions'      => 'nullable|string|max:2000',
            'is_available'    => 'nullable',
        ]);

        $data['caterer_profile_id'] = $catererProfile->id;
        $data['is_available'] = $request->has('is_available') ? true : false;

        Package::create($data);

        return redirect()->route('dashboard')
                         ->with('success', 'Package "' . $data['name'] . '" created successfully!');
    }

    public function edit(Package $package)
    {
        $catererProfile = $this->getCatererProfile();
        abort_if((int)$package->caterer_profile_id !== (int)$catererProfile->id, 403);

        return view('caterer.packages.form', compact('catererProfile', 'package'));
    }

    public function update(Request $request, Package $package)
    {
        $catererProfile = $this->getCatererProfile();
        abort_if((int)$package->caterer_profile_id !== (int)$catererProfile->id, 403);

        $data = $request->validate([
            'name'            => 'required|string|max:150',
            'description'     => 'nullable|string|max:800',
            'price_per_guest' => 'required|numeric|min:1',
            'min_guests'      => 'required|integer|min:1',
            'max_guests'      => 'nullable|integer|min:1|gte:min_guests',
            'inclusions'      => 'nullable|string|max:2000',
            'is_available'    => 'nullable',
        ]);

        $data['is_available'] = $request->has('is_available') ? true : false;
        $package->update($data);

        return redirect()->route('dashboard')
                         ->with('success', 'Package "' . $package->name . '" updated successfully!');
    }

    public function destroy(Package $package)
    {
        $catererProfile = $this->getCatererProfile();
        abort_if((int)$package->caterer_profile_id !== (int)$catererProfile->id, 403);

        $name = $package->name;
        $package->delete();

        return redirect()->route('dashboard')
                         ->with('success', '"' . $name . '" has been deleted.');
    }
}