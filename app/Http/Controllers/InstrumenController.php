<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\MasterAlat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class InstrumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Instrumen::orderBy('id', 'Desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('NamaAlat', function ($row) {
                    $namaAlat = '';
                    foreach ($row->AlatUkur as $key => $value) {
                        $alat = MasterAlat::where('id', $value)->get('NamaAlat');
                        $namaAlat .= '<span class="badge bg-dark mb-1">' . $alat[0]->NamaAlat . '</span>';
                    }
                    return $namaAlat;
                })
                ->addColumn('action', function ($row) {
                    $btnEdit = '<a href="' . route('instrumen.edit', $row->id) . '" class="btn btn-primary btn-sm btn-edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btnDelete = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
                    return $btnEdit . '  ' . $btnDelete;
                })
                ->addColumn('Stat', function ($row) {
                    if ($row->Status == 'Baik') {
                        $Stat = '<span class="badge bg-primary">Aktif</span>';
                    } else {
                        $Stat = '<span class="badge bg-primary">Tidak AKtif</span>';
                    }
                    return $Stat;
                })
                ->rawColumns(['action', 'NamaAlat', 'Stat'])
                ->make(true);
        }
        return view('master.instrumen.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = MasterAlat::get();
        return view('master.instrumen.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Kategori' => 'required',
            'Nama' => 'required',
            'Tarif' => 'required',
            'Akreditasi' => 'required',
            'AlatUkur' => 'required',
            'LK' => 'required|file|max:1024',
            'Status' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        if ($request->hasFile('LK')) {
            $file = $request->file('LK');
            $file->storeAs('public/file_lk', $file->getClientOriginalName());
            $data['LK'] = $file->getClientOriginalName();
        } else {
            $data['LK'] = null;
        }
        $data['KodeInstrumen'] = $this->GenerateKode();
        $data['idUser'] = auth()->user()->id;
        Instrumen::create($data);
        return redirect()->route('instrumen.index')->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterAlat $masterAlat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $instrumen = Instrumen::find($id);
        $data = MasterAlat::get();
        return view('master.instrumen.edit', compact('instrumen', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Kategori' => 'required',
            'Nama' => 'required',
            'Tarif' => 'required',
            'Akreditasi' => 'required',
            'AlatUkur' => 'required',
            'LK' => 'required|file|max:1024',
            'Status' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        if ($request->hasFile('LK')) {
            $excelLK = $request->file('LK');
            $excelLK->storeAs('public/file_lk', $excelLK->getClientOriginalName());
            $alat['LK'] = $excelLK->getClientOriginalName();
        } else {
            $alat['LK'] = null;
        }

        $data = $request->all();
        $alat = Instrumen::find($id);
        $alat->update($data);

        return redirect()->route('instrumen.index')->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $alat = Instrumen::find($id);
        if ($alat) {
            $alat->delete();
            return response()->json(['message' => 'instrumen berhasil dihapus'], 200);
        } else {
            return response()->json(['message' => 'Instrumen    tidak ditemukan'], 404);
        }
    }

    private function GenerateKode()
    {
        $month = date('m');
        $month2 = date('m');
        $romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $month = $romanMonths[$month - 1];
        $year = date('Y');
        $lastKodeAlat = Instrumen::whereYear('created_at', $year)->whereMonth('created_at', $month2)->orderby('id', 'desc')->first();
        if ($lastKodeAlat) {
            $lastKodeAlat = (int) substr($lastKodeAlat->KodeInstrumen, 0, 4);
            $KodeAlat = str_pad($lastKodeAlat + 1, 4, '0', STR_PAD_LEFT) . '/INST-DKH/' . $month . '/' . $year;
        } else {
            $KodeAlat = '0001/INST-DKH/' . $month . '/' . $year;
        }
        return $KodeAlat;
    }
}
