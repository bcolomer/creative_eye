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

    /**
     * Obtiene la ruta de la foto (getFotoAttribute).
     *
     * @param  string|null  $value
     * @return string
     */
    public function getFotoAttribute($value)
    {
        //  Si el valor está vacío o es nulo, devuelve el logo.
        if (empty($value)) {
            return '/images/creativelogo.png';
        }

        // Si el valor es una URL completa (empieza con http:// o https://)
        //    ¡es un enlace de Drive! Lo devolvemos intacto.
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        //  Si es un enlace local (empieza con /storage/),
        //    comprobamos si el archivo físico existe.
        if (str_starts_with($value, '/storage/')) {
            $storagePath = str_replace('/storage/', '', $value);
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($storagePath)) {
                return $value;
            }
        }

        // Si era un enlace local pero el archivo no existe (foto rota),
        //    o cualquier otra cosa rara, devolvemos el logo.
        return '/images/creativelogo.png';
    }
}
