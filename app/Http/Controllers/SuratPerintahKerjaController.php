<?php

namespace App\Http\Controllers;

use App\Models\po;
use App\Models\SuratPerintahKerja;
use App\Models\SuratTugas;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SuratPerintahKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SuratTugas::orderBy('id', 'Desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = '<a href="' . route('ku.edit', $row->id) . '" class="btn btn-primary btn-sm btn-edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btnDelete = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
                    return $btnEdit . '  ' . $btnDelete;
                })
                ->addColumn('HargaQo', function ($row) {
                    $HargaQo = 'Rp ' . number_format($row->Total, 0, ',', '.');
                    return $HargaQo;
                })
                ->rawColumns(['action', 'HargaQo'])
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
        $data = $request->all();
        $data['KodeSpk'] =$this->generateKode();
        $data['iduser'] = auth()->user()->id;
        SuratTugas::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratPerintahKerja $suratPerintahKerja)
    {
        //
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
    public function destroy(SuratPerintahKerja $suratPerintahKerja)
    {
        //
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
