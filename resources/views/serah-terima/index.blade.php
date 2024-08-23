@extends('layouts.app')
@section('content')
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Serah Terima Barang</h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="{{ route('st.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Nama Customer</label>
                                <input type="text" name="Nama"
                                    class="form-control @error('Nama') is-invalid @enderror" placeholder="Nama Customer">
                                @error('Nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Tanggal Diterima</label>
                                <input type="text" id="date-format"
                                    class="form-control @error('TanggalTerima') is-invalid @enderror"
                                    placeholder="Tanggal Diterima" name="TanggalTerima">
                                @error('TanggalTerima')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Tanggal Diserahkan</label>
                                <input type="text" id="date-format"
                                    class="form-control @error('TanggalDiserahkan') is-invalid @enderror"
                                    placeholder="Tanggal Diserahkan" name="TanggalDiserahkan">
                                @error('TanggalDiserahkan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <h3>DETAIL INSTRUMEN</h3>
                        </div>
                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-md btn-secondary mb-3" id="add-row">Tambah
                                Baris</button>
                        </div>
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm"
                            id="instrument-table">
                            <thead>
                                <tr>
                                    <th scope="col">Karyawan</th>
                                    <th scope="col">Alat</th>
                                    <th scope="col">Merk</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">SerialNumber</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><select class="form-control default-select dashboard-select-2 h-auto wide"
                                            tabindex="null">
                                            @foreach ($user as $x)
                                                <option value="{{ $x->id }}">{{ $x->name }}</option>
                                            @endforeach
                                        </select></td>
                                    <td><input type="text" name="InstrumenId[]" class="form-control" placeholder="Alat">
                                    </td>
                                    <td><input type="text" name="Merk[]" class="form-control" placeholder="Merk">
                                    </td>
                                    <td><input type="text" name="Type[]" class="form-control" placeholder="Type">
                                    </td>
                                    <td><input type="text" name="SerialNumber[]" class="form-control"
                                            placeholder="Serial Number"></td>
                                    <td><input type="text" name="Qty[]" class="form-control" placeholder="Qty">
                                    </td>
                                    <td><input type="text" name="Deskripsi[]" class="form-control"
                                            placeholder="Deskripsi">
                                    </td>
                                </tr>
                            </tbody>
                        </table>

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
                '<select class="form-control default-select dashboard-select-2 h-auto wide">@foreach ($user as $x)<option value="{{ $x->id }}">{{ $x->name }}</option>@endforeach</select>',
                '<input type="text" name="InstrumenId[]" class="form-control" placeholder="Alat">',
                '<input type="text" name="Merk[]" class="form-control" placeholder="Merk">',
                '<input type="text" name="Type[]" class="form-control" placeholder="Type">',
                '<input type="text" name="SerialNumber[]" class="form-control" placeholder="Serial Number">',
                '<input type="text" name="Qty[]" class="form-control" placeholder="Qty">',
                '<input type="text" name="Deskripsi[]" class="form-control" placeholder="Deskripsi">'
            ];

            cells.forEach(function(cellContent) {
                var cell = newRow.insertCell();
                cell.innerHTML = cellContent;
            });
        });
    </script>
@endsection
