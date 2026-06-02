<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\CatererProfile;
use App\Models\User;
use App\Models\Menu;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return $this->adminIndex($user);
        }

        if ($user->role === 'caterer') {

            $catererProfile = CatererProfile::where('user_id', $user->id)
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->first();

            $bookings = $catererProfile
                ? Booking::where('caterer_profile_id', $catererProfile->id)
                    ->with(['user', 'review'])
                    ->latest()
                    ->get()
                : collect();

            $menus = $catererProfile
                ? Menu::where('caterer_profile_id', $catererProfile->id)
                    ->orderBy('category')
                    ->orderBy('name')
                    ->get()
                : collect();

            $packages = $catererProfile
                ? Package::where('caterer_profile_id', $catererProfile->id)
                    ->orderBy('price_per_guest')
                    ->get()
                : collect();

            return view('caterer.dashboard-caterer', compact(
                'user', 'bookings', 'catererProfile', 'menus', 'packages'
            ));
        }

        $bookings = Booking::where('user_id', $user->id)
            ->with(['catererProfile', 'review'])
            ->latest()
            ->get();

        $topPerformer = CatererProfile::where('status', 'verified')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->having('reviews_count', '>', 0)
            ->orderByDesc('reviews_avg_rating')
            ->first();

        $recommendedCaterers = CatererProfile::where('status', 'verified')
            ->when($topPerformer, fn($q) => $q->where('id', '!=', $topPerformer->id))
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->orderByDesc('reviews_avg_rating')
            ->take(3)
            ->get();

        return view('dashboard', compact(
            'user', 'bookings', 'topPerformer', 'recommendedCaterers'
        ));
    }

    private function adminIndex($user)
    {
        $users = User::with('catererProfile')->latest()->get();

        $bookings = Booking::with(['user', 'catererProfile'])->latest()->get();

        $pendingCaterers = CatererProfile::where('status', 'pending')
            ->with('user')
            ->latest()
            ->get();

        $totalRevenue = Booking::whereIn('status', ['paid', 'completed'])
            ->whereNotNull('estimated_total')
            ->sum('estimated_total');

        // Total users: count both 'customer' and 'user' roles as Bookers
        $customerCount = User::whereIn('role', ['customer', 'user'])->count();
        $catererCount  = User::where('role', 'caterer')->count();

        // Active bookers: only users who have made a booking THIS month
        $activeBookers = User::whereIn('role', ['customer', 'user'])
            ->whereHas('bookings', function ($query) {
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at',  Carbon::now()->year);
            })->count();

        $topCaterers = CatererProfile::with('user')
            ->withCount(['bookings as confirmed_count' => function ($query) {
                $query->whereIn('status', ['paid', 'completed']);
            }])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->orderByDesc('confirmed_count')
            ->orderByDesc('reviews_avg_rating')
            ->take(5)
            ->get();

        // ── Monthly chart data — last 6 months ───────────────────────────
        $months = collect(range(5, 0))->map(fn($i) => Carbon::now()->subMonths($i));

        $monthlyBookings = $months->map(fn($m) =>
            Booking::whereYear('created_at',  $m->year)
                ->whereMonth('created_at', $m->month)
                ->count()
        );

        $monthlyRevenue = $months->map(fn($m) =>
            Booking::whereYear('created_at',  $m->year)
                ->whereMonth('created_at', $m->month)
                ->whereIn('status', ['paid', 'completed'])
                ->whereNotNull('estimated_total')
                ->sum('estimated_total')
        );

        $monthLabels = $months->map(fn($m) => $m->format('M'));
        // ─────────────────────────────────────────────────────────────────

        $recentActivities = Booking::with(['user', 'catererProfile'])
            ->latest()->take(10)->get()
            ->map(fn($b) => [
                'type'       => 'booking',
                'name'       => $b->user->name ?? 'Unknown',
                'sub'        => $b->catererProfile->business_name ?? 'Unknown Caterer',
                'action'     => $b->status,
                'avatar'     => $b->user->profile_picture ?? null,
                'time'       => $b->created_at,
                'time_human' => $b->created_at->diffForHumans(),
            ])
            ->concat(
                CatererProfile::with('user')->latest()->take(10)->get()
                    ->map(fn($c) => [
                        'type'       => 'registration',
                        'name'       => $c->user->name ?? 'Unknown',
                        'sub'        => $c->business_name,
                        'action'     => $c->status,
                        'avatar'     => $c->profile_picture ?? null,
                        'time'       => $c->created_at,
                        'time_human' => $c->created_at->diffForHumans(),
                    ])
            )
            ->sortByDesc('time')
            ->take(10)
            ->values();

        return view('admin.dashboard', compact(
            'user', 'pendingCaterers', 'users', 'totalRevenue',
            'customerCount', 'catererCount', 'activeBookers',
            'topCaterers', 'bookings', 'recentActivities',
            'monthlyBookings', 'monthlyRevenue', 'monthLabels'
        ));
    }

    public function updateUser(Request $request, User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        if ($user->role === 'caterer' && $user->catererProfile) {
            $newStatus = $request->has('suspend') ? 'suspended' : 'verified';
            $user->catererProfile->update(['status' => $newStatus]);
            return back()->with('success', 'Caterer account status updated to ' . ucfirst($newStatus) . '.');
        }

        return back()->with('error', 'Only caterer accounts can be moderated.');
    }
}