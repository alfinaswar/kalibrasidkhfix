<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\KajiUlang;
use App\Models\MasterCustomer;
use App\Models\SerahTerima;
use App\Models\SerahTerimaDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class SerahTerimaAlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SerahTerima::with('getCustomer')->orderBy('id', 'Desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnPdf = '<a href="' . route('st.pdf', $row->id) . '" class="btn btn-primary btn-sm" title="Pdf"><i class="fas fa-print"></i></a>';
                    $btnEdit = '<a href="' . route('st.edit', $row->id) . '" class="btn btn-primary btn-sm btn-edit" title="Edit"><i class="fas fa-edit"></i></a>';
                    $btnDelete = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm btn-delete" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
                    $LinkDetail = '<a href="' . route('st.detail', $row->id) . '" title="Detail" class="btn btn-secondary"><i class="fas fa-tags"></i></a>';
                    return $btnEdit . '  ' . $btnDelete . '  ' . $btnPdf . ' ' . $LinkDetail;
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
        return view('serah-terima.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::all();
        $customer = MasterCustomer::where('Status', 'AKTIF')->get();
        $instrumen = Instrumen::where('Status', 'AKTIF')->get();
        return view('serah-terima.form-serah-terima', compact('user', 'instrumen', 'customer'));
    }

    public function detail($id)
    {
        $st = SerahTerima::with([
            'Stdetail' => function ($query) {
                $query->select('*', DB::raw('COUNT(InstrumenId) as total'))->groupBy('InstrumenId');
            }
        ])->where('id', $id)->first();
        // dd($st);
        $user = User::all();
        $customer = MasterCustomer::all();
        $instrumen = Instrumen::all();
        return view('serah-terima.detail', compact('st', 'user', 'customer', 'instrumen'));
    }
    public function CetakStiker($id)
    {
        $data = SerahTerima::with(
            'Stdetail',
            'getCustomer',
            'Stdetail.getNamaAlat'
        )->where('id', $id)->first();
        $viewData = [
            'KodeSt' => $data->KodeSt,
            'data' => $data,
        ];
        // return $viewData;
        // die;

        $pdf = app('dompdf.wrapper')->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('serah-terima.format-stiker', $viewData)->setPaper([0, 0, 161.57, 70.00], 'portrait');

        return $pdf->stream('cetak.pdf');
    }
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'CustomerId' => 'required',
            'TanggalDiterima' => 'required',
            'Status' => 'required',
            'InstrumenId' => 'required|array',
            'InstrumenId.*' => 'required|integer|exists:instrumens,id',
            'Qty' => 'required|array',
            'Qty.*' => 'required|integer|min:0', // Pastikan setiap Qty adalah integer dan minimal 0
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }


        // Proses data setelah validasi
        $data = $request->all();
        $data['KodeSt'] = $this->GenerateKode();
        $data['idUser'] = auth()->user()->id;
        $SerahTerima = SerahTerima::create($data);
        $latestId = SerahTerima::latest()->first()->id ?? 1;

        for ($i = 0; $i < count($request->InstrumenId); $i++) {
            if ($request->Qty[$i] > 0) {
                for ($j = 0; $j < $request->Qty[$i]; $j++) {
                    SerahTerimaDetail::create([
                        'SerahTerimaId' => $latestId,
                        'InstrumenId' => $request->InstrumenId[$i],
                        'Merk' => $request->Merk[$i],
                        'Type' => $request->Type[$i],
                        'SerialNumber' => $request->SerialNumber[$i],
                        'Qty' => 1,
                        'Deskripsi' => $request->Deskripsi[$i],
                        'idUser' => auth()->user()->id,
                    ]);
                }
            } else {
                SerahTerimaDetail::create([
                    'SerahTerimaId' => $latestId,
                    'InstrumenId' => $request->InstrumenId[$i],
                    'Merk' => $request->Merk[$i],
                    'Type' => $request->Type[$i],
                    'SerialNumber' => $request->SerialNumber[$i],
                    'Qty' => $request->Qty[$i],
                    'Deskripsi' => $request->Deskripsi[$i],
                    'idUser' => auth()->user()->id,
                ]);
            }
        }

        return redirect()->route('st.index')->with('success', 'Data Berhasil Disimpan');
    }


    /**
     * Display the specified resource.
     */
    public function GeneratePdf($id)
    {
        $data = SerahTerima::with([
            'Stdetail' => function ($query) {
                $query->select('*', DB::raw('COUNT(InstrumenId) as total'))->groupBy('InstrumenId')->join('instrumens', 'serah_terima_details.InstrumenId', '=', 'instrumens.id');
            },
            'getCustomer'
        ])->where('id', $id)->first();
        $filename = str_replace(['/', '\\'], '_', $data->KodeSt) . '.pdf';
        $viewData = [
            'judul' => 'SERAH TERIMA BARANG',
            'KodeSt' => $data->KodeSt,
            'instrumen' => $data,
        ];
        // dd($viewData);
        $pdf = app('dompdf.wrapper')->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('serah-terima.formatPdf', $viewData);

        return $pdf->stream($filename);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $st = SerahTerima::with([
            'Stdetail' => function ($query) {
                $query->select('*', DB::raw('COUNT(InstrumenId) as total'))->groupBy('InstrumenId');
            }
        ])->where('id', $id)->first();
        // dd($st);
        $user = User::all();
        $customer = MasterCustomer::all();
        $instrumen = Instrumen::all();
        return view('serah-terima.edit', compact('st', 'user', 'customer', 'instrumen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'CustomerId' => 'required',
            'Status' => 'required',
            'TanggalDiterima' => 'required',
        ]);

        $serahTerimaAlat = SerahTerima::find($id);
        $serahTerimaAlat->update($validatedData);
        $serahTerimaAlat->Stdetail()->delete();

        foreach ($request->InstrumenId as $key => $value) {
            $qty = $request->Qty[$key];
            for ($i = 0; $i < $qty; $i++) {
                SerahTerimaDetail::create([
                    'SerahTerimaId' => $serahTerimaAlat->id,
                    'InstrumenId' => $value,
                    'Merk' => $request->Merk[$key],
                    'Type' => $request->Type[$key],
                    'SerialNumber' => $request->SerialNumber[$key],
                    'Qty' => 1,
                    'Deskripsi' => $request->Deskripsi[$key],
                ]);
            }
        }

        return redirect()->route('st.index')->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $st = SerahTerima::find($id);
        if ($st) {
            $st->delete();
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
        $lastKodeAlat = SerahTerima::whereYear('created_at', $year)->whereMonth('created_at', $month2)->orderby('id', 'desc')->first();
        if ($lastKodeAlat) {
            $lastKodeAlat = (int) substr($lastKodeAlat->KodeSt, 0, 4);
            $Kode = str_pad($lastKodeAlat + 1, 4, '0', STR_PAD_LEFT) . '/ST-DKH/' . $month . '/' . $year;
        } else {
            $Kode = '0001/ST-DKH/' . $month . '/' . $year;
        }
        return $Kode;
    }
}
