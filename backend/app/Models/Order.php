<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'pedidos';
    protected $primaryKey = 'pedido_id';

    protected $fillable = [
        'usuario_id',
        'fecha_pedido',
        'total_pedido',
    ];

    public $timestamps = true;

    public function productos()
    {
        return $this->belongsToMany(Product::class, 'pedidos_productos', 'pedido_id', 'producto_id')
            ->withPivot('cantidad', 'precio_unitario');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'usuario_id');
    }
}
