<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\KajiUlang;
use App\Models\MasterCustomer;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use App\Models\SerahTerima;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PDF;

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
            $data = Quotation::with('getCustomer')->orderBy('id', 'Desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = '<a href="' . route('quotation.edit', $row->id) . '" class="btn btn-primary btn-sm btn-edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btnDelete = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
                    $btnPdf = '<a href="' . route('quotation.pdf', $row->id) . '" target="_blank" class="btn btn-secondary btn-sm btn-pdf" title="PDF"><i class="fas fa-file-pdf"></i></a>';
                    return $btnEdit . '  ' . $btnDelete . '  ' . $btnPdf;
                })
                ->addColumn('HargaQo', function ($row) {
                    $HargaQo = 'Rp ' . number_format($row->Total, 0, ',', '.');
                    return $HargaQo;
                })
                ->rawColumns(['action', 'HargaQo'])
                ->make(true);
        }
        $dataKajiUlang = SerahTerima::with('dataKaji', 'Stdetail', 'getCustomer')->where('Status', 'AKTIF')->latest()->get();
        return view('quotation.index', compact('dataKajiUlang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $data = SerahTerima::with('dataKaji', 'Stdetail')->where('id', $id)->latest()->first();
        // dd($data);
        $GetKajiUlang = KajiUlang::select('*', DB::raw('COUNT(InstrumenId) as Qty'))
            ->with('getInstrumen')
            ->where('SerahTerimaId', $id)
            ->where('Status', '!=', 2)
            ->groupBy('InstrumenId')
            ->get();
        $customer = MasterCustomer::all();
        $instrumen = Instrumen::all();
        return view('quotation.form-quotation', compact('data', 'customer', 'GetKajiUlang', 'instrumen'));
    }

    public function form(string $id) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $date = new DateTime($request->Tanggal);
        $date->modify('+1 month');
        $data['DueDate'] = $date->format('Y-m-d');

        $data['KodeQuotation'] = $this->GenerateKode();
        $data['Diskon'] = str_replace('.', '', $request->TotalDiskon);
        $data['SubTotal'] = str_replace('.', '', $request->subtotal);
        $data['Total'] = str_replace('.', '', $request->Total);
        $data['idUser'] = auth()->user()->id;
        Quotation::create($data);
        $getid = Quotation::latest()->first()->id ?? 1;

        for ($i = 0; $i < count($request->InstrumenId); $i++) {
            $harga = str_replace('.', '', $request->Harga[$i]);
            $subtotal = str_replace('.', '', $request->SubTotal[$i]);
            if ($request->Qty[$i] > 1) {
                for ($j = 0; $j < $request->Qty[$i]; $j++) {
                    QuotationDetail::create([
                        'idQuotation' => $getid,
                        'InstrumenId' => $request->InstrumenId[$i],
                        'Qty' => '1',
                        'Harga' => $harga,
                        'SubTotal' => $subtotal,
                        'Deskripsi' => '-',
                        'idUser' => auth()->user()->id,
                    ]);
                }
            } else {
                QuotationDetail::create([
                    'idQuotation' => $getid,
                    'InstrumenId' => $request->InstrumenId[$i],
                    'Qty' => '1',
                    'Harga' => $harga,
                    'SubTotal' => $subtotal,
                    'Deskripsi' => '-',
                    'idUser' => auth()->user()->id,
                ]);
            }
        }
        return redirect()->route(route: 'quotation.index')->with('success', 'Data Berhasil Disimpan');
    }

    public function generatePdf($id)
    {
        $data = Quotation::with([
            'DetailQuotation' => function ($query) {
                return $query
                    ->GroupBy('InstrumenId')
                    ->select('*', DB::raw('COUNT(InstrumenId) as jumlahAlat'));
            }, 'getCustomer', 'DetailQuotation.getNamaAlat'
        ])
            ->where('id', $id)
            ->first();
        // dd($data);
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('quotation.cetak-pdf', compact('data'));
        return $pdf->stream('quotation.cetak-pdf' . $data->id . '.pdf');
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Quotation::with([
            'DetailQuotation' => function ($query) {
                $query->select('*', DB::raw('COUNT(InstrumenId) as total'))->groupBy('InstrumenId');
            }
        ])->where('id', $id)->first();
        // dd($data);
        $user = User::all();
        $customer = MasterCustomer::all();
        $instrumen = Instrumen::all();
        return view('quotation.edit', compact('data', 'user', 'customer', 'instrumen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'CustomerId' => 'required',
            'Status' => 'required',
            'Perihal' => 'required',
            'Header' => 'required',
            'Deskripsi' => 'required',
            'Tanggal' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        $data['SubTotal'] = str_replace('.', '', $request->subtotal);
        $data['Total'] = str_replace('.', '', $request->Total);

        $Quotation = Quotation::find($id);
        $Quotation->update($data);
        $Quotation->DetailQuotation()->delete();

        foreach ($request->InstrumenId as $key => $value) {
            $harga = str_replace('.', '', $request->Harga[$key]);
            $subtotal = str_replace('.', '', $request->SubTotal[$key]);
            $qty = $request->Qty[$key];
            for ($i = 0; $i < $qty; $i++) {
                QuotationDetail::create([
                    'idQuotation' => $request->id,
                    'InstrumenId' => $value,
                    'Qty' => 1,
                    'Harga' => $harga,
                    'SubTotal' => $subtotal,
                    'Deskripsi' => $request->Deskripsi[$key],
                ]);
            }
        }

        return redirect()->route('quotation.index')->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Quotation::find($id);
        $data->DetailQuotation()->delete();
        if ($data) {
            $data->delete();
            return response()->json(['message' => 'data berhasil dihapus'], 200);
        } else {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }
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
