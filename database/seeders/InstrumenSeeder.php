<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstrumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('instrumen')->insert([
            [
                'id' => 1,
                'kategori' => 'ALKES',
                'nama' => 'Baby Incubator',
                'harga' => 0,
                'ketersediaan' => 'YA',
                'fitur' => json_encode(["9", "11"]),
                'file_lampiran' => 'Tensimeter Digital.xlsx',
                'slug' => 'Tensimeter-Digital',
                'kode_produk' => 'TensimeterDigital',
                'status' => 'AKTIF',
                'user_id' => 1
            ]
        ]);
    }
}
