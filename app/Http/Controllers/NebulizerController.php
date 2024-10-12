<?php

namespace App\Http\Controllers;

use App\Models\inventori;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use App\Models\PengukuranListrik;
use App\Models\SertifikatFisikFungsi;
use App\Models\SertifikatTelaahTeknis;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\SertifikatKondisiLingkungan;
use App\Models\SertifikatKondisiKelistrikan;
use App\Models\SertifikatNebulizerPengujian;

class NebulizerController extends Controller
{
    public function store($data)
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

        $pengujian = SertifikatNebulizerPengujian::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'Pengulangan1' => $data['Pengulangan1'],
            'Pengulangan2' => $data['Pengulangan2'],
            'Pengulangan3' => $data['Pengulangan3'],
            'Pengulangan4' => $data['Pengulangan4'],
            'Pengulangan5' => $data['Pengulangan5'],
            'idUser' => auth()->user()->id
        ]);

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

    public function cetakExcel($id, $sheet, $spreadsheet)
    {
        $data = Sertifikat::with([
            'getCustomer',
            'getNamaAlat',
            'getPengukuranKondisiLingkungan',
            'getTeganganUtama',
            'getPmeriksaanFisikFungsi',
            'getPengukuranListrik',
            'getNebulizerPengujian',
            'getTelaahTeknis'
        ])->find($id);
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
                    $alatUkur = inventori::find($idAlatUkur);
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

        // pengukuran kondisi
        $sheet->setCellValue('D27', $data->getPengukuranKondisiLingkungan->TempraturAwal);
        $sheet->setCellValue('G27', $data->getPengukuranKondisiLingkungan->TempraturAkhir);
        $sheet->setCellValue('D28', $data->getPengukuranKondisiLingkungan->KelembapanAwal);
        $sheet->setCellValue('G28', $data->getPengukuranKondisiLingkungan->KelembapanAkhir);
        $sheet->setCellValue('D29', $data->getTeganganUtama->Tegangan_LN);
        $sheet->setCellValue('D30', $data->getTeganganUtama->Tegangan_LPE);
        $sheet->setCellValue('D31', $data->getTeganganUtama->Tegangan_NPE);

        // pemeriksaan fisik dan fungsi alat
        $colum = 37;
        for ($i=1; $i <= 6; $i++) {
            $par = 'Parameter'.$i;
            $sheet->setCellValue('E'.$colum, $data->getPmeriksaanFisikFungsi->$par);
            $colum +=1;
        }

        // pengukuran keselamatan listrik
        if ($data->getPengukuranListrik->tipe == 'B') {
            $tipe = 'C45';
        } elseif ($data->getPengukuranListrik->tipe == 'BF') {
            $tipe = 'E45';
        } else {
            $tipe = 'G45';
        }
        if ($data->getPengukuranListrik->kelas == 'I') {
            $kelas = 'C46';
        } elseif ($data->getPengukuranListrik->tipe == 'II') {
            $kelas = 'E46';
        } else {
            $kelas = 'G46';
        }

        $sheet->setCellValue($tipe, $data->getPengukuranListrik->tipe);
        $sheet->setCellValue($kelas, $data->getPengukuranListrik->kelas);
        $sheet->setCellValue('E49', $data->getPengukuranListrik->Parameter1);
        $sheet->setCellValue('E50', $data->getPengukuranListrik->Parameter2);
        $sheet->setCellValue('E51', $data->getPengukuranListrik->Parameter3);
        $sheet->setCellValue('E52', $data->getPengukuranListrik->Parameter4);
        $sheet->setCellValue('E53', $data->getPengukuranListrik->Parameter5);
        $sheet->setCellValue('E54', $data->getPengukuranListrik->Parameter6);

        // pengujian
        $sheet->setCellValue('C60', $data->getNebulizerPengujian->Pengulangan1);
        $sheet->setCellValue('D60', $data->getNebulizerPengujian->Pengulangan2);
        $sheet->setCellValue('E60', $data->getNebulizerPengujian->Pengulangan3);
        $sheet->setCellValue('F60', $data->getNebulizerPengujian->Pengulangan4);
        $sheet->setCellValue('G60', $data->getNebulizerPengujian->Pengulangan5);

        // $sheet->setCellValue('C97', $data->getTelaahTeknis->FisikFungsi);
        // $sheet->setCellValue('C98', $data->getTelaahTeknis->KeselamatanListrik);
        // $sheet->setCellValue('C99', $data->getTelaahTeknis->Kinerja);
        $sheet->mergeCells('C67:E67');
        $sheet->setCellValue('C67', $data->getTelaahTeknis->Catatan);
        $sheet->getStyle('C67')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $newFileName = $data->getCustomer->Name .'_'. $data->SertifikatOrder.'_'. $data->getNamaAlat->Nama. '.xlsx';
        $newFilePath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'Nama' . $newFileName);

        // Simpan Yang Telah Di modifiasi
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);
        return response()->download($newFilePath);
    }
}
