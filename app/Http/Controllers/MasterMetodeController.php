<?php

namespace App\Http\Controllers;

use App\Models\MasterMetode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class MasterMetodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = MasterMetode::orderBy('id', 'Desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = '<a href="' . route('metode.edit', $row->id) . '" class="btn btn-primary btn-sm btn-edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btnDelete = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
                    return $btnEdit . '  ' . $btnDelete;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.metode.index');
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->Nama);
        $validator = Validator::make($request->all(), [
            'Nama' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        MasterMetode::create($data);
        return redirect()->route('metode.index')->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterMetode $masterMetode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = MasterMetode::find($id);
        return view('master.metode.edit', compact( 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Nama' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = MasterMetode::find($id);
        $data->update($request->all());

        return redirect()->route('metode.index')->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // dd($id);

            $data = MasterMetode::find($id);
            if ($data) {
                $data->delete();
                return response()->json(['success' => 'data berhasil dihapus'], 200);
            } else {
                return response()->json(['success' => 'data tidak ditemukan'], 404);
            }


    }
}
