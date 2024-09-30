@extends('layouts.app')
@section('content')
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Detail Instrumen</h4>
                <button class="btn btn-secondary" onclick="window.history.back();">Back</button>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="{{ route('st.cetak-stiker', $st->id) }}" enctype="multipart/form-data">
                        @csrf
                        {{-- @method('PUT') --}}
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Nama Customer</label>
                                <input type="text" value="{{ $st->getCustomer->Name }}" class="form-control" disabled>
                                @error('CustomerId')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Status</label>
                                <input type="text" value="{{ $st->Status }}" class="form-control" disabled>
                                @error('Status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Tanggal Diterima</label>
                                <input type="text" id="date-format"
                                    class="form-control @error('TanggalDiterima') is-invalid @enderror"
                                    placeholder="Tanggal Diterima" name="TanggalDiterima" value="{{ $st->TanggalDiterima }}"
                                    disabled>
                                @error('TanggalDiterima')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Tanggal Diserahkan</label>
                                <input type="text" id="date-format"
                                    class="form-control @error('TanggalDiajukan') is-invalid @enderror"
                                    placeholder="Tanggal Diserahkan" name="TanggalDiajukan"
                                    value="{{ $st->TanggalDiajukan }}" disabled>
                                @error('TanggalDiajukan')
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

                                            <th scope="col">Alat</th>
                                            <th scope="col">Merk</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">SerialNumber</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Deskripsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($st->Stdetail as $item)
                                            <tr>
                                                <td><select class="form-control" tabindex="null" name="InstrumenId[]"
                                                        disabled>
                                                        @foreach ($instrumen as $inst)
                                                            <option value="{{ $inst->id }}"
                                                                @selected($item->InstrumenId == $inst->id)>{{ $inst->Nama }}
                                                            </option>
                                                        @endforeach
                                                    </select></td>
                                                <td><input type="text" name="Merk[]" class="form-control"
                                                        placeholder="Merk" value="{{ $item->Merk }}" disabled>
                                                </td>
                                                <td><input type="text" name="Type[]" value="{{ $item->Type }}"
                                                        class="form-control" placeholder="Type" disabled>
                                                </td>
                                                <td><input type="text" name="SerialNumber[]"
                                                        value="{{ $item->SerialNumber }}" class="form-control"
                                                        placeholder="Serial Number" disabled></td>
                                                <td><input type="number" name="Qty[]" value="{{ $item->total }}"
                                                        class="form-control" placeholder="Qty" disabled>
                                                </td>
                                                <td><input type="text" name="Deskripsi[]" value="{{ $item->Deskripsi }}"
                                                        class="form-control" placeholder="Deskripsi" disabled>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-md btn-primary btn-block">
                            Cetak Stiker
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
