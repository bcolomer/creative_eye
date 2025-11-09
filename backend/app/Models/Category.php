<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    protected $primaryKey = 'categoria_id';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];


    public function productos()
    {
        return $this->hasMany(Product::class, 'categoria_id', 'categoria_id');
    }
}
