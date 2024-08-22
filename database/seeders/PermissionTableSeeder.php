<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
           'serah-terima-alat',
           'kaji-ulang',
           'quotation',
           'purchase-order',
           'surat-perintah-kerja',
           'job-order',
           'verifikasi-teknis',
           'validasi-mutu'
        ];

        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
