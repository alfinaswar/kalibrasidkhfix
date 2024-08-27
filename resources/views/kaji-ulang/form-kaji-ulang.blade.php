@extends('layouts.app')
@section('content')
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Kaji Ulang Barang</h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="{{ route('ku.store') }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="SerahTerimaId" value="{{$data->id}}">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Nama Customer</label>
                                <input type="text"
                                    class="form-control @error('Nama') is-invalid @enderror" value="{{$data->CustomerId}}" placeholder="Nama Customer" disabled>
                                @error('Nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Status</label>
                                <select class="form-control" disabled>
                                    <option value="">Pilih Status</option>
                                    <option value="Aktif" @selected($data->Status == "Aktif")>Aktif</option>
                                    <option value="Tidak Aktif" @if ($data->Status == "Tidak Aktif")
                                        selected
                                    @endif>Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Tanggal Diterima</label>
                                <input type="text"
                                    class="form-control @error('TanggalDiterima') is-invalid @enderror"
                                    placeholder="Tanggal Diterima" value="{{$data->TanggalDiterima}}" disabled>
                                @error('TanggalDiterima')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Tanggal Diserahkan</label>
                                <input type="text"
                                    class="form-control @error('TanggalDiajukan') is-invalid @enderror"
                                    placeholder="Tanggal Diserahkan" value="{{$data->TanggalDiajukan}}" disabled>
                                @error('TanggalDiajukan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <u>
                                <h3>DETAIL INSTRUMEN       </u><br>{{$data->KodeSt}}</h3>

                        </div>
                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-md btn-secondary mb-3" id="add-row">Tambah
                                Baris</button>
                        </div>
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped verticle-middle" id="instrument-table">
                                    <thead>
                                        <tr class="text-center">

                                            <th scope="col">Instumen</th>
                                            <th scope="col">Metode 1</th>
                                            <th scope="col">Metode 2</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Kondisi</th>
                                            <th scope="col">Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data->Stdetail as $detail )
 <tr>
                                            <td><select class="form-control" tabindex="null" name="InstrumenId[]">
                                                  @foreach ($instrumen as $key => $item)
                                                <option value="{{ $item->id }}"
                                                    @if ($detail->InstrumenId == $item->id) selected @endif>{{ $item->Nama }}
                                                </option>
                                            @endforeach
                                                </select></td>
                                            <td><input type="text" name="Metode1[]" class="form-control"
                                                    placeholder="Metode">
                                            </td>
                                            <td><input type="text" name="Metode2[]" class="form-control"
                                                    placeholder="Type">
                                            </td>
                                            <td><select class="form-control" tabindex="null" name="Status[]">
                                                <option value="1">Diterima</option>
                                                <option value="2">Ditolak</option>
                                                <option value="3">Diterima Sbeagian</option>
                                                </option>

                                                </select></td>
                                            <td><select class="form-control" tabindex="null" name="Kondisi[]">
                                                <option value="">Pilih Kondisi Alat</option>
                                                <option value="1">Berfungsi</option>
                                                <option value="2">Tidak Bergungsi</option>
                                                </option>

                                                </select>
                                            </td>
                                            <td><input type="text" name="Catatan[]" class="form-control"
                                                    placeholder="Catatan">
                                            </td>
                                        </tr>
                                        @endforeach

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

    <script>
        document.getElementById('add-row').addEventListener('click', function() {
            var table = document.getElementById('instrument-table').getElementsByTagName('tbody')[0];
            var newRow = table.insertRow();

            var cells = [
                '<select name="InstrumenId[]" class="default-select form-control" tabindex="true">@foreach ($instrumen as $inst)<option value="{{ $inst->id }}">{{ $inst->Nama }}</option>@endforeach</select>',
                '<select name="Metode1[]" class="default-select form-control" tabindex="true"><option value="val1">val1</option></select></select>',
                '<select name="Metode2[]" class="default-                  select form-control" tabindex="true"><option value="val1">val1</option></select></select>',
                '<select name="Status[]" class="default-select form-control" tabindex="true"><option value="1">Diterima</option><option value="2">Ditolak</option></select></select>',
                '<select name="Kondisi[]" class="default-select form-control" tabindex="true"><option value="1">Berfungsi</option><option value="2">Tidak Berfungsi</option></select></select>',
                '<input type="text" name="Catatan[]" class="form-control" placeholder="Deskripsi">'
            ];

            cells.forEach(function(cellContent) {
                var cell = newRow.insertCell();
                cell.innerHTML = cellContent;
            });
        });
    </script>
@endsection
