<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SertifikatTelaahTeknis;
use App\Models\SertifikatSpyghmomanometerakurasi;
use App\Models\SertifikatSpyghmomanometerPengujian;

class sSphygmomanometerAnalogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($data)
    {
        // dd($data);
        $pengujian = SertifikatSpyghmomanometerPengujian::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'TypePengujian' => 'kebocoran',
            'Penunjukan_standart' => $data['penunjukan_standar'],
            'TekananAkhir' => $data['tekananAkhir'],
            'WaktuTerukur' => $data['waktuTerukur'],
            'idUser' => auth()->user()->id
        ]);

        $akurasi = SertifikatSpyghmomanometerakurasi::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'penunjukan' => $data['penunjukan'],
            'StandartNaik1' => $data['standartNaik1'],
            'StandartTurun1' => $data['standartTurun1'],
            'StandartNaik2' => $data['standartNaik2'],
            'StandartTurun2' => $data['standartTurun2'],
            'StandartNaik3' => $data['standartNaik3'],
            'StandartTurun3' => $data['standartTurun3'],
            'idUser' => auth()->user()->id
        ]);

        $telaahteknis = SertifikatTelaahTeknis::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'FisikFungsi' => $data['HasilTeknis'][0],
            'Kinerja' => $data['HasilTeknis'][2],
            'Catatan' => $data['Catatan'],
            'idUser' => auth()->user()->id
        ]);

        return redirect()->back()->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
