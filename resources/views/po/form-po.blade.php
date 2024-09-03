@extends('layouts.app')
@section('content')
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Buat Purchase Order</h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="{{ route('po.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Nama Customer</label>
                                <select id="single-select" name="CustomerId"
                                    class="form-control-lg @error('CustomerId') is-invalid @enderror">
                                    <option>Pilih Customer</option>
                                    @foreach ($customer as $cust)
                                        <option value="{{ $cust->id }}"
                                            @if ($cust->id == $getQuotation->CustomerId) Selected @endif>{{ $cust->Name }}</option>
                                    @endforeach
                                </select>
                                @error('CustomerId')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Tanggal PO</label>
                                <input type="text" name="TanggalPo" value="{{ now()->format('Y-m-d') }}"
                                    class="form-control  @error('TanggalPo') is-invalid @enderror"
                                    placeholder="{{ $getQuotation->TanggalPo }}" id="mdate">
                                @error('TanggalPo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center mt-4 fw-bold">
                            <u>
                                <h3>DETAIL INSTRUMEN</h3>
                            </u>
                        </div>
                        <div class="text-end mt-4" style="position: relative;">
                            <button type="button" class="btn btn-md btn-secondary mb-3" id="add-row">Tambah
                                Baris</button>
                        </div>
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped verticle-middle" id="instrument-table">
                                    <thead>
                                        <tr class="text-center">
                                            <th scope="col">Nama Alat</th>
                                            <th scope="col">Jumlah</th>
                                            <th scope="col">Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($getQuotation->DetailQuotation as $key => $item)
                                            <tr>
                                                <td>
                                                    <select class="form-control" tabindex="null" name="InstrumenId[]">
                                                        @foreach ($instrumen as $inst)
                                                            <option
                                                                value="{{ $inst->id }}"@if ($inst->id == $item->InstrumenId) selected @endif>
                                                                {{ $inst->Nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="number" name="Qty[]" class="form-control"
                                                        placeholder="Jumlah Alat" data-id="{{ $key }}" id="Qty{{ $key }}"
                                                        value="{{ $item->jumlahAlat }}">
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp.</span>
                                                        </div>
                                                        <input type="number" name="Harga[]" class="form-control text-end"
                                                            placeholder="Harga" id="Harga{{ $key }}" value="{{ $item->Harga }}">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">.00</span>
                                                        </div>

                                                    </div>

                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp.</span>
                                                        </div>
                                                        <input type="number" name="SubTotalAlat[]"
                                                            id="SubTotalAlat{{ $key }}"
                                                            class="form-control text-end SubTotalAlat"
                                                            placeholder="Sub Total" value="{{ $item->SubTotal }}" readonly>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">.00</span>
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3" class="text-end fw-bold">Sub Total</td>
                                            <td colspan="">

                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp.</span>
                                                    </div>
                                                    <input type="text" readonly name="subtotal"
                                                        class="form-control text-end" id="subtotal">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">.00</span>
                                                    </div>

                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end fw-bold">Diskon</td>
                                            <td colspan="">
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <select name="TipeDiskon" id="TipeDiskon"
                                                            class="form-control @error('TipeDiskon') is-invalid @enderror">
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
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control text-end"
                                                            id="TotalDiskon" name="TotalDiskon"
                                                            placeholder="Nominal Diskon">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end fw-bold">Qty</td>
                                            <td colspan=""><input type="text" class="form-control text-end"
                                                    name="totalQty" id="totalQty" readonly value=""></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end fw-bold">Total</td>


                                            <td colspan="">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp.</span>
                                                    </div>
                                                    <input type="text" class="form-control text-end" id="Total"
                                                        name="Total" readonly value="">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">.00</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- <input type="hidden" name="SerahTerimaId" value="{{ $data->id }}"> --}}
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
                .create(document.querySelector(`#texteditor${i}`))
                .catch(error => {
                    console.error(error);
                });
        }




        $(document).ready(function() {

            //             window.onload = function() {
            //   updateSubtotal();
            // };
            var total = 0;
            var totalQty = 0;
            var totalHarga = 0;
            var qtyInputs = document.querySelectorAll('input[name="Qty[]"]');
            var hargaInputs = document.querySelectorAll('input[name="Harga[]"]');
            var subTotalInputs = document.querySelectorAll('input[name="SubTotalAlat[]"]');

            function updateTotals() {
                total = 0;
                totalQty = 0;
                totalHarga = 0;
                for (let index = 0; index < subTotalInputs.length; index++) {
                    let subTotal = parseInt(subTotalInputs[index].value) || 0;
                    let qty = parseInt(qtyInputs[index].value) || 0;
                    let harga = parseInt(hargaInputs[index].value) || 0;

                    total += subTotal;
                    totalQty += qty;
                    totalHarga += harga * qty;
                }
                // $('#SubTotalAlat').val(totalHarga);
                $('#subtotal').val(total.toLocaleString('id-ID'));
                $('#totalQty').val(totalQty);
            }

            updateTotals();

            $('input[name="Qty[]"]').on('keyup', function() {
                updateTotals();
                var id = $(this).data('id');
                var total = parseInt($("#Qty"+id).val()) * parseInt($("#Harga"+id).val())
                $('#SubTotalAlat'+id).val(total);
            });

            $('input[name="SubTotalAlat[]"]').on('keyup', function() {
                updateTotals();
            });
            $('#Diskon').on('keyup', function() {
                let diskon = $(this).val();
                $('#TotalDiskon').val(diskon);
            });
            $('#TotalDiskon').on('keyup', function() {
                var DiskonTipe = document.getElementById("TipeDiskon").value;
                var SubTotal = document.getElementById("subtotal").value.replace(/[^\d]/g, '');
                let diskon1 = $(this).val();

                $('#Diskon').val(diskon1);
                if (DiskonTipe == "persentase") {
                    var diskonNominal = SubTotal * (diskon1 / 100);
                } else {
                    var diskonNominal = diskon1;
                }
                var totalSetelahDiskon = SubTotal - diskonNominal;
                $('#Total').val(totalSetelahDiskon.toLocaleString('id-ID'));

            });
        });
    </script>
@endsection
