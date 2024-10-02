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
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PDF;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Picqer\Barcode\BarcodeGeneratorPNG;

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
$btnPdf = '<a href="' . route('po.pdf', $row->id) . '" target="_blank" class="btn btn-info btn-sm btn-pdf" title="PDF"><i class="fas fa-file-pdf"></i></a>'; // Changed to btn-info
$stiker = '<a href="' . route('po.stiker', $row->id) . '" title="Cetak Stiker" target="_blank" class="btn btn-warning btn-sm"><i class="fas fa-tags"></i></a>'; // Changed to btn-warning
                    return $btnEdit . '  ' . $btnDelete . '  ' . $btnPdf.' '.$stiker;
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
        $data['Diskon'] = str_replace('.', '', $request->TotalDiskon);
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

        return redirect()->route('po.index')->with('success', 'Data Berhasil Ditambahkan');
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
            'TanggalPo' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $request->all();
        $data['Diskon'] = str_replace('.', '', $request->TotalDiskon);
        $data['Subtotal'] = str_replace('.', '', $request->subtotal);
        $data['Total'] = str_replace('.', '', $request->Total);

        $Quotation = po::find($id);
        $Quotation->update($data);
        $Quotation->DetailPo()->delete();

        foreach ($request->InstrumenId as $key => $value) {
            $harga = str_replace('.', '', $request->Harga[$key]);
            $subtotal = str_replace('.', '', $request->SubTotal[$key]);
            $qty = $request->Qty[$key];
            for ($i = 0; $i < $qty; $i++) {
                poDetail::create([
                    'PoId' => $request->id,
                    'InstrumenId' => $value,
                    'Qty' => 1,
                    'Harga' => $harga,
                    'idUser' => auth()->user()->id,
                ]);
            }
        }

        return redirect()->route('po.index')->with('success', 'Data Berhasil Diupdate');
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
    public function CetakStiker($id)
    {
        $data = po::with(
            'DetailPo',
            'getCustomer',
            'DetailPo.getNamaAlat'
        )->where('id', $id)->first();
// dd($data->DetailPo);
        // Generate Barcode garis Garis
        // $generator = new BarcodeGeneratorPNG();
        // $barcode = [];
        // foreach ($data->DetailPo as $item) {
        //     $barcode[$item->id] = base64_encode($generator->getBarcode($item->id, $generator::TYPE_CODE_128));
        // }
        //barcode QR
        // Generate QR code
        $writer = new PngWriter();
        $barcode = [];
        foreach ($data->DetailPo as $item) {
            $qrCode = QrCode::create($item->id)
                ->setSize(40)
                ->setMargin(0);
            $barcode[$item->id] = base64_encode($writer->write($qrCode)->getString());
        }
        $viewData = [
            'KodePo' => $data->KodePo,
            'data' => $data,
            'barcode' => $barcode, // Add barcode to view data
        ];

        $pdf = app('dompdf.wrapper')->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('po.format-stiker', $viewData)->setPaper([0, 0, 161.57, 70.00], 'portrait');

        return $pdf->stream('stiker.pdf');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = po::find($id);
        $data->DetailPo()->delete();
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
