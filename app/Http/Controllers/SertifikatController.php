<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Instrumen;
use App\Models\inventori;
use App\Models\Sertifikat;
use App\Models\MasterMetode;
use Illuminate\Http\Request;
use App\Models\PengukuranListrik;
use App\Models\SertifikatFisikFungsi;
use App\Models\SertifikatTelaahTeknis;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use App\Models\SertifikatKondisiLingkungan;
use App\Models\SertifikatKondisiKelistrikan;
use App\Models\SertifikatCentrifugePengujian;
use App\Models\SertifikatPatientMonitorPengujuan;

class SertifikatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Sertifikat::with('getCustomer', 'getNamaAlat')->orderBy('id', 'Desc');

            if ($request->filled('nama_alat')) {
                $query->whereHas('getNamaAlat', function ($q) use ($request) {
                    $q->where('Nama', 'like', '%' . $request->nama_alat . '%');
                });
            }

            if ($request->filled('status_sertifikat')) {
                $query->where('Status', $request->status_sertifikat);
            }

            $data = $query->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnUji = '<a href="' . route('job.kalibrasi', $row->id) . '" class="btn btn-primary btn-sm btn-edit" title="Kalibrasi"><i class="fas fa-file-signature"></i></a>';
                    $excel = '<a href=  "' . route('job.downloadExcel', $row->id) . '" class="btn btn-secondary btn-sm btn-edit" title="Download Excel"><i class="fas fa-file-excel"></i></a>';
                    $pdf = '<a href="' . route('job.hasilpdf', $row->id) . '" class="btn btn-danger btn-sm btn-edit" title="Download PDF"><i class="fas fa-file-pdf"></i></a>';
                    return $btnUji . ' ' . $excel . ' ' . $pdf;
                })
                ->addColumn('statsertifikat', function ($row) {
                    if ($row->Status == 'DRAFT') {
                        $stat = '<span class="badge bg-warning">DRAFT</span>';
                    } else {
                        $stat = '<span class="badge bg-success">TERBIT</span>';
                    }
                    return $stat;
                })
                ->rawColumns(['action', 'statsertifikat'])
                ->make(true);
        }

        return view('sertifikat.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $sertifikat = Sertifikat::with('getCustomer', 'getNamaAlat')->where('id', $id)->first();

        $InstrumenId = $sertifikat->InstrumenId;
        $cek = Instrumen::where('id', $InstrumenId)->first()->NamaFile;
        $FormLK = 'sertifikat' . DIRECTORY_SEPARATOR . 'form-lk' . DIRECTORY_SEPARATOR . $cek;

        $metode = MasterMetode::get();

        $alatUkurId = $sertifikat->getNamaAlat->AlatUkur;
        $getAlatUkur = inventori::whereIn('id', $alatUkurId)->get();

        return view($FormLK, compact('sertifikat', 'metode', 'getAlatUkur'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
// dd($data);
        // ADMINISTRASI
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
        // dd($data);
        // $cek = instrumen::where('id', $request->idinstrumen)->first()->LK;
        // $filePath = storage_path('app/public/file_lk/' . $cek);

        // // LOAD EXCEL
        // $spreadsheet = IOFactory::load($filePath);
        // // AMBIL SHEET
        // $sheet = $spreadsheet->getSheetByName('LK yg diisi');
        // // MAAPING DATA SESUAI ALAT
        $cekNamaFunction = instrumen::where('id', $request->idinstrumen)->first()->NamaFunction;
        // $function = 'Store' . $cekNamaFunction;
        $namaController = $cekNamaFunction.'Controller';
        $cont = "App\Http\Controllers\s".$namaController;
        $cont = new $cont;
        return $cont->store($data);
    }

    /**
     * Display the specified resource.
     */
    public function downloadExcel($id)
    {
        $getIdInstrumen = sertifikat::where('id', $id)->first()->InstrumenId;
        $cek = instrumen::where('id', $getIdInstrumen)->first()->LK;
        $filePath = storage_path('app/public/file_lk/' . $cek);
        // LOAD EXCEL
        $spreadsheet = IOFactory::load($filePath);
        // AMBIL SHEET
        $sheet = $spreadsheet->getSheetByName('LK yg diisi');
        // MAAPING DATA SESUAI ALAT
        $cekNamaFunction = instrumen::where('id', $getIdInstrumen)->first()->NamaFunction;
        $function = 'Mapping' . $cekNamaFunction;
        $idSertifikat = $id;
        return $this->$function($idSertifikat, $sheet, $spreadsheet);
    }

    public function HasilPdf($id)
    {
        $data = Sertifikat::with('getNamaAlat', 'getCustomer')->where('id', $id)->first();
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('sertifikat.sertifikat-pdf', compact('data'));
        return $pdf->stream('Sertifikat_' . $data->id . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sertifikat $sertifikat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sertifikat $sertifikat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sertifikat $sertifikat)
    {
        //
    }

    private function StoreCentrifuge($data)
    {
        // ADMINISTRASI
        // $sertifikat = Sertifikat::where('id', $data['sertifikatid'])->update([
        //     'Merk' => $data['merk'],
        //     'Type' => $data['type_model'],
        //     'SerialNumber' => $data['nomor_seri'],
        //     'TanggalPelaksanaan' => $data['tanggal_kalibrasi'],
        //     'TanggalTerbit' => null,
        //     'Ruangan' => $data['instansi_ruangan'],
        //     'Hasil' => $data['Hasil'],
        //     'Resolusi' => $data['resolusi'],
        //     'Status' => 'Laik',
        //     'filename' => $newFileName ?? null,
        // ]);

        $KondisiLingkungan = SertifikatKondisiLingkungan::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'TempraturAwal' => $data['KondisiAwal'][0],
            'TempraturAkhir' => $data['KondisiAkhir'][0],
            'KelembapanAwal' => $data['KondisiAwal'][1],
            'KelembapanAkhir' => $data['KondisiAkhir'][1],
            'idUser' => auth()->user()->id
        ]);
        $kondisiListrik = SertifikatKondisiKelistrikan::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'Tegangan_LN' => $data['val'][0],
            'Tegangan_LPE' => $data['val'][1],
            'Tegangan_NPE' => $data['val'][2],
            'idUser' => auth()->user()->id
        ]);
        $FisikFungsi = SertifikatFisikFungsi::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'Parameter1' => $data['Hasil'][0] ?? null,
            'Parameter2' => $data['Hasil'][1] ?? null,
            'Parameter3' => $data['Hasil'][2] ?? null,
            'Parameter4' => $data['Hasil'][3] ?? null,
            'Parameter5' => $data['Hasil'][4] ?? null,
            'Parameter6' => $data['Hasil'][5] ?? null,
            'Parameter7' => $data['Hasil'][6] ?? null,
            'Parameter8' => $data['Hasil'][7] ?? null,
            'Parameter9' => $data['Hasil'][8] ?? null,
            'Parameter10' => $data['Hasil'][9] ?? null,
            'Parameter11' => $data['Hasil'][10] ?? null,
            'Parameter12' => $data['Hasil'][11] ?? null,
            'Parameter13' => $data['Hasil'][12] ?? null,
            'idUser' => auth()->user()->id
        ]);
        $PengukuranListrik = PengukuranListrik::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'tipe' => $data['TipeListrik'],
            'kelas' => $data['Kelas'],
            'Parameter1' => $data['TerukurListrik2'][0],
            'Parameter2' => $data['TerukurListrik2'][1],
            'Parameter3' => $data['TerukurListrik2'][2],
            'Parameter4' => $data['TerukurListrik2'][3],
            'Parameter5' => $data['TerukurListrik2'][4],
            'Parameter6' => $data['TerukurListrik2'][5],
            'idUser' => auth()->user()->id
        ]);

        // pengukuran kinerja
        for ($i = 0; $i < count($data['TestingStandart']); $i++) {
            $tipePengujian = ($i == count($data['TestingStandart']) - 1) ? 'Time' : 'RPM';
            $pengukurankinerja = SertifikatCentrifugePengujian::create([
                'SertifikatId' => $data['sertifikatid'],
                'InstrumenId' => $data['idinstrumen'],
                'TipePenujian' => $tipePengujian,
                'TitikUkur' => $data['TestingStandart'][$i],
                'Pengulangan1' => $data['PembacaanAlat1'][$i],
                'Pengulangan2' => $data['PembacaanAlat2'][$i],
                'Pengulangan3' => $data['PembacaanAlat3'][$i],
                'idUser' => auth()->user()->id
            ]);
        }

        // telaah teknis
        $telaahteknis = SertifikatTelaahTeknis::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'FisikFngsi' => $data['HasilTeknis'][0],
            'KeselamatanListrik' => $data['HasilTeknis'][1],
            'Kinerja' => $data['HasilTeknis'][2],
            'Catatan' => $data['Catatan'],
            'idUser' => auth()->user()->id
        ]);
        return redirect()->back()->with('success', 'Data Berhasil Disimpan');
    }

    private function MappingCentrifuge($idSertifikat, $sheet, $spreadsheet)
    {
        $data = Sertifikat::with([
            'getCustomer',
            'getNamaAlat',
            'getPengukuranKondisiLingkungan',
            'getTeganganUtama',
            'getPmeriksaanFisikFungsi',
            'getPengukuranListrik',
            'getPengujianKinerjaCentrifuge',
            'getTelaahTeknis'
        ])->find($idSertifikat);
        // dd($data);
        $sheet->setCellValue('C8', $data->SertifikatOrder);
        $sheet->setCellValue('C9', $data->Merk);
        $sheet->setCellValue('C10', $data->Type);
        $sheet->setCellValue('C11', $data->SerialNumber);
        $sheet->setCellValue('C12', $data->TanggalPelaksanaan);
        $sheet->setCellValue('C13', $data->Ruangan);
        $sheet->setCellValue('C14', $data->Resolusi);
        $sheet->setCellValue('F9', $data->getCustomer->Name);
        $sheet->setCellValue('F10', $data->getCustomer->Alamat);
        // DATA ALAT UKUR
        $RowAlatUkur = 20;
        foreach ($data->getNamaAlat as $alat) {
            if (is_object($alat) && isset($alat->AlatUkur)) {
                foreach ($alat->AlatUkur as $idAlatUkur) {
                    $alatUkur = Inventori::find($idAlatUkur);
                    if ($alatUkur) {
                        $sheet->setCellValue('B' . $RowAlatUkur, $alatUkur->Nama);
                        $sheet->setCellValue('C' . $RowAlatUkur, $alatUkur->Merk);
                        $sheet->setCellValue('D' . $RowAlatUkur, $alatUkur->Tipe);
                        $sheet->setCellValue('E' . $RowAlatUkur, $alatUkur->Sn);
                        $sheet->setCellValue('F' . $RowAlatUkur, $alatUkur->Tertelusur);
                        $RowAlatUkur++;
                    }
                }
            }
        }
        // dd($data);
        $sheet->setCellValue('D28', $data->getPengukuranKondisiLingkungan->TempraturAwal);
        $sheet->setCellValue('G28', $data->getPengukuranKondisiLingkungan->TempraturAkhir);
        $sheet->setCellValue('D29', $data->getPengukuranKondisiLingkungan->KelembapanAwal);
        $sheet->setCellValue('G29', $data->getPengukuranKondisiLingkungan->KelembapanAkhir);

        $sheet->setCellValue('D30', $data->getTeganganUtama->Tegangan_LN);
        $sheet->setCellValue('D31', $data->getTeganganUtama->Tegangan_LPE);
        $sheet->setCellValue('D32', $data->getTeganganUtama->Tegangan_NPE);
        // PEMERIKSAAN FISIK DAN FUNGSI ALAT
        $sheet->setCellValue('E38', $data->getPmeriksaanFisikFungsi->Parameter1);
        $sheet->setCellValue('E39', $data->getPmeriksaanFisikFungsi->Parameter2);
        $sheet->setCellValue('E40', $data->getPmeriksaanFisikFungsi->Parameter3);
        $sheet->setCellValue('E41', $data->getPmeriksaanFisikFungsi->Parameter4);
        $sheet->setCellValue('E42', $data->getPmeriksaanFisikFungsi->Parameter5);
        $sheet->setCellValue('E43', $data->getPmeriksaanFisikFungsi->Parameter6);
        // PENGUKURAN KESELAMATAN LISTRIK
        // dd($data->getPengukuranListrik);
        if ($data->getPengukuranListrik->tipe == 'B') {
            $tipe = 'C46';
        } elseif ($data->getPengukuranListrik->tipe == 'BF') {
            $tipe = 'E46';
        } else {
            $tipe = 'G46';
        }
        if ($data->getPengukuranListrik->kelas == 'I') {
            $kelas = 'C47';
        } elseif ($data->getPengukuranListrik->tipe == 'II') {
            $kelas = 'E47';
        } else {
            $kelas = 'G47';
        }
        $sheet->setCellValue($tipe, $data->getPengukuranListrik->tipe);
        $sheet->setCellValue($kelas, $data->getPengukuranListrik->kelas);
        $sheet->setCellValue('E50', $data->getPengukuranListrik->Parameter1);
        $sheet->setCellValue('E51', $data->getPengukuranListrik->Parameter2);
        $sheet->setCellValue('E52', $data->getPengukuranListrik->Parameter3);
        $sheet->setCellValue('E53', $data->getPengukuranListrik->Parameter4);
        $sheet->setCellValue('E54', $data->getPengukuranListrik->Parameter5);
        $sheet->setCellValue('E55', $data->getPengukuranListrik->Parameter6);
        // PENGUJIAN KINERJA
        $row = 61;
        $pengujianKinerjaCentrifuge = $data->getPengujianKinerjaCentrifuge;
        $maxRow = count($pengujianKinerjaCentrifuge) - 1;
        for ($i = 0; $i < $maxRow; $i++) {
            $value = $pengujianKinerjaCentrifuge[$i];
            $sheet->setCellValue('C' . $row, $value->TitikUkur);
            $sheet->setCellValue('D' . $row, $value->Pengulangan1);
            $sheet->setCellValue('E' . $row, $value->Pengulangan2);
            $sheet->setCellValue('F' . $row, $value->Pengulangan3);
            $row++;
        }
        // dd($data->getPengujianKinerjaCentrifuge->last()->TipePenujian);
        // PENGUJIAN KINERJA WAKTU
        $sheet->setCellValue('C68', $data->getPengujianKinerjaCentrifuge->last()->TitikUkur);
        $sheet->setCellValue('D68', $data->getPengujianKinerjaCentrifuge->last()->Pengulangan1);
        $sheet->setCellValue('E68', $data->getPengujianKinerjaCentrifuge->last()->Pengulangan2);
        $sheet->setCellValue('F68', $data->getPengujianKinerjaCentrifuge->last()->Pengulangan3);
        // TELAAH TEKNIS

        $sheet->setCellValue('C71', $data->getTelaahTeknis->FisikFungsi);
        $sheet->setCellValue('C72', $data->getTelaahTeknis->KeselamatanListrik);
        $sheet->setCellValue('C73', $data->getTelaahTeknis->Kinerja);
        $sheet->mergeCells('C71:E71');
        $sheet->setCellValue('C71', $data->getTelaahTeknis->Catatan);
        $sheet->getStyle('C71')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $newFileName = $data->nama_pemilik . now()->format('Y-m-d_H-i-s') . '.xlsx';
        $newFilePath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'Nama' . $newFileName);

        // Simpan Yang Telah Di modifiasi
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);
        return response()->download($newFilePath);
    }

    private function StorePatientMonitor($data)
    {
        $KondisiLingkungan = SertifikatKondisiLingkungan::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'TempraturAwal' => $data['KondisiAwal'][0],
            'TempraturAkhir' => $data['KondisiAkhir'][0],
            'KelembapanAwal' => $data['KondisiAwal'][1],
            'KelembapanAkhir' => $data['KondisiAkhir'][1],
            'idUser' => auth()->user()->id
        ]);
        $kondisiListrik = SertifikatKondisiKelistrikan::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'Tegangan_LN' => $data['val'][0],
            'Tegangan_LPE' => $data['val'][1],
            'Tegangan_NPE' => $data['val'][2],
            'idUser' => auth()->user()->id
        ]);
        $FisikFungsi = SertifikatFisikFungsi::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'Parameter1' => $data['Hasil'][0] ?? null,
            'Parameter2' => $data['Hasil'][1] ?? null,
            'Parameter3' => $data['Hasil'][2] ?? null,
            'Parameter4' => $data['Hasil'][3] ?? null,
            'Parameter5' => $data['Hasil'][4] ?? null,
            'Parameter6' => $data['Hasil'][5] ?? null,
            'Parameter7' => $data['Hasil'][6] ?? null,
            'Parameter8' => $data['Hasil'][7] ?? null,
            'Parameter9' => $data['Hasil'][8] ?? null,
            'Parameter10' => $data['Hasil'][9] ?? null,
            'Parameter11' => $data['Hasil'][10] ?? null,
            'Parameter12' => $data['Hasil'][11] ?? null,
            'Parameter13' => $data['Hasil'][12] ?? null,
            'idUser' => auth()->user()->id
        ]);
        $PengukuranListrik = PengukuranListrik::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'tipe' => $data['TipeListrik'],
            'kelas' => $data['Kelas'],
            'Parameter1' => $data['TerukurListrik2'][0],
            'Parameter2' => $data['TerukurListrik2'][1],
            'Parameter3' => $data['TerukurListrik2'][2],
            'Parameter4' => $data['TerukurListrik2'][3],
            'Parameter5' => $data['TerukurListrik2'][4],
            'Parameter6' => $data['TerukurListrik2'][5],
            'idUser' => auth()->user()->id
        ]);

        // pengukuran kinerja heartrate
        for ($i = 0; $i < count($data['Titik_Ukur_Heartrate']); $i++) {
            $pengukurankinerja = SertifikatPatientMonitorPengujuan::create([
                'SertifikatId' => $data['sertifikatid'],
                'InstrumenId' => $data['idinstrumen'],
                'TipePengujian' => 'HEARTRATE',
                'TitikUkur' => $data['Titik_Ukur_Heartrate'][$i],
                'Pengulangan1' => $data['Pengulangan1_Heartrate'][$i],
                'Pengulangan2' => $data['Pengulangan2_Heartrate'][$i],
                'Pengulangan3' => $data['Pengulangan3_Heartrate'][$i],
                'idUser' => auth()->user()->id
            ]);
        }
        // pengukuran kinerja heartrate
        for ($i = 0; $i < count($data['Titik_Ukur_Respirasi']); $i++) {
            $pengukurankinerja = SertifikatPatientMonitorPengujuan::create([
                'SertifikatId' => $data['sertifikatid'],
                'InstrumenId' => $data['idinstrumen'],
                'TipePengujian' => 'RESPIRASI',
                'TitikUkur' => $data['Titik_Ukur_Respirasi'][$i],
                'Pengulangan1' => $data['Pengulangan1_Respirasi'][$i],
                'Pengulangan2' => $data['Pengulangan2_Respirasi'][$i],
                'Pengulangan3' => $data['Pengulangan3_Respirasi'][$i],
                'idUser' => auth()->user()->id
            ]);
        }
        // pengukuran kinerja oksigen
        for ($i = 0; $i < count($data['Titik_Ukur_saturasi_oksigen']); $i++) {
            $pengukurankinerja = SertifikatPatientMonitorPengujuan::create([
                'SertifikatId' => $data['sertifikatid'],
                'InstrumenId' => $data['idinstrumen'],
                'TipePengujian' => 'SATURASI',
                'TitikUkur' => $data['Titik_Ukur_saturasi_oksigen'][$i],
                'Pengulangan1' => $data['Pengulangan1_saturasi_oksigen'][$i],
                'Pengulangan2' => $data['Pengulangan2_saturasi_oksigen'][$i],
                'Pengulangan3' => $data['Pengulangan3_saturasi_oksigen'][$i],
                'idUser' => auth()->user()->id
            ]);
        }
        // pengukuran kinerja oksigen
        for ($i = 0; $i < count($data['Titik_Ukur_Nama']); $i++) {
            $pengukurankinerja = SertifikatPatientMonitorPengujuan::create([
                'SertifikatId' => $data['sertifikatid'],
                'InstrumenId' => $data['idinstrumen'],
                'TipePengujian' => 'TEKANANDARAH',
                'TipeTitikUkur' => $data['Titik_Ukur_Nama'][$i],
                'TitikUkur' => $data['Titik_Ukur_Hasil'][$i],
                'Pengulangan1' => $data['Pengulangan1_Tekanan_Darah'][$i],
                'Pengulangan2' => $data['Pengulangan1_Tekanan_Darah'][$i],
                'Pengulangan3' => $data['Pengulangan1_Tekanan_Darah'][$i],
                'idUser' => auth()->user()->id
            ]);
        }
        // telaah teknis
        $telaahteknis = SertifikatTelaahTeknis::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'FisikFngsi' => $data['HasilTeknis'][0],
            'KeselamatanListrik' => $data['HasilTeknis'][1],
            'Kinerja' => $data['HasilTeknis'][2],
            'Catatan' => $data['Catatan'],
            'idUser' => auth()->user()->id
        ]);
        return redirect()->back()->with('success', 'Data Berhasil Disimpan');
    }

    private function MappingPatientMonitor($idsertifikat, $sheet, $spreadsheet)
    {
        $data = Sertifikat::with([
            'getCustomer',
            'getNamaAlat',
            'getPengukuranKondisiLingkungan',
            'getTeganganUtama',
            'getPmeriksaanFisikFungsi',
            'getPengukuranListrik',
            'getPengujianPatientMonitor',
            'getTelaahTeknis'
        ])->find($idsertifikat);
        // dd($data);
        $sheet->setCellValue('C8', $data->SertifikatOrder);
        $sheet->setCellValue('C9', $data->Merk);
        $sheet->setCellValue('C10', $data->Type);
        $sheet->setCellValue('C11', $data->SerialNumber);
        $sheet->setCellValue('C12', $data->TanggalPelaksanaan);
        $sheet->setCellValue('C13', $data->Ruangan);
        $sheet->setCellValue('C14', $data->Resolusi);
        $sheet->setCellValue('F9', $data->getCustomer->Name);
        $sheet->setCellValue('F10', $data->getCustomer->Alamat);
        // DATA ALAT UKUR
        $RowAlatUkur = 20;
        foreach ($data->getNamaAlat as $alat) {
            if (is_object($alat) && isset($alat->AlatUkur)) {
                foreach ($alat->AlatUkur as $idAlatUkur) {
                    $alatUkur = Inventori::find($idAlatUkur);
                    if ($alatUkur) {
                        $sheet->setCellValue('B' . $RowAlatUkur, $alatUkur->Nama);
                        $sheet->setCellValue('C' . $RowAlatUkur, $alatUkur->Merk);
                        $sheet->setCellValue('D' . $RowAlatUkur, $alatUkur->Tipe);
                        $sheet->setCellValue('E' . $RowAlatUkur, $alatUkur->Sn);
                        $sheet->setCellValue('F' . $RowAlatUkur, $alatUkur->Tertelusur);
                        $RowAlatUkur++;
                    }
                }
            }
        }
        // dd($data);
        $sheet->setCellValue('D28', $data->getPengukuranKondisiLingkungan->TempraturAwal);
        $sheet->setCellValue('G28', $data->getPengukuranKondisiLingkungan->TempraturAkhir);
        $sheet->setCellValue('D29', $data->getPengukuranKondisiLingkungan->KelembapanAwal);
        $sheet->setCellValue('G29', $data->getPengukuranKondisiLingkungan->KelembapanAkhir);

        $sheet->setCellValue('D30', $data->getTeganganUtama->Tegangan_LN);
        $sheet->setCellValue('D31', $data->getTeganganUtama->Tegangan_LPE);
        $sheet->setCellValue('D32', $data->getTeganganUtama->Tegangan_NPE);
        // PEMERIKSAAN FISIK DAN FUNGSI ALAT
        $sheet->setCellValue('E38', $data->getPmeriksaanFisikFungsi->Parameter1);
        $sheet->setCellValue('E39', $data->getPmeriksaanFisikFungsi->Parameter2);
        $sheet->setCellValue('E40', $data->getPmeriksaanFisikFungsi->Parameter3);
        $sheet->setCellValue('E41', $data->getPmeriksaanFisikFungsi->Parameter4);
        $sheet->setCellValue('E42', $data->getPmeriksaanFisikFungsi->Parameter5);
        $sheet->setCellValue('E43', $data->getPmeriksaanFisikFungsi->Parameter6);
        // PENGUKURAN KESELAMATAN LISTRIK
        // dd($data->getPengukuranListrik);
        if ($data->getPengukuranListrik->tipe == 'B') {
            $tipe = 'C46';
        } elseif ($data->getPengukuranListrik->tipe == 'BF') {
            $tipe = 'E46';
        } else {
            $tipe = 'G46';
        }
        if ($data->getPengukuranListrik->kelas == 'I') {
            $kelas = 'C47';
        } elseif ($data->getPengukuranListrik->tipe == 'II') {
            $kelas = 'E47';
        } else {
            $kelas = 'G47';
        }
        $sheet->setCellValue($tipe, $data->getPengukuranListrik->tipe);
        $sheet->setCellValue($kelas, $data->getPengukuranListrik->kelas);
        $sheet->setCellValue('E50', $data->getPengukuranListrik->Parameter1);
        $sheet->setCellValue('E51', $data->getPengukuranListrik->Parameter2);
        $sheet->setCellValue('E52', $data->getPengukuranListrik->Parameter3);
        $sheet->setCellValue('E53', $data->getPengukuranListrik->Parameter4);
        $sheet->setCellValue('E54', $data->getPengukuranListrik->Parameter5);
        $sheet->setCellValue('E55', $data->getPengukuranListrik->Parameter6);

        // PENGUJIAN KINERJA HEARTRATE
        $heartrate = $data->getPengujianPatientMonitor->where('TipePengujian', 'HEARTRATE');
        $rowheartrate = 61;
        foreach ($heartrate as $key => $a) {
            $sheet->setCellValue('C' . $rowheartrate, $a->TitikUkur);
            $sheet->setCellValue('D' . $rowheartrate, $a->Pengulangan1);
            $sheet->setCellValue('E' . $rowheartrate, $a->Pengulangan2);
            $sheet->setCellValue('F' . $rowheartrate, $a->Pengulangan3);
            $rowheartrate++;
        }
        // PENGUJIAN KINERJA RESPIRASI
        $respirasi = $data->getPengujianPatientMonitor->where('TipePengujian', 'RESPIRASI');
        $rowrespirasi = 69;
        foreach ($respirasi as $key => $b) {
            $sheet->setCellValue('C' . $rowrespirasi, $b->TitikUkur);
            $sheet->setCellValue('D' . $rowrespirasi, $b->Pengulangan1);
            $sheet->setCellValue('E' . $rowrespirasi, $b->Pengulangan2);
            $sheet->setCellValue('F' . $rowrespirasi, $b->Pengulangan3);
            $rowrespirasi++;
        }
        // PENGUJIAN KINERJA SATURASI
        $saturasi = $data->getPengujianPatientMonitor->where('TipePengujian', 'SATURASI');
        $rowsaturasi = 76;
        foreach ($saturasi as $key => $c) {
            $sheet->setCellValue('C' . $rowsaturasi, $c->TitikUkur);
            $sheet->setCellValue('D' . $rowsaturasi, $c->Pengulangan1);
            $sheet->setCellValue('E' . $rowsaturasi, $c->Pengulangan2);
            $sheet->setCellValue('F' . $rowsaturasi, $c->Pengulangan3);
            $rowsaturasi++;
        }
        // PENGUJIAN KINERJA TEKANAN DARAH
        $tekanandarah = $data->getPengujianPatientMonitor->where('TipePengujian', 'TEKANANDARAH');
        $rowtekanandarah = 83;
        foreach ($tekanandarah as $key => $d) {
            $sheet->setCellValue('D' . $rowtekanandarah, $d->TipeTitikUkur);
            $sheet->setCellValue('E' . $rowtekanandarah, $d->TitikUkur);
            $sheet->setCellValue('F' . $rowtekanandarah, $d->Pengulangan1);
            $sheet->setCellValue('G' . $rowtekanandarah, $d->Pengulangan2);
            $sheet->setCellValue('H' . $rowtekanandarah, $d->Pengulangan3);
            $rowtekanandarah++;
        }
        // TELAAH TEKNIS

        $sheet->setCellValue('C97', $data->getTelaahTeknis->FisikFungsi);
        $sheet->setCellValue('C98', $data->getTelaahTeknis->KeselamatanListrik);
        $sheet->setCellValue('C99', $data->getTelaahTeknis->Kinerja);
        $sheet->mergeCells('C100:E100');
        $sheet->setCellValue('C100', $data->getTelaahTeknis->Catatan);
        $sheet->getStyle('C100')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $newFileName = $data->nama_pemilik . now()->format('Y-m-d_H-i-s') . '.xlsx';
        $newFilePath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'Nama' . $newFileName);

        // Simpan Yang Telah Di modifiasi
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);
        return response()->download($newFilePath);
    }
}
