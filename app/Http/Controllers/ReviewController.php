<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, Event $event)
    {
        // 1. Authorization
        if (! $event->canBeReviewedBy(Auth::user())) {
            return back()->with('error', 'Anda tidak memenuhi syarat untuk memberikan ulasan pada event ini (Event belum selesai atau Anda tidak memiliki tiket).');
        }

        // 2. Validation
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'review_text' => 'required|string|min:10|max:1000',
        ]);

        // 3. Create Review
        Review::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'rating' => $request->rating,
            'title' => $request->title,
            'review_text' => $request->review_text,
            'is_hidden' => false,
        ]);

        return back()->with('success', 'Ulasan Anda berhasil dikirim! Terima kasih atas tanggapannya.');
    }

    /**
     * Update the specified review in storage.
     */
    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'review_text' => 'required|string|min:10|max:1000',
        ]);

        $review->update([
            'rating' => $request->rating,
            'title' => $request->title,
            'review_text' => $request->review_text,
        ]);

        return back()->with('success', 'Ulasan Anda berhasil diperbarui.');
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $review->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
