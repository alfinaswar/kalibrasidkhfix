<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use Illuminate\Http\Request;

class SertifikatCentrifugeController extends Controller
{
    public function store($data)
    {
        dd($data);
        $sertifikat = Sertifikat::where('id', $data['sertifikatid'])->update([
            'Merk' => $data['merk'],
            'Type' => $data['type_model'],
            'SerialNumber' => $data['nomor_seri'],
            'TanggalPelaksanaan' => $data['tanggal_kalibrasi'],
            'TanggalTerbit' => null,
            'Ruangan' => $data['instansi_ruangan'],
            'Hasil' => $data['Hasil'],
            'Resolusi' => $data['resolusi'],
            'Status' => 'Laik',
            'filename' => $newFileName ?? null,
        ]);
    }
}
