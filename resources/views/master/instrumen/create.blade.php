@extends('layouts.app')
@section('content')
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Instrumen Alat</h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="{{ route('instrumen.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Kategori</label>
                                <select name="Kategori" id=""
                                    class="form-control @error('Kategori') is-invalid @enderror">
                                    <option value="">Pilih Kategori</option>
                                    <option value="ALKES" {{ old('Kategori') == 'ALKES' ? 'selected' : '' }}>Alkes</option>
                                    <option value="INDUSTRI" {{ old('Kategori') == 'INDUSTRI' ? 'selected' : '' }}>Industri
                                    </option>
                                </select>
                                @error('Kategori')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Nama</label>
                                <input type="text" name="Nama"
                                    class="form-control @error('Nama') is-invalid @enderror" value="{{ old('Nama') }}"
                                    id="Nama" onkeyup="NamaInstrumen()">
                                @error('Nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Tarif</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input type="text" name="Tarif"
                                        class="form-control @error('Tarif') is-invalid @enderror" placeholder="Tarif"
                                        onkeyup="this.value=formatRupiah(this.value)" value="{{ old('Tarif') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                    @error('Tarif')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Akreditasi</label>
                                <select name="Akreditasi" class="form-control @error('Akreditasi') is-invalid @enderror">
                                    <option value="">Status Akreditasi</option>
                                    <option value="YA" {{ old('Akreditasi') == 'YA' ? 'selected' : '' }}>YA</option>
                                    <option value="TIDAK" {{ old('Akreditasi') == 'TIDAK' ? 'selected' : '' }}>TIDAK
                                    </option>
                                </select>
                                @error('Akreditasi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Alat Ukur</label>
                                <select
                                    class="multi-select select2-hidden-accessible @error('AlatUkur') is-invalid @enderror"
                                    name="AlatUkur[]" multiple tabindex="-1" aria-hidden="true">
                                    @foreach ($data as $x)
                                        <option value="{{ $x->id }}"
                                            {{ collect(old('AlatUkur'))->contains($x->id) ? 'selected' : '' }}>
                                            {{ $x->Nama }} - {{ $x->Merk }} - {{ $x->Sn }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('AlatUkur')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">File Lembar Kerja</label>
                                <input type="file" name="LK" class="form-control @error('LK') is-invalid @enderror"
                                    placeholder="Lembar Kerja">
                                @error('LK')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Status</label>
                                <select name="Status" id=""
                                    class="form-control @error('Status') is-invalid @enderror">
                                    <option value="">Pilih Status</option>
                                    <option value="AKTIF" {{ old('Status') == 'AKTIF' ? 'selected' : '' }}>Aktif</option>
                                    <option value="TIDAKAKTIF" {{ old('Status') == 'TIDAKAKTIF' ? 'selected' : '' }}>Tidak
                                        Baik</option>
                                </select>
                                @error('Status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Nama Lembar Kerja Sistem</label>
                                <input type="text" name="NamaFile" id="NamaFile"
                                    class="form-control @error('NamaFile') is-invalid @enderror" readonly>
                                <input type="hidden" name="NamaFunction" id="NamaFunction" class="form-control" readonly>
                                @error('NamaFile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <button type="submit" class="btn btn-md btn-primary btn-block">Simpan</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        function NamaInstrumen() {
            var nama = $("#Nama").val().replace(/\s+/g, '-');
            $("#NamaFile").val(nama);
            var NamaFunction = $("#Nama").val().replace(/\s+/g, '');
            $("#NamaFunction").val(NamaFunction);
        }


        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa) + (sisa ? '.' : '') + split[0].substr(sisa).replace(/\D/g, '').replace(
                    /\B(?=(\d{3})+(?!\d))/g, ".");
            return prefix == undefined ? rupiah : (rupiah ? rupiah + prefix : '');
        }
    </script>
@endsection
