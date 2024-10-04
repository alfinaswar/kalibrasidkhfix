<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\inventori;
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
                    $NamaAlat = '';
                    foreach ($row->AlatUkur as $key => $value) {
                        $alat = inventori::where('id', $value)->first();
                        $NamaAlat .= '<span class="badge bg-dark m-1">' . $alat->Nama . '</span>';
                    }
                    return $NamaAlat;
                })
                ->addColumn('action', function ($row) {
                    $btnEdit = '<a href="' . route('instrumen.edit', $row->id) . '" class="btn btn-primary btn-sm btn-edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btnDelete = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
                    return $btnEdit . '  ' . $btnDelete;
                })
                ->addColumn('TarifRp', function ($row) {
                    $TarifRp = 'Rp ' . number_format($row->Tarif, 0, ',', '.');
                    return $TarifRp;
                })
                ->addColumn('Stat', function ($row) {
                    if ($row->Status == 'AKTIF') {
                        $Stat = '<span class="badge bg-success">Aktif</span>';
                    } else {
                        $Stat = '<span class="badge bg-danger">Tidak AKtif</span>';
                    }
                    return $Stat;
                })
                ->rawColumns(['action', 'NamaAlat', 'Stat', 'TarifRp'])
                ->make(true);
        }
        return view('master.instrumen.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //ganti kategorinya
        $data = inventori::where('Kategori', 'ALATUKUR')->get();
        // dd($data);
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
        // dd($request->NamaFile);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        $data['Tarif'] = str_replace('.', '', $data['Tarif']);
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

        $viewContent = "@extends('layouts.app')\n@section('content')\n<h1>{{ \$post->title }}</h1>\n<p>{{ \$post->content }}</p>\n@endsection";
        $viewPath = resource_path('views' . DIRECTORY_SEPARATOR . 'sertifikat' . DIRECTORY_SEPARATOR . 'form-lk' . DIRECTORY_SEPARATOR . $request->NamaFile . '.blade.php');

        file_put_contents($viewPath, $viewContent);

        return redirect()->route('instrumen.index')->with('success', 'Data Berhasil Disimpan');
    }

    public function getHarga($id)
    {
        $instrumen = Instrumen::find($id);

        if (!$instrumen) {
            return response()->json(['error' => 'Instrumen Tidak Ditemukan'], 404);
        }
        return response()->json(['harga' => $instrumen->Tarif]);
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterAlat $masterAlat)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $instrumen = Instrumen::find($id);
        $data = inventori::where('Kategori', 2)->get();
        return view('master.instrumen.edit', compact('instrumen', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'Kategori' => 'required',
            'Nama' => 'required',
            'Tarif' => 'required',
            'Akreditasi' => 'required',
            'AlatUkur' => 'required',
            'LK' => 'nullable|file|max:1024',
            'Status' => 'required',
        ]);

        $instrumen = Instrumen::find($id);
        if (!$instrumen) {
            return redirect()->route('instrumen.index')->withErrors(['Instrumen tidak ditemukan.']);
        }

        $validatedData['LK'] = $request->hasFile('LK') ? $request->file('LK')->storeAs($request->file('LK')->getClientOriginalName()) : null;

        $instrumen->update($validatedData);

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
