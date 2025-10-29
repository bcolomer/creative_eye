<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'pedidos';
    protected $guarded = [];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Product::class, 'pedidos_productos', 'pedido_id', 'producto_id')
            ->withPivot('cantidad', 'precio_unitario');
    }
}
