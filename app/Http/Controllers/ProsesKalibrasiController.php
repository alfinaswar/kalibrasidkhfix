<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProsesKalibrasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function saveData(Request $request) {}

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // dd($data);

        $filePath = storage_path('app\public\file_lk\Centrifuge.xlsx');

        // dd($filePath);

        // LOAD EXCEL
        $spreadsheet = IOFactory::load($filePath);

        // AMBIL SHEET YANG SPESIFIK
        $sheet = $spreadsheet->getSheetByName('LK yg diisi');

        // MASUKAN DATA KE ROW
        $sheet->setCellValue('C9', $data['no_order']);
        $sheet->setCellValue('C10', $data['no_order']);

        // Generate
        $newFileName = 'testtt-' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        $newFilePath = storage_path('app/public/file_lk/' . $newFileName);

        // Simpan Yang Telah Di modifiasi
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);

        return redirect()->back()->with('success', 'Data added to Excel file successfully!');
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
