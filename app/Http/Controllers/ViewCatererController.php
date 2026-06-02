<?php

namespace App\Http\Controllers;

use App\Models\CatererProfile;
use Illuminate\Http\Request;

class ViewCatererController extends Controller
{
    /**
     * BATCH D: All caterer queries now consistently use withAvg + withCount
     * so ratings are always fresh and computed at the database level.
     */
    public function index(Request $request)
    {
        $query = CatererProfile::where('status', 'verified')
            ->with(['user', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'LIKE', "%{$search}%")
                  ->orWhere('specialty', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('specialty')) {
            $query->where('specialty', 'LIKE', '%' . $request->input('specialty') . '%');
        }

        if ($request->filled('location')) {
            $query->where('location', 'LIKE', '%' . $request->input('location') . '%');
        }

        if ($request->filled('total_budget') && $request->filled('guest_count')) {
            $totalBudget = (float) $request->input('total_budget');
            $guestCount  = (int)   $request->input('guest_count');
            if ($totalBudget > 0 && $guestCount > 0) {
                $budgetPerGuest = $totalBudget / $guestCount;
                $query->where('min_budget', '<=', $budgetPerGuest)
                      ->where('max_budget', '>=', $budgetPerGuest);
            }
        }

        // BATCH D: Filter by minimum rating
        if ($request->filled('rating')) {
            $minRating = (float) $request->input('rating');
            $query->having('reviews_avg_rating', '>=', $minRating);
        }

        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'rating':    $query->orderByDesc('reviews_avg_rating'); break;
            case 'price-low': $query->orderBy('min_budget', 'asc');      break;
            case 'price-high':$query->orderBy('max_budget', 'desc');     break;
            default:          $query->latest();                           break;
        }

        $caterers = $query->paginate(12)->appends($request->query());

        return view('pages.caterers', compact('caterers'));
    }

    public function show($id)
    {
        $caterer = CatererProfile::where('id', $id)
            ->with([
                'user',
                'reviews.user',
                'menus'    => fn($q) => $q->where('is_available', true)->orderBy('category')->orderBy('name'),
                'packages' => fn($q) => $q->where('is_available', true)->orderBy('price_per_guest'),
            ])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->firstOrFail();

        // Group menus by category for the selector UI
        $menusByCategory = $caterer->menus->groupBy(function ($menu) {
            return $menu->category ?? 'Other';
        });

        return view('caterer-details', compact('caterer', 'menusByCategory'));
    }
}