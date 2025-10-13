<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('productos')->insert([
            // FOTOGRAFIA (categoria_id = 1)
            [
                'producto_id' => 1,
                'nombre'      => 'Canon EOS R6 Mark II (cuerpo)',
                'cantidad'    => 5,
                'precio'      => 2599.00,
                'codigo'      => 'CAM-CAN-R6M2-BODY',
                'foto'        => 'https://images.unsplash.com/photo-1519183071298-a2962be96f83',
                'descripcion' => 'Cámara full-frame con excelente rendimiento en ráfaga y AF para fotografía deportiva y de eventos. Estabilización en el cuerpo (IBIS) y buen rendimiento en ISO alto.',
                'categoria_id' => 1,
                'created_at'  => $now,
                'updated_at' => $now,
            ],
            [
                'producto_id' => 2,
                'nombre'      => 'Fujifilm X-T5 (cuerpo)',
                'cantidad'    => 8,
                'precio'      => 1899.00,
                'codigo'      => 'CAM-FUJ-XT5-BODY',
                'foto'        => 'https://images.unsplash.com/photo-1520975922131-c0f36b5f3d53',
                'descripcion' => 'Cámara APS-C de 40MP con excelente color y sistema de simulación de película. Ideal para retrato y fotografía de estudio.',
                'categoria_id' => 1,
                'created_at'  => $now,
                'updated_at' => $now,
            ],
            [
                'producto_id' => 3,
                'nombre'      => 'Sony Alpha A7 IV (cuerpo)',
                'cantidad'    => 4,
                'precio'      => 2799.00,
                'codigo'      => 'CAM-SON-A7IV-BODY',
                'foto'        => 'https://images.unsplash.com/photo-1526178611150-1a6f1f1a1c5d',
                'descripcion' => 'Híbrida full-frame 33MP con un balance entre foto y vídeo; AF avanzado y soporte amplio de lentes FE.',
                'categoria_id' => 1,
                'created_at'  => $now,
                'updated_at' => $now,
            ],

            // VIDEO (categoria_id = 2)
            [
                'producto_id' => 4,
                'nombre'      => 'Blackmagic Pocket Cinema Camera 6K G2',
                'cantidad'    => 3,
                'precio'      => 1995.00,
                'codigo'      => 'VID-BMD-P6KG2',
                'foto'        => 'https://www.blackmagicdesign.com/img/products/cinema-camera/pocket-cinema-camera-6k/g2/camera-gallery-1.jpg',
                'descripcion' => 'Cámara de cine 6K con sensor Super 35, grabación en Blackmagic RAW y ProRes; pensada para producción de vídeo profesional y documentales.',
                'categoria_id' => 2,
                'created_at'  => $now,
                'updated_at' => $now,
            ],
            [
                'producto_id' => 5,
                'nombre'      => 'Panasonic Lumix S5 II (cuerpo)',
                'cantidad'    => 4,
                'precio'      => 1999.00,
                'codigo'      => 'VID-PAN-S5II',
                'foto'        => 'https://cdn.panasonic.com/photo/s5ii-front.jpg',
                'descripcion' => 'Cámara mirrorless full-frame orientada a vídeo: estabilización, perfiles log y buena gestión térmica para tomas largas.',
                'categoria_id' => 2,
                'created_at'  => $now,
                'updated_at' => $now,
            ],

            // OBJETIVOS (categoria_id = 3)
            [
                'producto_id' => 6,
                'nombre'      => 'Canon RF 50mm f/1.8 STM',
                'cantidad'    => 15,
                'precio'      => 229.00,
                'codigo'      => 'LEN-CAN-RF50F18',
                'foto'        => 'https://upload.wikimedia.org/wikipedia/commons/0/08/Canon_RF_50mm_f1.8_STM.jpg',
                'descripcion' => 'Pequeño y ligero "nifty fifty" para montura RF. Buen rendimiento en retrato y baja luz, relación calidad-precio excelente.',
                'categoria_id' => 3,
                'created_at'  => $now,
                'updated_at' => $now,
            ],
            [
                'producto_id' => 7,
                'nombre'      => 'Sony FE 24-70mm f/2.8 GM II',
                'cantidad'    => 3,
                'precio'      => 2399.00,
                'codigo'      => 'LEN-SON-2470GM2',
                'foto'        => 'https://upload.wikimedia.org/wikipedia/commons/9/9f/Sony_FE_24-70mm_F2.8_GM.jpg',
                'descripcion' => 'Zoom estándar profesional con excelente nitidez y sellado climático; ideal para bodas, eventos y producción comercial.',
                'categoria_id' => 3,
                'created_at'  => $now,
                'updated_at' => $now,
            ],
            [
                'producto_id' => 8,
                'nombre'      => 'Sigma 18-35mm f/1.8 DC HSM Art (Canon EF)',
                'cantidad'    => 6,
                'precio'      => 799.00,
                'codigo'      => 'LEN-SIG-1835ART-EF',
                'foto'        => 'https://upload.wikimedia.org/wikipedia/commons/5/53/Sigma_18-35mm_f1.8_Dc_Hsm_Art.jpg',
                'descripcion' => 'Objetivo luminoso para APS-C; muy valorado en vídeo por su apertura constante y calidad óptica.',
                'categoria_id' => 3,
                'created_at'  => $now,
                'updated_at' => $now,
            ],

            // ACCESORIOS (categoria_id = 4)
            [
                'producto_id' => 9,
                'nombre'      => 'Trípode Manfrotto Befree Advanced',
                'cantidad'    => 10,
                'precio'      => 199.00,
                'codigo'      => 'ACC-MAN-BEFREE-ADV',
                'foto'        => 'https://images.unsplash.com/photo-1512070679279-8988d32161be',
                'descripcion' => 'Trípode compacto y resistente, pensado para viajar. Compatible con cámaras mirrorless y DSLR ligeras.',
                'categoria_id' => 4,
                'created_at'  => $now,
                'updated_at' => $now,
            ],
            [
                'producto_id' => 10,
                'nombre'      => 'Tarjeta SDXC 128GB UHS-II V90',
                'cantidad'    => 25,
                'precio'      => 129.90,
                'codigo'      => 'ACC-SDXC-128-V90',
                'foto'        => 'https://images.unsplash.com/photo-1585386959984-a41552231608',
                'descripcion' => 'Tarjeta de alta velocidad para grabaciones 4K/6K y ráfagas prolongadas; indicada para cámaras profesionales.',
                'categoria_id' => 4,
                'created_at'  => $now,
                'updated_at' => $now,
            ],
            [
                'producto_id' => 11,
                'nombre'      => 'Rode VideoMic NTG',
                'cantidad'    => 7,
                'precio'      => 249.00,
                'codigo'      => 'ACC-ROD-VIDNTG',
                'foto'        => 'https://images.unsplash.com/photo-1581276879432-15a936da3a4a',
                'descripcion' => 'Micrófono shotgun híbrido con salida TRS y USB; ideal para creadores de contenido y vídeos en exteriores.',
                'categoria_id' => 4,
                'created_at'  => $now,
                'updated_at' => $now,
            ],
            [
                'producto_id' => 12,
                'nombre'      => 'DJI RS 4 (gimbal)',
                'cantidad'    => 2,
                'precio'      => 549.00,
                'codigo'      => 'ACC-DJI-RS4',
                'foto'        => 'https://images.unsplash.com/photo-1604335399105-0e21c3d2e2da',
                'descripcion' => 'Estabilizador 3 ejes para cámaras mirrorless y DSLR ligeras; buen soporte de carga y modos de seguimiento.',
                'categoria_id' => 4,
                'created_at'  => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
