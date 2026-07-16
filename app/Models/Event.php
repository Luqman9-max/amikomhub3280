<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Event extends Model
{
    protected $fillable = [
        'category_id', 'title', 'description', 'date',
        'location', 'price', 'stock', 'poster_path'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    // Menandakan atribut: 1 Event harus terpaut pada satu wujud Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the reviews for the event.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Check if a specific user can review this event.
     */
    public function canBeReviewedBy(User $user): bool
    {
        // Check if event has finished (1 day after)
        // using date attribute
        if (! $this->date || now()->lessThanOrEqualTo($this->date->addDay())) {
            return false;
        }

        // Check if user has already reviewed
        if ($this->reviews()->where('user_id', $user->id)->exists()) {
            return false;
        }

        // Check if user has a successful transaction
        // Since transaction doesn't have user_id, we check by email
        return \App\Models\Transaction::where('event_id', $this->id)
            ->where('customer_email', $user->email)
            ->where('status', 'success') // or matching exactly how it's saved in DB
            ->exists();
    }
}
