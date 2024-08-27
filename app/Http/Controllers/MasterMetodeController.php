<?php

namespace App\Http\Controllers;

use App\Models\MasterMetode;
use Illuminate\Http\Request;

class MasterMetodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.metode.cretae');
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
    public function show(MasterMetode $masterMetode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterMetode $masterMetode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterMetode $masterMetode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterMetode $masterMetode)
    {
        //
    }
}
