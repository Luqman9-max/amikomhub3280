<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->unsignedTinyInteger('rating'); // 1-5
            $table->string('title')->nullable();
            $table->text('review_text');
            $table->boolean('is_hidden')->default(false);
            $table->timestamps();

            // Prevent duplicate reviews from the same user for the same event
            $table->unique(['user_id', 'event_id']);
            
            // Index for faster queries when filtering by rating or event
            $table->index('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
