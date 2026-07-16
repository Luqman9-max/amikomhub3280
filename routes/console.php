<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Jadwalkan pengingat Abandoned Cart setiap 15 menit
use Illuminate\Support\Facades\Schedule;
Schedule::command('cart:recover')->everyFifteenMinutes();
