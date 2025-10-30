<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'pedidos_productos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
    ];

    public $timestamps = true;

    public function pedido()
    {
        return $this->belongsTo(Order::class, 'pedido_id', 'pedido_id');
    }

    public function producto()
    {
        return $this->belongsTo(Product::class, 'producto_id', 'producto_id');
    }
}
