<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    // Menandakan atribut: 1 Kategori dapat memiliki banyak wujud Event
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
