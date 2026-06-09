<?php

namespace App\Http\Controllers;

class EventController extends Controller
{
    public function show(\App\Models\Event $event)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = \App\Models\Category::all();

        // Me-render view dengan membawa data kategori dan data spesifik acara tersebut
        return view('event-detail', compact('categories', 'event'));
    }

    public function checkout()
    {
        return view('checkout');
    }

    public function ticket()
    {
        return view('ticket');
    }

    public function indexAdmin()
    {
        return view('admin.events');
    }
}
