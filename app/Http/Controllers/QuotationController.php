<?php

namespace App\Http\Controllers;

use App\Models\KajiUlang;
use App\Models\MasterCustomer;
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
        return view('quotation.form-quotation', compact('data','customer','GetKajiUlang'));
    }
    public function form(string $id){

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
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
}
