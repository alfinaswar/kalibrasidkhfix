<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\KajiUlang;
use App\Models\MasterCustomer;
use App\Models\SerahTerima;
use App\Models\SerahTerimaDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KajiUlangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $data = KajiUlang::with('getInstrumen')->orderBy('id', 'Desc')->get();
        // dd($data);
        if ($request->ajax()) {
            $data = KajiUlang::with('getInstrumen')->orderBy('id', 'Desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = '<a href="' . route('ku.edit', $row->id) . '" class="btn btn-primary btn-sm btn-edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btnDelete = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
                    return $btnEdit . '  ' . $btnDelete;
                })
                ->addColumn('StatusKaji', function ($row) {
                    if($row->Status == 1){
                        $StatusKaji = '<span class="badge bg-green">Diterima</span>';
                    }elseif($row->Status == 2){
                        $StatusKaji = '<span class="badge bg-denger text-white">Ditolak</span>';
                    }else{
                        $StatusKaji = '<span class="badge bg-warning">Diterima Sebagian</span>';
                    }
                    return $StatusKaji;
                })
                ->addColumn('KondisiKaji', function ($row) {
                    if ($row->Status == 1) {
                        $KondisiKaji = '<span class="badge bg-green">Berfungsi</span>';
                    }else{
                        $KondisiKaji = '<span class="badge bg-warning">Tidak Berfungsi</span>';
                    }
                    return $KondisiKaji;
                })
                ->rawColumns(['action','StatusKaji','KondisiKaji'])
                ->make(true);
        }
        $dataSerahTerima = SerahTerima::with('getCustomer')->latest()->get();
        // dd($dataSerahTerima);
        return view('kaji-ulang.index',compact('dataSerahTerima'));
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
    public function store(Request $request)
    {
        for ($j = 0; $j < count($request->InstrumenId); $j++) {
            KajiUlang::create([
                'KodeKajiUlang' => $this->GenerateKode(),
                'SerahTerimaId' => $request->SerahTerimaId,
                'InstrumenId' => $request->InstrumenId[$j],
                'Metode1' => $request->Metode1[$j],
                'Metode2' => $request->Metode2[$j],
                'Status' => $request->Status[$j],
                'Kondisi' => $request->Kondisi[$j],
                'Catatan' => $request->Catatan[$j],
                'idUser' => auth()->user()->id,
            ]);
        }
        return redirect()->back()->with('success','Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(KajiUlang $kajiUlang)
    {
        //
    }
    public function formKaji($id)
    {
        $data = SerahTerima::with('Stdetail')->find($id);
        $customer = MasterCustomer::all();
        $instrumen = Instrumen::all();
        return view('kaji-ulang.form-kaji-ulang',compact('data','instrumen','customer'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KajiUlang $kajiUlang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KajiUlang $kajiUlang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KajiUlang $kajiUlang)
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
        $lastKode = KajiUlang::whereYear('created_at', $year)->whereMonth('created_at', $month2)->orderby('id', 'desc')->first();
        if ($lastKode) {
            $lastKode = (int) substr($lastKode->KodeKajiUlang, 0, 4);
            $Kode = str_pad($lastKode + 1, 4, '0', STR_PAD_LEFT) . '/KU-DKH/' . $month . '/' . $year;
        } else {
            $Kode = '0001/KU-DKH/' . $month . '/' . $year;
        }
        return $Kode;
    }
}
