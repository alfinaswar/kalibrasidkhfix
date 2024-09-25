<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\MasterAlat;
use App\Models\MasterCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class MasterCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MasterCustomer::orderBy('id', 'Desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = '<a href="' . route('customer.edit', $row->id) . '" class="btn btn-primary btn-sm btn-edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btnDelete = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
                    return $btnEdit . '  ' . $btnDelete;
                })
                ->addColumn('Kontak', function ($row) {
                    $Kontak = '<span>'.$row->Email.'</span><hr><span>'.$row->Telepon.'<span>';
                    return $Kontak;
                })
                ->rawColumns(['action','Kontak'])
                ->make(true);
        }
        return view('master.customer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Kategori' => 'required',
            'NoAspak' => 'required',
            'Nama' => 'required',
            'Email' => 'required|email',
            'Telepon' => 'required',
            'Alamat' => 'required',
            'Deskripsi' => 'required',
            'Status' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        $data['Name'] = $request->Nama;
        $data['KodeCust'] = $this->GenerateKode();
        $data['idUser'] = auth()->user()->id;
        MasterCustomer::create($data);
        return redirect()->route('customer.index')->with('success', 'Data Berhasil Disimpan');
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
        $customer = MasterCustomer::find($id);
        return view('master.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Kategori' => 'required',
            'NoAspak' => 'required',
            'Name' => 'required',
            'Email' => 'required|email',
            'Telepon' => 'required',
            'Alamat' => 'required',
            'Deskripsi' => 'required',
            'Status' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        $cust = MasterCustomer::find($id);
        $cust->update($data);

        return redirect()->route('customer.index')->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $alat = MasterCustomer::find($id);
        if ($alat) {
            $alat->delete();
            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } else {
            return response()->json(['message' => 'Data    tidak ditemukan'], 404);
        }
    }

    private function GenerateKode()
    {
        $month = date('m');
        $month2 = date('m');
        $romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $month = $romanMonths[$month - 1];
        $year = date('Y');
        $lastKodeAlat = MasterCustomer::whereYear('created_at', $year)->whereMonth('created_at', $month2)->orderby('id', 'desc')->first();
        if ($lastKodeAlat) {
            $lastKodeAlat = (int) substr($lastKodeAlat->KodeCust, 0, 4);
            $KodeAlat = str_pad($lastKodeAlat + 1, 4, '0', STR_PAD_LEFT) . '/CUST-DKH/' . $month . '/' . $year;
        } else {
            $KodeAlat = '0001/CUST-DKH/' . $month . '/' . $year;
        }
        return $KodeAlat;
    }
}
