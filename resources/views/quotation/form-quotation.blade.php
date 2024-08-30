@extends('layouts.app')
@section('content')
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Buat Quotation</h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="{{ route('st.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Nama Customer</label>
                                 <select id="single-select" class="form-control-lg @error('Name') is-invalid @enderror">
                                    <option>Pilih Customer</option>
                                    @foreach ($customer as $cust)
                                    <option value="{{$cust->id}}">{{$cust->Name}}</option>
                                    @endforeach
                                </select>
                                @error('Name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                             <div class="mb-3 col-md-6">
                                <label class="form-label">Status</label>
                                <select name="Status" class="form-control @error('Status') is-invalid @enderror">
                                    <option value="">Pilih Status</option>
                                    <option value="DRAFT">Draft</option>
                                    <option value="DISETUJUI">Disetujui</option>
                                    <option value="DITOLAK">Tidak Disetujui</option>
                                </select>
                                @error('Status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                             <div class="mb-3 col-md-6">
                                <label class="form-label">Tipe Diskon</label>
                                <select name="TipeDiskon" id="" class="form-control @error('TipeDiskon') is-invalid @enderror">
                                    <option value="">Pilih Tipe Diskon</option>
                                    <option value="flat">Flat</option>
                                    <option value="persentase">Persentase</option>
                                </select>
                                @error('TipeDiskon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                            <label class="form-label">Diskon</label>
                               <input type="number" name="Diskon" id="Diskon" class="form-control" placeholder="Besar Diskon" onkeyup="updateDiskon()">
                                @error('Diskon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Perihal</label>
                                <textarea name="Perihal" id="texteditor1" class="form-control" placeholder="Isi Perihal"></textarea>
                            </div>
                             <div class="mb-3 col-md-6">
                                <label class="form-label">Lampiran</label>
                                <textarea name="Lampiran" id="texteditor2" class="form-control"  placeholder="Lampiran"></textarea>
                            </div>
 <div class="mb-3 col-md-6">
                                <label class="form-label">Header</label>
                                <textarea name="Header" id="texteditor3" class="form-control"  placeholder="Header Quotation"></textarea>
                            </div>
                             <div class="mb-3 col-md-6">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="Deskripsi" id="texteditor4" class="form-control"  placeholder="Deskripsi"></textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Tanggal</label>
                                <input type="date"
                                    class="form-control @error('Tanggal') is-invalid @enderror"
                                    placeholder="Tanggal Diterima" name="Tanggal">
                                @error('Tanggal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Tanggal Dilaksanakan</label>
                                <input type="date"
                                    class="form-control @error('DueDate') is-invalid @enderror"
                                    placeholder="Tanggal DueDate" name="DueDate">
                                @error('DueDate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <u>
                                <h3>DETAIL INSTRUMEN</h3>
                            </u>
                        </div>

                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped verticle-middle" id="instrument-table">
                                    <thead>
                                        <tr class="text-center">

                                            <th scope="col">Nama Alat</th>
                                            <th scope="col">Jumlah</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $totalSubTotal = 0;
                                        $totalQty = 0;
                                        $total = 0;
                                        @endphp
                                        @foreach ($GetKajiUlang as $item)
                                        @php
                                        $subTotal = $item->getInstrumen->Tarif * $item->Qty;
                                        $qty = $item->Qty;
                                        $total += $subTotal;
                                        $totalQty += $qty;
                                        $totalSubTotal += $subTotal;

                                        @endphp
                                        <tr>
                                            <td><input type="text" name="InstrumenId[]" class="form-control"
                                                    placeholder="Nama Alat" value="{{$item->getInstrumen->Nama}}"></td>
                                            <td><input type="text" name="Qty[]" class="form-control"
                                                    placeholder="Jumlah Alat" value="{{$item->Qty}}">
                                            </td>
                                            <td><input type="text" name="Harga[]" class="form-control text-end"
                                                    placeholder="Harga" value="Rp. {{ number_format($item->getInstrumen->Tarif, 0, ',', '.') }}">
                                            </td>
                                            <td><input type="text" name="SubTotal[]" class="form-control text-end"
                                                    placeholder="Sub Total" value="Rp. {{ number_format($subTotal, 0, ',', '.') }}"></td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3" class="text-end fw-bold">Sub Total</td>
                                            <td colspan=""><input type="text" class="form-control text-end" id="subtotal" value="Rp. {{ number_format($totalSubTotal, 0, ',', '.') }}"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end fw-bold">Diskon</td>
                                            <td colspan=""><input type="text" class="form-control text-end" id="TotalDiskon"></td>
                                        </tr>
                                         <tr>
                                            <td colspan="3" class="text-end fw-bold">Qty</td>
                                            <td colspan=""><input type="text" class="form-control text-end" name="Qty" readonly value="{{$totalQty}}"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end fw-bold">Total</td>
                                            <td colspan=""><input type="text" class="form-control text-end" id="Total" name="Total" readonly value="Rp. {{ number_format($total, 0, ',', '.') }}"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-md btn-primary btn-block">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
 <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
                            <script>
                                for (let i = 1; i <= 4; i++) {
                                    ClassicEditor
                                        .create( document.querySelector( `#texteditor${i}` ) )
                                        .catch( error => {
                                            console.error( error );
                                        } );
                                }
                                $(document).ready(function () {
                                   $('#Diskon').on('keyup', function() {
                                       let diskon = $(this).val();
                                       $('#TotalDiskon').val(diskon);
                                   });
                                    $('#TotalDiskon').on('keyup', function() {
                                       let diskon1 = $(this).val();
                                       $('#Diskon').val(diskon1);
                                   });
                                });
                            </script>
@endsection
