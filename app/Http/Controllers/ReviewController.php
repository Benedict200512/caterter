<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Booking;
use App\Models\CatererProfile;
use App\Notifications\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReviewController extends Controller
{
    /**
     * Customer submits a review for a completed booking.
     * 
     * BATCH D: After saving the review, we reload the caterer's average rating
     * so it's immediately reflected everywhere without needing a page refresh.
     */
    public function store(Request $request)
    {
        $request->validate([
            'booking_id'         => 'required|exists:bookings,id',
            'caterer_profile_id' => 'required|exists:caterer_profiles,id',
            'rating'             => 'required|integer|min:1|max:5',
            'comment'            => 'required|string|max:1000',
        ]);

        $booking = Booking::where('id', $request->booking_id)
            ->where('user_id', Auth::id())
            ->where('status', 'completed')
            ->firstOrFail();

        $exists = Review::where('booking_id', $request->booking_id)->exists();
        if ($exists) {
            return back()->with('error', 'You have already reviewed this booking.');
        }

        $review = Review::create([
            'user_id'            => Auth::id(),
            'booking_id'         => $request->booking_id,
            'caterer_profile_id' => $request->caterer_profile_id,
            'rating'             => $request->rating,
            'comment'            => $request->comment,
        ]);

        // BATCH D: Compute the new average rating immediately
        $caterer = CatererProfile::find($request->caterer_profile_id);
        $newAvg = $caterer ? round($caterer->reviews()->avg('rating'), 1) : 0;
        $totalReviews = $caterer ? $caterer->reviews()->count() : 0;

        // Notify the caterer about the new review with the updated average
        $catererUser = $booking->catererProfile->user;
        if ($catererUser) {
            $starText = $request->rating . ' star' . ($request->rating > 1 ? 's' : '');
            $catererUser->notify(new AppNotification([
                'title'   => 'New Review Received — ' . $starText,
                'message' => Auth::user()->name . ' left a ' . $starText . ' review for your service on ' . $booking->event_date->format('M d, Y') . '. Your average rating is now ' . $newAvg . '/5 (' . $totalReviews . ' review' . ($totalReviews !== 1 ? 's' : '') . ').',
                'url'     => route('bookings.show', $booking->id),
                'type'    => $request->rating >= 4 ? 'success' : 'info',
            ]));
        }

        return back()->with('success', 'Thank you for your feedback! Your review has been posted and the caterer\'s rating has been updated.');
    }

    /**
     * Caterer right-of-reply to a review.
     */
    public function reply(Request $request, $id)
    {
        $request->validate([
            'caterer_reply' => 'required|string|max:1000',
        ], [
            'caterer_reply.required' => 'Please write your reply before submitting.',
            'caterer_reply.max'      => 'Your reply must not exceed 1,000 characters.',
        ]);

        $review = Review::findOrFail($id);
        $user   = Auth::user();

        if (!$user->catererProfile || (int)$user->catererProfile->id !== (int)$review->caterer_profile_id) {
            abort(403, 'You are not authorized to reply to this review.');
        }

        if ($review->hasReply()) {
            return back()->with('error', 'You have already replied to this review. Replies cannot be modified to ensure transparency.');
        }

        $review->update([
            'caterer_reply'    => strip_tags($request->caterer_reply),
            'caterer_reply_at' => Carbon::now(),
        ]);

        $review->user->notify(new AppNotification([
            'title'   => 'Caterer Replied to Your Review',
            'message' => $review->catererProfile->business_name . ' responded to your review.',
            'url'     => route('caterer.details', $review->caterer_profile_id),
            'type'    => 'info',
        ]));

        return back()->with('success', 'Your reply has been published.');
    }
}