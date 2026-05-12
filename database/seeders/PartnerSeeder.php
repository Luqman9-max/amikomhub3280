<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Menggunakan Faker untuk men-generate minimal 5 data partner fiktif.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Locale Indonesia

        $partners = [];

        for ($i = 0; $i < 10; $i++) {
            // Generate ukuran logo acak agar setiap logo terlihat berbeda
            $width  = $faker->numberBetween(150, 300);
            $height = $faker->numberBetween(150, 300);

            $partners[] = [
                'name'       => $faker->company(),
                'logo_url'   => "https://placehold.co/{$width}x{$height}",
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('partners')->insert($partners);
    }
}
