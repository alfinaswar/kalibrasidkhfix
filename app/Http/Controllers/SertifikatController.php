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
                    if ($row->Diserahkan == 'N') {
                        $stat = '<span class="badge bg-warning">DRAFT</span>';
                    } else {
                        $stat = '<span class="badge bg-success">TERBIT</span>';
                    }
                    return $stat;
                })
                ->rawColumns(['action', 'statsertifikat'])
                ->make(true);
        }
$instrumen = Instrumen::get();
        return view('sertifikat.index',compact('instrumen'));
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
        $sertifikat = Sertifikat::where('id', $data['sertifikatid'])->update([
            'Merk' => $data['merk'],
            'Type' => $data['type_model'],
            'SerialNumber' => $data['nomor_seri'],
            'TanggalPelaksanaan' => $data['tanggal_kalibrasi'],
            'TanggalTerbit' => null,
            'Ruangan' => $data['instansi_ruangan'],
            'Hasil' => $data['HasilAdm'],
            'Resolusi' => $data['resolusi'],
            'Status' => 'AKTIF',
            'filename' => $newFileName ?? null,
        ]);
        $cekNamaFunction = instrumen::where('id', $request->idinstrumen)->first()->NamaFunction;
        // $function = 'Store' . $cekNamaFunction;
        $namaController = $cekNamaFunction . 'Controller';
        $cont = "App" . DIRECTORY_SEPARATOR . "Http" . DIRECTORY_SEPARATOR . "Controllers" . DIRECTORY_SEPARATOR . $namaController;
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
        $namaController = $cekNamaFunction . 'Controller';
        $cont = "App" . DIRECTORY_SEPARATOR . "Http" . DIRECTORY_SEPARATOR . "Controllers" . DIRECTORY_SEPARATOR . $namaController;
        $cont = new $cont;
        return $cont->cetakExcel($id, $sheet, $spreadsheet);
    }

    public function HasilPdf($id)
    {
        $data = Sertifikat::with('getNamaAlat', 'getCustomer')->where('id', $id)->first();
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('sertifikat.sertifikat-pdf', compact('data'));
        return $pdf->stream('Sertifikat_' . $data->id . '.pdf');
    }
}
