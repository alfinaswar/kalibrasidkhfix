<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\SerahTerimaAlat;
use App\Models\User;
use Illuminate\Http\Request;

class SerahTerimaAlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        $instrumen = Instrumen::all();
        return view('serah-terima.index', compact('user','instrumen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(SerahTerimaAlat $serahTerimaAlat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SerahTerimaAlat $serahTerimaAlat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SerahTerimaAlat $serahTerimaAlat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SerahTerimaAlat $serahTerimaAlat)
    {
        //
    }
}
