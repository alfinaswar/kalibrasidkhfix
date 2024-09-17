<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SertifikatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Sertifikat::with('getCustomer')->orderBy('id', 'Desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnUji = '<a href="' . route('job.kalibrasi', $row->id) . '" class="btn btn-primary   btn-sm btn-edit" title="Edit"><i class="fas fa-file-signature"></i></i></a>';

                    return $btnUji;
                })
                ->addColumn('statsertifikat', function ($row) {
                  if($row->Status == "DRAFT"){
                        $stat = '<span class="badge bg-warning">DRAFT</span>';
                  }else{
                        $stat = '<span class="badge bg-success">TERBIT</span>';
                  }

                    return $stat;
                })
                ->rawColumns(['action','statsertifikat'])
                ->make(true);
        }
        return view('sertifikat.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('sertifikat.create');
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
    public function show(Sertifikat $sertifikat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sertifikat $sertifikat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sertifikat $sertifikat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sertifikat $sertifikat)
    {
        //
    }
}
