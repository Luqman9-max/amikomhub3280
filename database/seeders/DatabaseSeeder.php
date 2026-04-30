<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Utama
        \App\Models\User::create([
            'name' => 'Admin Amikom',
            'email' => 'admin@amikom.ac.id',
            'password' => bcrypt('password'),
        ]);

        // 2. Insert 3 Kategori Event (sesuai perintah)
        $category1 = \App\Models\Category::create([
            'name' => 'Teknologi & Pengembangan Diri',
            'slug' => 'teknologi-pengembangan-diri',
        ]);

        $category2 = \App\Models\Category::create([
            'name' => 'Olahraga & E-Sport',
            'slug' => 'olahraga-e-sport',
        ]);

        $category3 = \App\Models\Category::create([
            'name' => 'Seni & Budaya',
            'slug' => 'seni-budaya',
        ]);

        // 3. Insert 6 Events (2 event per kategori) sesuai perintah
        // Kategori Teknologi (2 event)
        \App\Models\Event::create([
            'category_id' => $category1->id,
            'title' => 'UI/UX Masterclass 2024',
            'description' => 'Pelajari prinsip-prinsip desain UI/UX dari praktisi industri. Workshop hands-on dengan Figma.',
            'date' => '2026-12-10 09:00:00',
            'location' => 'Gedung Serbaguna Universitas Amikom',
            'price' => 150000,
            'stock' => 150,
            'poster_path' => 'posters/uiux-masterclass.jpg',
        ]);

        \App\Models\Event::create([
            'category_id' => $category1->id,
            'title' => 'Fullstack Web Development Bootcamp',
            'description' => 'Bootcamp intensif mempelajari Laravel, React.js, dan database MySQL. Sertifikat dan portofolio project.',
            'date' => '2026-11-25 08:00:00',
            'location' => 'Lab Komputer Universitas Amikom',
            'price' => 350000,
            'stock' => 80,
            'poster_path' => 'posters/bootcamp.jpg',
        ]);

        // Kategori Olahraga & E-Sport (2 event)
        \App\Models\Event::create([
            'category_id' => $category2->id,
            'title' => 'E-Sport U-Champ 2024',
            'description' => 'Turnamen E-Sport Mobile Legends antar universitas se-Indonesia. Total hadiah Rp 50.000.000.',
            'date' => '2026-12-15 10:00:00',
            'location' => 'Auditorium Universitas Amikom & Online',
            'price' => 50000,
            'stock' => 500,
            'poster_path' => 'posters/esport-uchamp.jpg',
        ]);

        \App\Models\Event::create([
            'category_id' => $category2->id,
            'title' => 'Basketball Championship: Amikom Cup',
            'description' => 'Kompetisi basket 3x3 antar mahasiswa. Juara mendapatkan trophy dan uang pembinaan.',
            'date' => '2026-11-05 08:00:00',
            'location' => 'GOR Universitas Amikom',
            'price' => 75000,
            'stock' => 300,
            'poster_path' => 'posters/basketball-cup.jpg',
        ]);

        // Kategori Seni & Budaya (2 event)
        \App\Models\Event::create([
            'category_id' => $category3->id,
            'title' => 'Amikom Creative Fest 2024',
            'description' => 'Festival seni dan kreativitas mahasiswa. Pameran seni rupa, pertunjukan musik, dan bazaar produk kreatif.',
            'date' => '2026-12-20 09:00:00',
            'location' => 'Area Kreatif Universitas Amikom',
            'price' => 25000,
            'stock' => 1000,
            'poster_path' => 'posters/creative-fest.jpg',
        ]);

        \App\Models\Event::create([
            'category_id' => $category3->id,
            'title' => 'Music Performance: Jazz Night 2025',
            'description' => 'Nikmati malam yang indah dengan alunan musik jazz dari musisi ternama.',
            'date' => '2026-05-10 19:00:00',
            'location' => 'Amikom Baru',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/jazz-night.jpg',
        ]);
    }
}