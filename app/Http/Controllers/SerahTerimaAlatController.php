<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\MasterCustomer;
use App\Models\SerahTerima;
use App\Models\SerahTerimaDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SerahTerimaAlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SerahTerima::orderBy('id', 'Desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = '<a href="' . route('st.edit', $row->id) . '" class="btn btn-primary btn-sm btn-edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btnDelete = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
                    return $btnEdit . '  ' . $btnDelete;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('serah-terima.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::all();
        $customer = MasterCustomer::all();
        $instrumen = Instrumen::all();
        return view('serah-terima.form-serah-terima', compact('user', 'instrumen', 'customer'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['KodeSt'] = $this->GenerateKode();
        $data['idUser'] = auth()->user()->id;
        $SerahTerima = SerahTerima::create($data);
        $latestId = SerahTerima::latest()->first()->id ?? 1;
        for ($i = 0; $i < count($request->Merk); $i++) {
            SerahTerimaDetail::create([
                'SerahTerimaId' => $latestId,
                'InstrumenId' => $request->InstrumenId[$i],
                'Merk' => $request->Merk[$i],
                'Type' => $request->Type[$i],
                'SerialNumber' => $request->SerialNumber[$i],
                'Qty' => $request->Qty[$i],
                'Deskripsi' => $request->Deskripsi[$i],
                'idUser' => auth()->user()->id,
            ]);
        }
        return redirect()->back()->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(SerahTerimaAlat $serahTerimaAlat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SerahTerimaAlat $serahTerimaAlat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SerahTerimaAlat $serahTerimaAlat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SerahTerimaAlat $serahTerimaAlat)
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
        $lastKodeAlat = SerahTerima::whereYear('created_at', $year)->whereMonth('created_at', $month2)->orderby('id', 'desc')->first();
        if ($lastKodeAlat) {
            $lastKodeAlat = (int) substr($lastKodeAlat->KodeSt, 0, 4);
            $Kode = str_pad($lastKodeAlat + 1, 4, '0', STR_PAD_LEFT) . '/ST-DKH/' . $month . '/' . $year;
        } else {
            $Kode = '0001/ST-DKH/' . $month . '/' . $year;
        }
        return $Kode;
    }
}
