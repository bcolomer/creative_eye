<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderProductSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('pedidos_productos')->insert([
            [
                'pedido_id' => 1,
                'producto_id' => 1,
                'cantidad' => 2,
                'precio_unitario' => 2599.00,
                'precio_total' => 2 * 2599.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'pedido_id' => 1,
                'producto_id' => 2,
                'cantidad' => 1,
                'precio_unitario' => 1999.99,
                'precio_total' => 1 * 1999.99,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'pedido_id' => 2,
                'producto_id' => 3,
                'cantidad' => 4,
                'precio_unitario' => 149.50,
                'precio_total' => 4 * 149.50,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
