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
use App\Models\Sertifikat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class PoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = po::with('getCustomer')->orderBy('id', 'Desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = '<a href="' . route('po.edit', $row->id) . '" class="btn btn-primary btn-sm btn-edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btnDelete = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
                    $btnPdf = '<a href="' . route('po.pdf', $row->id) . '" target="_blank" class="btn btn-secondary btn-sm btn-pdf" title="PDF"><i class="fas fa-file-pdf"></i></a>';
                    return $btnEdit . '  ' . $btnDelete . '  ' . $btnPdf;
                })
                ->addColumn('Stat', function ($row) {
                    if ($row->Status == 'AKTIF') {
                        $Stat = '<span class="badge bg-success">AKTIF</span>';
                    } else {
                        $Stat = '<span class="badge bg-warning">TIDAK AKTIF</span>';
                    }

                    return $Stat;
                })
                ->rawColumns(['action', 'Stat'])
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
        $getQuotation = Quotation::with([
            'DetailQuotation' => function ($query) {
                return $query
                    ->GroupBy('InstrumenId')
                    ->select('*', DB::raw('COUNT(InstrumenId) as jumlahAlat'));
            }
        ])
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
        // dd($this->GenerateNoSertifikat(), $this->GenerateSertifikatOrder());
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
                    Sertifikat::create([
                        'NoSertifikat' => $this->GenerateNoSertifikat(),
                        'SertifikatOrder' => $this->GenerateSertifikatOrder(),
                        'PoId' => $getid,
                        'InstrumenId' => $request->InstrumenId[$i],
                        'CustomerId' => $request->CustomerId,
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
                Sertifikat::create([
                    'NoSertifikat' => $this->GenerateNoSertifikat(),
                    'SertifikatOrder' => $this->GenerateSertifikatOrder(),
                    'PoId' => $getid,
                    'InstrumenId' => $request->InstrumenId[$i],
                    'CustomerId' => $request->CustomerId,
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
    public function edit($id)
    {
        $data = po::with([
            'DetailPo' => function ($query) {
                $query->select('*', DB::raw('COUNT(InstrumenId) as total'))->groupBy('InstrumenId');
            }
        ])->where('id', $id)->first();
        // dd($data);
        $user = User::all();
        $customer = MasterCustomer::all();
        $instrumen = Instrumen::all();
        return view('po.edit', compact('data', 'user', 'customer', 'instrumen'));
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
            'DueDate' => 'required',
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

    public function generatePdf($id)
    {
        $data = po::with([
            'DetailPo' => function ($query) {
                return $query
                    ->GroupBy('InstrumenId')
                    ->select('*', DB::raw('COUNT(InstrumenId) as jumlahAlat'));
            },
            'getCustomer',
            'DetailPo.getNamaAlat'
        ])
            ->where('id', $id)
            ->first();
        // dd($data);
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('po.cetak-pdf', compact('data'));
        return $pdf->stream('po.cetak-pdf' . $data->id . '.pdf');
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

    private function GenerateNoSertifikat()
    {
        $month = date('m');
        $year = date('Y');
        $lastKode = Sertifikat::whereYear('created_at', $year)->whereMonth('created_at', $month)->orderby('id', 'desc')->first();
        if ($lastKode) {
            $lastKode = (int) substr($lastKode->NoSertifikat, 9, 4);
            $NoReg = 'DKH' . $year . $month . str_pad($lastKode + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $NoReg = 'DKH' . $year . $month . '0001';
        }
        return $NoReg;
    }

    private function GenerateSertifikatOrder()
    {
        $month = date('m');
        $year = date('Y');
        $lastKode = Sertifikat::whereYear('created_at', $year)->whereMonth('created_at', $month)->orderby('id', 'desc')->first();
        if ($lastKode) {
            $lastKode = (int) substr($lastKode->SertifikatOrder, 9, 4);
            $NoReg = 'REG' . $year . $month . str_pad($lastKode + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $NoReg = 'REG' . $year . $month . '0001';
        }
        return $NoReg;
    }
}
