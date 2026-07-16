<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\ReviewObserver;

#[ObservedBy(ReviewObserver::class)]
class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'rating',
        'title',
        'review_text',
        'is_hidden',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_hidden' => 'boolean',
    ];

    /**
     * Get the user that wrote the review.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event being reviewed.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
