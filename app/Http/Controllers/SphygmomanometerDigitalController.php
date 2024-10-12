<?php

namespace App\Http\Controllers;

use App\Models\inventori;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use App\Models\SertifikatFisikFungsi;
use App\Models\SertifikatTelaahTeknis;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\SertifikatKondisiLingkungan;
use App\Models\SertifikatSpyghmomanometerakurasi;
use App\Models\SertifikatSpyghmomanometerPengujian;

class SphygmomanometerDigitalController extends Controller
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

        $kebocoran = SertifikatSpyghmomanometerPengujian::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'TypePengujian' => 'kebocoran',
            'Penunjukan_standart' => $data['penunjukan_standar'],
            'idUser' => auth()->user()->id
        ]);
        $lajubuang = SertifikatSpyghmomanometerPengujian::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'TypePengujian' => 'lajubuang',
            'TekananAkhir' => $data['tekananAkhir'],
            'WaktuTerukur' => $data['waktuTerukur'],
            'idUser' => auth()->user()->id
        ]);

        $akurasi = SertifikatSpyghmomanometerakurasi::create([
            'SertifikatId' => $data['sertifikatid'],
            'InstrumenId' => $data['idinstrumen'],
            'Penunjukan' => $data['penunjukan'],
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

    public function cetakExcel($id, $sheet, $spreadsheet)
    {
        $data = Sertifikat::with([
            'getCustomer',
            'getNamaAlat',
            'getPengukuranKondisiLingkungan',
            'getPmeriksaanFisikFungsi',
            'getSpyghmomanometerakurasi',
            'getSpyghmomanometerPengujian',
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

        $sheet->setCellValue('D27', $data->getPengukuranKondisiLingkungan->TempraturAwal);
        $sheet->setCellValue('G27', $data->getPengukuranKondisiLingkungan->TempraturAkhir);
        $sheet->setCellValue('D28', $data->getPengukuranKondisiLingkungan->KelembapanAwal);
        $sheet->setCellValue('G28', $data->getPengukuranKondisiLingkungan->KelembapanAkhir);

        // // PEMERIKSAAN FISIK DAN FUNGSI ALAT
        $colum = 34;
        for ($i=1; $i <= 12; $i++) {
            $par = 'Parameter'.$i;
            $sheet->setCellValue('E'.$colum, $data->getPmeriksaanFisikFungsi->$par);
            $colum +=1;
        }
        $sheet->setCellValue('C50', $data->getSpyghmomanometerPengujian[0]->Penunjukan_standart);
        $sheet->setCellValue('D55', $data->getSpyghmomanometerPengujian[1]->WaktuTerukur);

        $sheet->setCellValue('D55', $data->getSpyghmomanometerPengujian[1]->WaktuTerukur);

        $baris = 60;
        for ($i=0; $i < count($data->getSpyghmomanometerakurasi->Penunjukan); $i++) {
            $sheet->setCellValue('C'.$baris, $data->getSpyghmomanometerakurasi->StandartNaik1[$i]);
            $sheet->setCellValue('D'.$baris, $data->getSpyghmomanometerakurasi->StandartTurun1[$i]);
            $sheet->setCellValue('E'.$baris, $data->getSpyghmomanometerakurasi->StandartNaik2[$i]);
            $sheet->setCellValue('F'.$baris, $data->getSpyghmomanometerakurasi->StandartTurun2[$i]);
            $sheet->setCellValue('G'.$baris, $data->getSpyghmomanometerakurasi->StandartNaik3[$i]);
            $sheet->setCellValue('H'.$baris, $data->getSpyghmomanometerakurasi->StandartTurun3[$i]);
            $baris++;
        }

        // TELAAH TEKNIS
        // $sheet->setCellValue('C68', $data->getTelaahTeknis->FisikFungsi);
        // $sheet->setCellValue('C69', $data->getTelaahTeknis->Kinerja);
        $sheet->mergeCells('C70:E70');
        $sheet->setCellValue('C70', $data->getTelaahTeknis->Catatan);
        $sheet->getStyle('C70')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $newFileName = $data->getCustomer->Name .'_'. $data->SertifikatOrder.'_'. $data->getNamaAlat->Nama. '.xlsx';
        $newFilePath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $newFileName);

        // Simpan Yang Telah Di modifiasi
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);
        return response()->download($newFilePath);
    }
}
