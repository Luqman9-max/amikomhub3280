<?php

namespace App\Observers;

use App\Models\Review;
use App\Models\Event;

class ReviewObserver
{
    /**
     * Handle the Review "created" event.
     */
    public function created(Review $review): void
    {
        $this->updateEventStats($review->event_id);
    }

    /**
     * Handle the Review "updated" event.
     */
    public function updated(Review $review): void
    {
        $this->updateEventStats($review->event_id);
    }

    /**
     * Handle the Review "deleted" event.
     */
    public function deleted(Review $review): void
    {
        $this->updateEventStats($review->event_id);
    }

    /**
     * Update the average rating and review count for the event.
     */
    private function updateEventStats($eventId)
    {
        $event = Event::find($eventId);
        if ($event) {
            $stats = Review::where('event_id', $eventId)
                           ->where('is_hidden', false)
                           ->selectRaw('AVG(rating) as avg_rating, COUNT(id) as total_reviews')
                           ->first();
                           
            $event->rating_avg = $stats->avg_rating ?? 0;
            $event->reviews_count = $stats->total_reviews ?? 0;
            $event->save();
        }
    }
}
