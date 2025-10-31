<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $primaryKey = 'producto_id';

    protected $fillable = [
        'nombre',
        'categoria_id',
        'precio',
        'cantidad',
        'foto',
        'codigo',
        'descripcion',
    ];


    public $timestamps = true;

    public function categoria()
    {
        return $this->belongsTo(Category::class, 'categoria_id', 'categoria_id');
    }
}
