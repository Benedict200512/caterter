<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CatererController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PackageController;
use App\Models\CatererProfile;
use App\Http\Controllers\ViewCatererController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function (Request $request) {
    $specialty   = trim($request->specialty   ?? '');
    $location    = trim($request->location    ?? '');
    $totalBudget = $request->total_budget ?? '';
    $guestCount  = $request->guest_count  ?? '';

    $budgetPerGuest = ($guestCount > 0 && $totalBudget > 0)
        ? round((float)$totalBudget / (int)$guestCount, 2)
        : null;

    $hasBudget    = $budgetPerGuest !== null;
    $hasSpecialty = $specialty !== '';
    $hasLocation  = $location  !== '';
    $hasAnyFilter = $hasBudget || $hasSpecialty || $hasLocation;

    $all = CatererProfile::where('status', 'verified')->with('reviews')->get();

    $caterers = $all->map(function ($caterer) use (
        $hasBudget, $hasSpecialty, $hasLocation,
        $budgetPerGuest, $specialty, $location
    ) {
        $budgetFits = $hasBudget && $caterer->min_budget <= $budgetPerGuest && $caterer->max_budget >= $budgetPerGuest;
        $specialtyFits = $hasSpecialty && stripos($caterer->specialty, $specialty) !== false;
        $locationFits = $hasLocation && stripos($caterer->location, $location) !== false;

        if ($budgetFits) $caterer->match_type = 'budget';
        elseif ($specialtyFits || $locationFits) $caterer->match_type = 'specialty_location';
        else $caterer->match_type = null;

        return $caterer;
    });

    if ($hasAnyFilter) {
        $caterers = $caterers->filter(fn($c) => $c->match_type !== null);
    }

    $caterers = $caterers->sortBy(fn($c) => match($c->match_type) {
        'budget' => 0, 'specialty_location' => 1, default => 2,
    })->values();

    return view('index', compact('caterers', 'guestCount', 'totalBudget', 'specialty', 'location', 'budgetPerGuest', 'hasAnyFilter'));
})->name('marketplace');

Route::get('/caterers', [ViewCatererController::class, 'index'])->name('caterers.index');
Route::get('/caterer/{id}', [ViewCatererController::class, 'show'])->name('caterer.details');
Route::get('/privacy-policy', fn() => view('privacy'))->name('privacy');
Route::get('/terms', fn() => view('terms'))->name('terms');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/check-availability', [BookingController::class, 'apiCheckAvailability']);

    // Booking CRUD
    Route::post('/bookings',       [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{id}',   [BookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{id}', [BookingController::class, 'update'])->name('bookings.update');

    // Customer actions
    Route::patch('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // Payment flow (customer uploads receipt)
    Route::post('/bookings/{id}/payment', [BookingController::class, 'uploadPayment'])->name('bookings.uploadPayment');

    // Chat & Reviews
    Route::post('/bookings/{id}/chat', [ChatController::class, 'store'])->name('chat.store');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Notifications
    Route::get('/notifications/read-all', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markAllRead');

    Route::get('/notifications/{id}/read', function ($id) {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
            return redirect($notification->data['url'] ?? '/dashboard');
        }
        return redirect('/dashboard');
    })->name('notifications.read');

    // Caterer application
    Route::get('/become-caterer',  function () { return view('become-caterer'); })->name('caterer.apply');
    Route::post('/become-caterer', [CatererController::class, 'store']);

    // Admin routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/verifications',         [CatererController::class, 'pendingList'])->name('admin.verifications');
        Route::post('/admin/approve-caterer/{id}', [CatererController::class, 'approve'])->name('admin.approve');
        Route::post('/admin/caterers/{id}/reject', [CatererController::class, 'reject'])->name('admin.reject');
        Route::patch('/admin/users/{user}',        [DashboardController::class, 'updateUser'])->name('admin.users.update');
    });

    // Caterer routes
    Route::middleware(['role:caterer'])->group(function () {
        Route::get('/caterer/profile/edit',   [CatererController::class, 'edit'])->name('caterer.edit');
        Route::put('/caterer/profile/update', [CatererController::class, 'update'])->name('caterer.update');
        Route::get('/api/caterer/calendar-events', [BookingController::class, 'getCalendarEvents'])->name('api.caterer.calendar');

        // Payment verification (caterer)
        Route::post('/bookings/{id}/payment/verify', [BookingController::class, 'verifyPayment'])->name('bookings.verifyPayment');
        Route::post('/bookings/{id}/payment/reject', [BookingController::class, 'rejectPayment'])->name('bookings.rejectPayment');
        Route::patch('/bookings/{id}/downpayment',   [BookingController::class, 'markDownpaymentPaid'])->name('bookings.downpayment');

        // Reviews reply
        Route::post('/reviews/{id}/reply', [ReviewController::class, 'reply'])->name('reviews.reply');

        // Menus
        Route::get('/caterer/menu',             [MenuController::class, 'index'])->name('caterer.menus.index');
        Route::get('/caterer/menu/create',      [MenuController::class, 'create'])->name('caterer.menus.create');
        Route::post('/caterer/menu',            [MenuController::class, 'store'])->name('caterer.menus.store');
        Route::get('/caterer/menu/{menu}/edit', [MenuController::class, 'edit'])->name('caterer.menus.edit');
        Route::put('/caterer/menu/{menu}',      [MenuController::class, 'update'])->name('caterer.menus.update');
        Route::delete('/caterer/menu/{menu}',   [MenuController::class, 'destroy'])->name('caterer.menus.destroy');

        // Packages
        Route::get('/caterer/packages',                [PackageController::class, 'index'])->name('caterer.packages.index');
        Route::get('/caterer/packages/create',         [PackageController::class, 'create'])->name('caterer.packages.create');
        Route::post('/caterer/packages',               [PackageController::class, 'store'])->name('caterer.packages.store');
        Route::get('/caterer/packages/{package}/edit', [PackageController::class, 'edit'])->name('caterer.packages.edit');
        Route::put('/caterer/packages/{package}',      [PackageController::class, 'update'])->name('caterer.packages.update');
        Route::delete('/caterer/packages/{package}',   [PackageController::class, 'destroy'])->name('caterer.packages.destroy');

    });
});