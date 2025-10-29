<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'productos';
    protected $guarded = [];
    public function categoria()
    {
        return $this->belongsTo(Category::class, 'categoria_id');
    }
}
