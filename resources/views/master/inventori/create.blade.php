@extends('layouts.app')
@section('content')
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Form Master Inventori</h4>
                <button class="btn btn-secondary" onclick="window.history.back();">Back</button>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="{{ route('inv.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Nama Alat</label>
                                <input type="text" name="Nama"
                                    class="form-control @error('Nama') is-invalid @enderror" placeholder="Nama Alat"
                                    value="{{ old('Nama') }}">
                                @error('Nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Kategori</label>
                                <select class="form-control" id="single-select" name="Kategori">
                                    <option>Pilih Kategori</option>
                                    @foreach ($data as $cat)
                                        <option value="{{ $cat->idKategori }}">{{ $cat->Kategori }}</option>
                                    @endforeach
                                </select>
                                @error('Kategori')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Merk</label>
                                <input type="text" name="Merk"
                                    class="form-control @error('Merk') is-invalid @enderror" placeholder="Merk"
                                    value="{{ old('Merk') }}">
                                @error('Merk')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Type</label>
                                <input type="text" name="Tipe"
                                    class="form-control @error('Tipe') is-invalid @enderror" placeholder="Type"
                                    value="{{ old('Tipe') }}">
                                @error('Tipe')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Serial Number</label>
                                <input type="text" name="Sn" class="form-control @error('Sn') is-invalid @enderror"
                                    placeholder="Serial Number" value="{{ old('Sn') }}">
                                @error('Sn')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Foto</label>
                                <input type="file" name="Foto"
                                    class="form-control @error('Foto') is-invalid @enderror">
                                @error('Foto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Tanggal Pembelian</label>
                                <input type="date" name="BuyDate"
                                    class="form-control @error('BuyDate') is-invalid @enderror"
                                    value="{{ old('BuyDate', now()->format('Y-m-d')) }}" id="mdate">
                                @error('BuyDate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Tanggal Kalibrasi</label>
                                <input type="date" name="KalibrasiDate"
                                    class="form-control @error('KalibrasiDate') is-invalid @enderror"
                                    value="{{ old('TanggalKalibrasi', now()->format('Y-m-d')) }}" id="mdate3">
                                @error('KalibrasiDate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Tanggal Jatuh Tempo</label>
                                <input type="date" name="KalibrasiDueDate"
                                    class="form-control @error('KalibrasiDueDate') is-invalid @enderror"
                                    value="{{ old('KalibrasiDueDate', now()->format('Y-m-d')) }}" id="mdate2">
                                @error('KalibrasiDueDate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Tertelusur</label>
                                <input type="text" name="Tertelusur"
                                    class="form-control @error('Tertelusur') is-invalid @enderror" placeholder="Tertelusur"
                                    value="{{ old('Tertelusur') }}">
                                @error('Tertelusur')
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
                                    <option value="AKTIF">AKTIF</option>
                                    <option value="TIDAK">TIDAK AKTIF</option>
                                </select>
                                @error('Status')
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
@endsection
