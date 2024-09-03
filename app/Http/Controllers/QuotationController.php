<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\KajiUlang;
use App\Models\MasterCustomer;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use App\Models\SerahTerima;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class QuotationController extends Controller
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
                ->rawColumns(['action'])
                ->make(true);
        }
        $dataKajiUlang = SerahTerima::with('dataKaji','Stdetail')->latest()->get();
        return view('quotation.index', compact('dataKajiUlang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $data = SerahTerima::with('dataKaji', 'Stdetail')->where('id',$id)->latest()->first();
        $GetKajiUlang = KajiUlang::select('*', DB::raw('COUNT(InstrumenId) as Qty'))
                        ->with('getInstrumen')
                        ->where('SerahTerimaId',$id)
                        ->where('Status', '!=', 2)
                        ->groupBy('InstrumenId')
                        ->get();
        $customer = MasterCustomer::all();
        $instrumen = Instrumen::all();
        return view('quotation.form-quotation', compact('data','customer','GetKajiUlang','instrumen'));
    }
    public function form(string $id){

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['KodeQuotation'] = $this->GenerateKode();
        $data['Diskon'] = $request->TotalDiskon;
        $data['SubTotal'] = str_replace(".", "", $request->subtotal);
        $data['Total'] = str_replace(".", "", $request->Total);
        $data['idUser'] = auth()->user()->id;
        Quotation::create($data);
        $getid = Quotation::latest()->first()->id ?? 1;

        for ($i = 0; $i < count($request->InstrumenId); $i++) {
            $harga = str_replace(".", "", $request->Harga[$i]);
            $subtotal = str_replace(".", "", $request->SubTotal[$i]);
            if ($request->Qty[$i] > 1) {
                for ($j = 0; $j < $request->Qty[$i]; $j++) {
                    QuotationDetail::create([
                        'idQuotation' => $getid,
                        'InstrumenId' => $request->InstrumenId[$i],
                        'Qty' => "1",
                        'Harga' => $request->Harga[$i],
                        'SubTotal' => $request->SubTotal[$i],
                        'Deskripsi' => '-',
                        'idUser' => auth()->user()->id,
                    ]);
                }
            } else {
                QuotationDetail::create([
                    'idQuotation' => $getid,
                    'InstrumenId' => $request->InstrumenId[$i],
                    'Qty' => "1",
                    'Harga' => $harga,
                    'SubTotal' => $subtotal,
                    'Deskripsi' => '-',
                    'idUser' => auth()->user()->id,
                ]);
            }

        }


    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
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
        $lastKode = Quotation::whereYear('created_at', $year)->whereMonth('created_at', $month2)->orderby('id', 'desc')->first();
        if ($lastKode) {
            $lastKode = (int) substr($lastKode->KodeQuotation, 0, 4);
            $Kode = str_pad($lastKode + 1, 4, '0', STR_PAD_LEFT) . '/PNW-DKH/' . $month . '/' . $year;
        } else {
            $Kode = '0001/PNW-DKH/' . $month . '/' . $year;
        }
        return $Kode;
    }
}
