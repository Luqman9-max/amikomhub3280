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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();                                                            // Primary Key, Auto-increment
            $table->string('name');                                                  // Nama pihak partner
            $table->string('logo_url')->default('https://placehold.co/200x200');    // URL logo partner
            $table->timestamps();                                                    // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
