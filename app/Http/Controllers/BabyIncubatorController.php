<?php

namespace App\Http\Controllers;

use App\Models\inventori;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use App\Models\KondisiKebisingan;
use App\Models\PengukuranListrik;
use App\Models\SertifikatFisikFungsi;
use App\Models\SertifikatTelaahTeknis;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\SertifikatKondisiLingkungan;
use App\Models\SertifikatKondisiKelistrikan;
use App\Models\SertifikatBabyIncubatorPengujian;

class BabyIncubatorController extends Controller
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
            'idUser' => auth()->user()->id,
        ]);
        $kondisiListrik = SertifikatKondisiKelistrikan::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'Tegangan_LN' => $data['val'][0],
            'Tegangan_LPE' => $data['val'][1],
            'Tegangan_NPE' => $data['val'][2],
            'idUser' => auth()->user()->id,
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
            'idUser' => auth()->user()->id,
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
            'idUser' => auth()->user()->id,
        ]);

        $kebisingan = KondisiKebisingan::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'Penunjukan' => $data['Kebisingan'],
            'idUser' => auth()->user()->id,
        ]);

        $ujiA = SertifikatBabyIncubatorPengujian::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'TipePengujian' => 'A',
            'SettingAlat' => $data['SettingAlat'],
            'Sensor' => $data['SensorA'],
            'Pengulangan1' => $data['Pengulangan1A'],
            'Pengulangan2' => $data['Pengulangan2A'],
            'Pengulangan3' => $data['Pengulangan3A'],
            'Pengulangan4' => $data['Pengulangan4A'],
            'Pengulangan5' => $data['Pengulangan5A'],
            'idUser' => auth()->user()->id,
        ]);

        $ujiB = SertifikatBabyIncubatorPengujian::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'TipePengujian' => 'B',
            'SettingAlat' => $data['SettingAlatB'],
            'Sensor' => $data['SensorB'],
            'Pengulangan1' => $data['Pengulangan1B'],
            'Pengulangan2' => $data['Pengulangan2B'],
            'Pengulangan3' => $data['Pengulangan3B'],
            'idUser' => auth()->user()->id,
        ]);

        $ujiC = SertifikatBabyIncubatorPengujian::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'TipePengujian' => 'C',
            'SettingAlat' => $data['SettingAlatC'],
            'Sensor' => $data['SensorC'],
            'Pengulangan1' => $data['Pengulangan1C'],
            'idUser' => auth()->user()->id,
        ]);

        $ujiD = SertifikatBabyIncubatorPengujian::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'TipePengujian' => 'D',
            'SettingAlat' => $data['SettingAlatD'],
            'Sensor' => $data['SensorD'],
            'Pengulangan1' => $data['Pengulangan1D'],
            'idUser' => auth()->user()->id,
        ]);

        $ujiE = SertifikatBabyIncubatorPengujian::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'TipePengujian' => 'E',
            'SettingAlat' => $data['SettingAlatE'],
            'Sensor' => $data['SensorE'],
            'Pengulangan1' => $data['Pengulangan1E'],
            'idUser' => auth()->user()->id,
        ]);

        $ujiF = SertifikatBabyIncubatorPengujian::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'TipePengujian' => 'F',
            'SettingAlat' => $data['SettingAlatF'],
            'Sensor' => $data['SensorF'],
            'Pengulangan1' => $data['Pengulangan1F'],
            'idUser' => auth()->user()->id,
        ]);

        $ujiG = SertifikatBabyIncubatorPengujian::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'TipePengujian' => 'G',
            'SettingAlat' => $data['SettingAlatG'],
            'Sensor' => $data['SensorG'],
            'Pengulangan1' => $data['Pengulangan1G'],
            'Pengulangan2' => $data['Pengulangan2G'],
            'Pengulangan3' => $data['Pengulangan3G'],
            'Pengulangan4' => $data['Pengulangan4G'],
            'idUser' => auth()->user()->id,
        ]);

        $ujiH = SertifikatBabyIncubatorPengujian::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'TipePengujian' => 'H',
            'SettingAlat' => $data['SettingAlatH'],
            'Pengulangan1' => $data['Pengulangan1H'],
            'Pengulangan2' => $data['Pengulangan2H'],
            'Pengulangan3' => $data['Pengulangan3H'],
            'idUser' => auth()->user()->id,
        ]);

        $ujiI = SertifikatBabyIncubatorPengujian::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'TipePengujian' => 'I',
            'SettingAlat' => $data['SettingAlatI'],
            'Sensor' => $data['SensorI'],
            'Pengulangan1' => $data['Pengulangan1I'],
            'Pengulangan2' => $data['Pengulangan2I'],
            'Pengulangan3' => $data['Pengulangan3I'],
            'idUser' => auth()->user()->id,
        ]);

        $telaahteknis = SertifikatTelaahTeknis::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'FisikFungsi' => $data['HasilTeknis'][0],
            'KeselamatanListrik' => $data['HasilTeknis'][1],
            'Kinerja' => $data['HasilTeknis'][2],
            'Catatan' => $data['Catatan'],
            'idUser' => auth()->user()->id,
        ]);

        return redirect()->back()->with('success', 'Data Berhasil Disimpan');
    }

    public function cetakExcel($id, $sheet, $spreadsheet)
    {
        $data = Sertifikat::with(['getCustomer', 'getNamaAlat', 'getPengukuranKondisiLingkungan', 'getTeganganUtama', 'getPmeriksaanFisikFungsi', 'getPengukuranListrik', 'getBabyIncubatorPengujian', 'getKebisingan', 'getTelaahTeknis'])->find($id);
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
        $sheet->setCellValue('D28', $data->getPengukuranKondisiLingkungan->TempraturAwal);
        $sheet->setCellValue('G28', $data->getPengukuranKondisiLingkungan->TempraturAkhir);
        $sheet->setCellValue('D29', $data->getPengukuranKondisiLingkungan->KelembapanAwal);
        $sheet->setCellValue('G29', $data->getPengukuranKondisiLingkungan->KelembapanAkhir);
        $sheet->setCellValue('D30', $data->getTeganganUtama->Tegangan_LN);
        $sheet->setCellValue('D31', $data->getTeganganUtama->Tegangan_LPE);
        $sheet->setCellValue('D32', $data->getTeganganUtama->Tegangan_NPE);
        $sheet->mergeCells('C33:D33');
        $sheet->setCellValue('C33', $data->getKebisingan->Penunjukan);
        $sheet
            ->getStyle('C33')
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // pemeriksaan fisik dan fungsi alat
        $colum = 39;
        for ($i = 1; $i <= 10; $i++) {
            $par = 'Parameter' . $i;
            $sheet->setCellValue('E' . $colum, $data->getPmeriksaanFisikFungsi->$par);
            $colum += 1;
        }

        // pengukuran keselamatan listrik
        if ($data->getPengukuranListrik->tipe == 'B') {
            $tipe = 'C51';
        } elseif ($data->getPengukuranListrik->tipe == 'BF') {
            $tipe = 'E51';
        } else {
            $tipe = 'G51';
        }
        if ($data->getPengukuranListrik->kelas == 'I') {
            $kelas = 'C52';
        } elseif ($data->getPengukuranListrik->tipe == 'II') {
            $kelas = 'E52';
        } else {
            $kelas = 'G52';
        }

        $sheet->setCellValue($tipe, $data->getPengukuranListrik->tipe);
        $sheet->setCellValue($kelas, $data->getPengukuranListrik->kelas);
        $sheet->setCellValue('E55', $data->getPengukuranListrik->Parameter1);
        $sheet->setCellValue('E56', $data->getPengukuranListrik->Parameter2);
        $sheet->setCellValue('E57', $data->getPengukuranListrik->Parameter3);
        $sheet->setCellValue('E58', $data->getPengukuranListrik->Parameter4);
        $sheet->setCellValue('E59', $data->getPengukuranListrik->Parameter5);
        $sheet->setCellValue('E60', $data->getPengukuranListrik->Parameter6);

        // pengujian
        // uji A
        $colum = 67;
        for ($i = 0; $i < count($data->getBabyIncubatorPengujian[0]->Pengulangan1); $i++) {
            $sheet->setCellValue('D' . $colum, $data->getBabyIncubatorPengujian[0]->Pengulangan1[$i]);
            $sheet->setCellValue('E' . $colum, $data->getBabyIncubatorPengujian[0]->Pengulangan2[$i]);
            $sheet->setCellValue('F' . $colum, $data->getBabyIncubatorPengujian[0]->Pengulangan3[$i]);
            $sheet->setCellValue('G' . $colum, $data->getBabyIncubatorPengujian[0]->Pengulangan4[$i]);
            $sheet->setCellValue('H' . $colum, $data->getBabyIncubatorPengujian[0]->Pengulangan5[$i]);
            $colum++;
        }

        // Uji B
        $colum2 = 81;
        for ($i = 0; $i < count($data->getBabyIncubatorPengujian[1]->Pengulangan1); $i++) {
            $sheet->setCellValue('D' . $colum2, $data->getBabyIncubatorPengujian[1]->Pengulangan1[$i]);
            $sheet->setCellValue('E' . $colum2, $data->getBabyIncubatorPengujian[1]->Pengulangan2[$i]);
            $sheet->setCellValue('F' . $colum2, $data->getBabyIncubatorPengujian[1]->Pengulangan3[$i]);
            $colum2++;
        }

        // Uji C
        $sheet->setCellValue('D86', $data->getBabyIncubatorPengujian[2]->Pengulangan1[0]);

        // Uji D
        $sheet->setCellValue('D90', $data->getBabyIncubatorPengujian[3]->Pengulangan1[0]);

        // Uji E
        $sheet->setCellValue('D94', $data->getBabyIncubatorPengujian[4]->Pengulangan1[0]);

        // Uji F
        $sheet->setCellValue('D98', $data->getBabyIncubatorPengujian[5]->Pengulangan1[0]);

        // Uji G
        $sheet->setCellValue('D103', $data->getBabyIncubatorPengujian[6]->Pengulangan1[0]);
        $sheet->setCellValue('E103', $data->getBabyIncubatorPengujian[6]->Pengulangan2[0]);
        $sheet->setCellValue('F103', $data->getBabyIncubatorPengujian[6]->Pengulangan3[0]);
        $sheet->setCellValue('G103', $data->getBabyIncubatorPengujian[6]->Pengulangan4[0]);

        // Uji H
        $sheet->setCellValue('C109', $data->getBabyIncubatorPengujian[7]->Pengulangan1[0]);
        $sheet->setCellValue('D109', $data->getBabyIncubatorPengujian[7]->Pengulangan2[0]);
        $sheet->setCellValue('E109', $data->getBabyIncubatorPengujian[7]->Pengulangan3[0]);

        // Uji I
        $sheet->setCellValue('D114', $data->getBabyIncubatorPengujian[8]->Pengulangan1[0]);
        $sheet->setCellValue('E114', $data->getBabyIncubatorPengujian[8]->Pengulangan2[0]);
        $sheet->setCellValue('F114', $data->getBabyIncubatorPengujian[8]->Pengulangan3[0]);

        // $sheet->setCellValue('C117', $data->getTelaahTeknis->FisikFungsi);
        // $sheet->setCellValue('C118', $data->getTelaahTeknis->KeselamatanListrik);
        // $sheet->setCellValue('C119', $data->getTelaahTeknis->Kinerja);
        $sheet->mergeCells('C120:E120');
        $sheet->setCellValue('C120', $data->getTelaahTeknis->Catatan);
        $sheet
            ->getStyle('C120')
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $newFileName = $data->getCustomer->Name . '_' . $data->SertifikatOrder . '_' . $data->getNamaAlat->Nama . '.xlsx';
        $newFilePath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'Nama' . $newFileName);

        // Simpan Yang Telah Di modifiasi
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);
        return response()->download($newFilePath);
    }
}
