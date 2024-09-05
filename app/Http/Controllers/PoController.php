<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\KajiUlang;
use App\Models\MasterCustomer;
use App\Models\po;
use App\Models\poDetail;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use App\Models\SerahTerima;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = po::orderBy('id', 'Desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = '<a href="' . route('po.edit', $row->id) . '" class="btn btn-primary btn-sm btn-edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btnDelete = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
                    return $btnEdit . '  ' . $btnDelete;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $dataQuotation = Quotation::with('getCustomer')->where('Status', '!=', 'DITOLAK')->latest()->get();
        return view('po.index', compact('dataQuotation'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $getQuotation = Quotation::with(['DetailQuotation' => function ($query) {
            return $query
                ->GroupBy('InstrumenId')
                ->select('*', DB::raw('COUNT(InstrumenId) as jumlahAlat'));
        }])
            ->where('id', $id)
            ->first();
        // dd($getQuotation);
        $customer = MasterCustomer::all();
        $instrumen = Instrumen::all();
        return view('po.form-po', compact('customer', 'getQuotation', 'instrumen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['KodePo'] = $this->GenerateKode();
        $data['QuotationId'] = $request->QuotationId;
        $data['Diskon'] = $request->TotalDiskon;
        $data['Subtotal'] = str_replace('.', '', $request->subtotal);
        $data['Total'] = str_replace('.', '', $request->Total);
        $data['idUser'] = auth()->user()->id;
        po::create($data);
        $getid = po::latest()->first()->id ?? 1;

        for ($i = 0; $i < count($request->InstrumenId); $i++) {
            $harga = str_replace('.', '', $request->Harga[$i]);
            if ($request->Qty[$i] > 1) {
                for ($j = 0; $j < $request->Qty[$i]; $j++) {
                    poDetail::create([
                        'PoId' => $getid,
                        'InstrumenId' => $request->InstrumenId[$i],
                        'Qty' => '1',
                        'Harga' => $harga,
                        'Deskripsi' => '-',
                        'idUser' => auth()->user()->id,
                    ]);
                }
            } else {
                poDetail::create([
                    'PoId' => $getid,
                    'InstrumenId' => $request->InstrumenId[$i],
                    'Qty' => '1',
                    'Harga' => $harga,
                    'Deskripsi' => '-',
                    'idUser' => auth()->user()->id,
                ]);
            }
        }
        return redirect()->back()->with('success', 'Data Berhasil Ditambahkan');

    }

    /**
     * Display the specified resource.
     */
    public function show(po $po)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(po $po)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, po $po)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(po $po)
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
        $lastKode = po::whereYear('created_at', $year)->whereMonth('created_at', $month2)->orderby('id', 'desc')->first();
        if ($lastKode) {
            $lastKode = (int) substr($lastKode->KodePo, 0, 4);
            $Kode = str_pad($lastKode + 1, 4, '0', STR_PAD_LEFT) . '/POK-DKH/' . $month . '/' . $year;
        } else {
            $Kode = '0001/POK-DKH/' . $month . '/' . $year;
        }
        return $Kode;
    }
}
