@extends('layouts.app')
@section('content')
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Form Customer</h4>
                <button class="btn btn-secondary" onclick="window.history.back();">Back</button>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Kategori</label>
                                <select name="Kategori" id=""
                                    class="form-control @error('Kategori') is-invalid @enderror">
                                    <option value="">Pilih Kategori</option>
                                    <option value="RS" {{ old('Kategori') == 'RS' ? 'selected' : '' }}>Rumah Sakit</option>
                                    <option value="Klinik" {{ old('Kategori') == 'Klinik' ? 'selected' : '' }}>Klinik</option>
                                    <option value="Puskesmas" {{ old('Kategori') == 'Puskesmas' ? 'selected' : '' }}>Puskesmas</option>
                                    <option value="Laboratorium" {{ old('Kategori') == 'Laboratorium' ? 'selected' : '' }}>Laboratorium</option>
                                    <option value="Perusahaan" {{ old('Kategori') == 'Perusahaan' ? 'selected' : '' }}>Perusahaan</option>
                                </select>
                                @error('Kategori')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">No Aspak</label>
                                <input type="text" name="NoAspak"
                                    class="form-control @error('NoAspak') is-invalid @enderror" value="{{ old('NoAspak') }}" placeholder="No Aspak">
                                @error('NoAspak')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Nama</label>
                                <input type="text" name="Nama"
                                    class="form-control @error('Nama') is-invalid @enderror" value="{{ old('Nama') }}" placeholder="Nama">
                                @error('Nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="Email"
                                    class="form-control @error('Email') is-invalid @enderror" value="{{ old('Email') }}" placeholder="Email">
                                @error('Email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Telepon</label>
                                <input type="text" name="Telepon"
                                    class="form-control @error('Telepon') is-invalid @enderror" value="{{ old('Telepon') }}" placeholder="Telepon">
                                @error('Telepon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Alamat</label>
                                <textarea name="Alamat" class="form-control @error('Alamat') is-invalid @enderror" placeholder="Alamat">{{ old('Alamat') }}</textarea>
                                @error('Alamat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="Deskripsi" class="form-control @error('Deskripsi') is-invalid @enderror" placeholder="Deskripsi">{{ old('Deskripsi') }}</textarea>
                                @error('Deskripsi')
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
                                    <option value="TIDAKAKTIF" {{ old('Status') == 'TIDAKAKTIF' ? 'selected' : '' }}>Tidak Aktif</option>
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
