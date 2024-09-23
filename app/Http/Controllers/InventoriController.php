<?php

namespace App\Http\Controllers;

use App\Models\inventori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class InventoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = inventori::orderBy('id', 'Desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = '<a href="' . route('inv.edit', $row->id) . '" class="btn btn-primary btn-sm btn-edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btnDelete = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
                    return $btnEdit . '  ' . $btnDelete;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.inventori.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.inventori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NamaAlat' => 'required',
            'Merk' => 'required',
            'Type' => 'required',
            'SerialNumber' => 'required',
            'Foto' => 'required|image|max:5000',
            'BuyDate' => 'required',
            'TanggalKalibrasi' => 'required',
            'DueDate' => 'required',
            'Tertelusur' => 'required',
            'Status' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        if ($request->hasFile('Foto')) {
            $foto = $request->file('Foto');
            $foto->storeAs('public/foto_alat', $foto->getClientOriginalName());
            $foto = $request->file('Foto');
        }
        $data['KodeAlat'] = $this->GenerateKode();
        $data['Foto'] = $foto->getClientOriginalName();
        $data['idUser'] = auth()->user()->id;
        MasterAlat::create($data);
        return redirect()->route('alat.index')->with('success', 'Data Berhasil Disimpan');
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
        $alat = MasterAlat::find($id);
        return view('master.inventori.edit', compact('alat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'NamaAlat' => 'required',
            'Merk' => 'required',
            'Type' => 'required',
            'SerialNumber' => 'required',
            'Foto' => 'image|max:5000',
            'BuyDate' => 'required',
            'TanggalKalibrasi' => 'required',
            'DueDate' => 'required',
            'Tertelusur' => 'required',
            'Status' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        if ($request->hasFile('Foto')) {
            $foto = $request->file('Foto');
            $foto->storeAs('public/foto_alat', $foto->getClientOriginalName());
            $validator['Foto'] = $foto->getClientOriginalName();
        }

        $alat = MasterAlat::find($id);
        $alat->update($request->all());

        return redirect()->route('alat.index')->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $alat = MasterAlat::find($id);
        if ($alat) {
            $alat->delete();
            return response()->json(['message' => 'fasilitas berhasil dihapus'], 200);
        } else {
            return response()->json(['message' => 'room tidak ditemukan'], 404);
        }
    }

    private function GenerateKode()
    {
        $month = date('m');
        $month2 = date('m');
        $romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $month = $romanMonths[$month - 1];
        $year = date('Y');
        $lastKodeAlat = MasterAlat::whereYear('created_at', $year)->whereMonth('created_at', $month2)->orderby('id', 'desc')->first();
        if ($lastKodeAlat) {
            $lastKodeAlat = (int) substr($lastKodeAlat->KodeAlat, 0, 4);
            $KodeAlat = str_pad($lastKodeAlat + 1, 4, '0', STR_PAD_LEFT) . '/AS-DKH/' . $month . '/' . $year;
        } else {
            $KodeAlat = '0001/AS-DKH/' . $month . '/' . $year;
        }
        return $KodeAlat;
    }
}
