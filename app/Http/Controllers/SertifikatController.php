<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use PDF;

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
                    $excel = '<a href="' . route('job.hasilexcel', $row->id) . '" class="btn btn-secondary btn-sm btn-edit" title="Download Excel"><i class="fas fa-file-excel"></i></a>';
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
        $sertifikat = Sertifikat::where('id', $id)->first();
        if ($sertifikat) {
            $InstrumenId = $sertifikat->InstrumenId;
            $idsert = $sertifikat->id;
            // dd($InstrumenId)

            switch ($InstrumenId) {
                case 1:
                    $view = 'sertifikat.create';
                    break;
                case 2:
                    $view = 'sertifikat.create';
                    break;
                case 3:
                    $view = 'sertifikat.create';
                    break;
                case 4:
                    $view = 'sertifikat.create';
                    break;
                case 5:
                    $view = 'sertifikat.create';
                    break;
                default:
                    // Anda bisa menambahkan kasus default jika diperlukan
                    $view = 'default.view';  // atau nilai default lainnya
                    break;
            }
        } else {
            // Handle kasus ketika sertifikat tidak ditemukan
            $view = 'error.not_found';
        }
        // dd($view);
        return view($view, compact('idsert'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $filePath = storage_path('app\public\file_lk\Centrifuge.xlsx');

        // dd($filePath);

        // LOAD EXCEL
        $spreadsheet = IOFactory::load($filePath);

        // AMBIL SHEET YANG SPESIFIK
        $sheet = $spreadsheet->getSheetByName('LK yg diisi');

        // data administrasi
        $sheet->setCellValue('C8', $data['no_order']);
        $sheet->setCellValue('C9', $data['merk']);
        $sheet->setCellValue('C10', $data['type_model']);
        $sheet->setCellValue('C11', $data['nomor_seri']);
        $sheet->setCellValue('C12', $data['tanggal_kalibrasi']);
        $sheet->setCellValue('C13', $data['instansi_ruangan']);
        $sheet->setCellValue('C14', $data['resolusi']);
        $sheet->setCellValue('F9', $data['nama_pemilik']);
        $sheet->setCellValue('F10', $data['alamat_pemilik']);
        // data PENGUKURAN KONDISI LINGKUNGAN
        $sheet->setCellValue('D28', $data['KondisiAwal'][0]);
        $sheet->setCellValue('G28', $data['KondisiAwal'][1]);
        $sheet->setCellValue('D28', $data['KondisiAkhir'][0]);
        $sheet->setCellValue('G28', $data['KondisiAkhir'][1]);

        for ($i = 0; $i < 3; $i++) {
            $sheet->setCellValue('D' . (30 + $i), $data['val'][$i]);
        }
        // PEMERIKSAAN FISIK DAN FUNGSI ALAT
        for ($i = 0; $i < 6; $i++) {
            $sheet->setCellValue('E' . (38 + $i), $data['Hasil'][$i]);
        }
        // PENGUKURAN KESELAMATAN LISTRIK
        for ($i = 0; $i < 6; $i++) {
            $sheet->setCellValue('E' . (50 + $i), $data['TerukurListrik2'][$i]);
        }
        // PENGUJIAN KINERJA
        $row = 61;
        for ($i = 0; $i < count($data['TestingStandart']); $i++) {
            $sheet->setCellValue('C' . $row . '', $data['TestingStandart'][$i]);
            $sheet->setCellValue('D' . $row . '', $data['PembacaanAlat1'][$i]);
            $sheet->setCellValue('E' . $row . '', $data['PembacaanAlat2'][$i]);
            $sheet->setCellValue('F' . $row . '', $data['PembacaanAlat3'][$i]);
            $row++;
        }
        // PENGUJIAN KINERJA WAKTU
        $sheet->setCellValue('C68', $data['StandarWaktu']);
        $sheet->setCellValue('D68', $data['Waktu1']);
        $sheet->setCellValue('E68', $data['Waktu2']);
        $sheet->setCellValue('F68', $data['Waktu3']);
        // TELAAH TEKNIS
        $rowteknis = 71;
        foreach ($data['HasilTeknis'] as $key => $value) {
            $sheet->setCellValue('C' . $rowteknis . '', $data['HasilTeknis'][$key]);
            $rowteknis++;
        }
        // Generate
        $newFileName = $data['nama_pemilik'] . now()->format('Y-m-d_H-i-s') . '.xlsx';
        $newFilePath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'Nama' . $newFileName);

        // Simpan Yang Telah Di modifiasi
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);

        $sertifikat = Sertifikat::where('id', $data['idsert'])->update([
            // 'Lokasi' => $data['Lokasi'],
            'Merk' => $data['merk'],
            'Type' => $data['type_model'],
            'SerialNumber' => $data['nomor_seri'],
            'TanggalPelaksanaan' => $data['tanggal_kalibrasi'],
            'TanggalTerbit' => null,
            'Ruangan' => $data['instansi_ruangan'],
            'Hasil' => $data['Hasil'],
            'Resolusi' => $data['resolusi'],
            // 'MetodeId' => $data['MetodeId'],
            'Status' => 'Laik',
            'filename' => $newFileName,
        ]);

        // return redirect()->back()->with('success', 'Kalibrasi Selesai');
        return response()->download($newFilePath);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sertifikat $sertifikat)
    {
        //
    }
    public function HasilPdf($id)
    {
        $data = Sertifikat::with('getNamaAlat','getCustomer')->where('id', $id)->first();
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
}
