<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\CatererProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    private function getCatererProfile()
    {
        $profile = CatererProfile::where('user_id', Auth::id())->first();

        if (!$profile) {
            abort(redirect()->route('caterer.apply')
                ->with('error', 'You need to register as a caterer first before managing menus.'));
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
        return view('caterer.menus.form', compact('catererProfile'));
    }

    public function store(Request $request)
    {
        $catererProfile = $this->getCatererProfile();

        $data = $request->validate([
            'name'         => 'required|string|max:150',
            'category'     => 'nullable|string|max:100',
            'description'  => 'nullable|string|max:500',
            'price'        => 'required|numeric|min:0',
            'is_available' => 'nullable',
        ]);

        $data['caterer_profile_id'] = $catererProfile->id;
        $data['is_available'] = $request->has('is_available') ? true : false;

        Menu::create($data);

        return redirect()->route('dashboard')
                         ->with('success', 'Menu item "' . $data['name'] . '" added successfully!');
    }

    public function edit(Menu $menu)
    {
        $catererProfile = $this->getCatererProfile();
        abort_if((int)$menu->caterer_profile_id !== (int)$catererProfile->id, 403);

        return view('caterer.menus.form', compact('catererProfile', 'menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $catererProfile = $this->getCatererProfile();
        abort_if((int)$menu->caterer_profile_id !== (int)$catererProfile->id, 403);

        $data = $request->validate([
            'name'         => 'required|string|max:150',
            'category'     => 'nullable|string|max:100',
            'description'  => 'nullable|string|max:500',
            'price'        => 'required|numeric|min:0',
            'is_available' => 'nullable',
        ]);

        $data['is_available'] = $request->has('is_available') ? true : false;
        $menu->update($data);

        return redirect()->route('dashboard')
                         ->with('success', 'Menu item "' . $menu->name . '" updated successfully!');
    }

    public function destroy(Menu $menu)
    {
        $catererProfile = $this->getCatererProfile();
        abort_if((int)$menu->caterer_profile_id !== (int)$catererProfile->id, 403);

        $name = $menu->name;
        $menu->delete();

        return redirect()->route('dashboard')
                         ->with('success', '"' . $name . '" has been removed.');
    }
}