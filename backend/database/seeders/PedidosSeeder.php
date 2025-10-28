<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PedidosSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Pedido 1: José compra Canon RF 50mm + tarjeta SD
        DB::table('pedidos')->insert([
            'pedido_id'    => 1,
            'usuario_id'   => 3, // jose@creative.es
            'fecha_pedido' => now()->toDateString(),
            'total_pedido' => 229.00 + 129.90, // 358.90
            'created_at'   => $now,
            'updated_at' => $now,
        ]);

        DB::table('pedidos_productos')->insert([
            [
                'pedido_id'       => 1,
                'producto_id'     => 6,
                'cantidad'        => 1,
                'precio_unitario' => 229.00,
                'precio_total'    => 229.00,
                'created_at'      => $now,
                'updated_at' => $now,
            ],
            [
                'pedido_id'       => 1,
                'producto_id'     => 10,
                'cantidad'        => 1,
                'precio_unitario' => 129.90,
                'precio_total'    => 129.90,
                'created_at'      => $now,
                'updated_at' => $now,
            ],
        ]);

        // Pedido 2: Laura compra gimbal + micrófono
        DB::table('pedidos')->insert([
            'pedido_id'    => 2,
            'usuario_id'   => 4, // laura@creative.es
            'fecha_pedido' => now()->subDays(3)->toDateString(),
            'total_pedido' => 549.00 + 249.00, // 798.00
            'created_at'   => $now,
            'updated_at' => $now,
        ]);

        DB::table('pedidos_productos')->insert([
            [
                'pedido_id'       => 2,
                'producto_id'     => 12,
                'cantidad'        => 1,
                'precio_unitario' => 549.00,
                'precio_total'    => 549.00,
                'created_at'      => $now,
                'updated_at' => $now,
            ],
            [
                'pedido_id'       => 2,
                'producto_id'     => 11,
                'cantidad'        => 1,
                'precio_unitario' => 249.00,
                'precio_total'    => 249.00,
                'created_at'      => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
