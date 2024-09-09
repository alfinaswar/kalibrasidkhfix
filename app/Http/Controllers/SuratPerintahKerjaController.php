<?php

namespace App\Http\Controllers;

use App\Models\po;
use App\Models\SuratPerintahKerja;
use App\Models\SuratTugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class SuratPerintahKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SuratTugas::with('getCustomer')->orderBy('id', 'Desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = '<a href="' . route('ku.edit', $row->id) . '" class="btn btn-primary btn-sm btn-edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btnDelete = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
                    $btnPdf = '<a href="' . route('ku.pdf', $row->id) . '" target="_blank" class="btn btn-secondary btn-sm btn-pdf" title="PDF"><i class="fas fa-file-pdf"></i></a>';
                    return $btnEdit . '  ' . $btnDelete . '  ' . $btnPdf;
                })
                ->addColumn('HargaQo', function ($row) {
                    $HargaQo = 'Rp ' . number_format($row->Total, 0, ',', '.');
                    return $HargaQo;
                })
                ->addColumn('Karyawan', function ($row) {
                    $Karyawan = '';
                    $decode = json_decode($row->karyawanId, true);
                    foreach ($decode as $key => $value) {
                        $data = User::where('id', $value)->get('name');
                        $Karyawan .= '<span class="badge bg-dark m-1">' . $data[0]->name . '</span>';
                    }
                    return $Karyawan;
                })
                ->rawColumns(['action', 'HargaQo','Karyawan'])
                ->make(true);
        }
        $user = User::where('role','!=','Admin');
        $po = po::with('getCustomer','DetailPo')->get();
        return view('surat-perintah-kerja.index', compact('user','po'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $user = User::all();
        $po = po::with('getCustomer', 'DetailPo')->where('id',$id)->first();
        return view('surat-perintah-kerja.create', compact('user', 'po'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'CustomerId' => 'required',
            'Tanggal' => 'required',
            'karyawanId' => 'required',
            'Deskripsi' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        $data['karyawanId'] = json_encode($request->karyawanId);
        $data['KodeSpk'] =$this->GenerateKode();
        $data['idUser'] = auth()->user()->id;
        SuratTugas::create($data);
        return redirect()->back()->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratPerintahKerja $suratPerintahKerja)
    {
        //
    }
    public function generatePdf($id)
    {
        $SuratTugas = SuratTugas::with('getCustomer', 'DetailPo', 'getNomorPO')->where('id', $id)->first();
        $info = '';
        $karyawan =  json_decode($SuratTugas->karyawanId);
        foreach ($karyawan as $key => $value) {
            $data = User::select('name', 'role')->where('id', $value)->first();
            $info .= '<span>'.($key+1).'. '. $data->name . '-'. $data->role.'</span><br>';
        }
        $SuratTugas->info = $info;
        if (!$SuratTugas) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('surat-perintah-kerja.surat-tugas', compact('SuratTugas'));
        return $pdf->stream('SuratPerintahKerja_' . $SuratTugas->id . '.pdf');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratPerintahKerja $suratPerintahKerja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratPerintahKerja $suratPerintahKerja)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = SuratTugas::find($id);
        if ($data) {
            $data->delete();
            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } else {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }
    private function GenerateKode()
    {
        $month = date('m');
        $month2 = date('m');
        $romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $month = $romanMonths[$month - 1];
        $year = date('Y');
        $lastKode = SuratTugas::whereYear('created_at', $year)->whereMonth('created_at', $month2)->orderby('id', 'desc')->first();
        if ($lastKode) {
            $lastKode = (int) substr($lastKode->KodeSpk, 0, 4);
            $Kode = str_pad($lastKode + 1, 4, '0', STR_PAD_LEFT) . '/ST-DKH/' . $month . '/' . $year;
        } else {
            $Kode = '0001/ST-DKH/' . $month . '/' . $year;
        }
        return $Kode;
    }
}
