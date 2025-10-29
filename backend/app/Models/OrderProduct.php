<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{

    protected $table = 'pedidos_productos';


    protected $guarded = [];


    // public $timestamps = false;


    public function pedido()
    {
        return $this->belongsTo(Order::class, 'pedido_id');
    }


    public function producto()
    {
        return $this->belongsTo(Product::class, 'producto_id');
    }
}
