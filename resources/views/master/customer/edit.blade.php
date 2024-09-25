@extends('layouts.app')
@section('content')
    <div class="col-xl-12 col-lg-12">
        <div class="card">
           <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Form Instrumen Alat</h4>
                <button class="btn btn-secondary" onclick="window.history.back();">Back</button>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="{{ route('customer.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Kategori</label>
                                <select name="Kategori" id=""
                                    class="form-control @error('Kategori') is-invalid @enderror">
                                    <option value="">Pilih Kategori</option>
                                    <option value="Rumah Sakit" @if ($customer->Kategori == 'Rumah Sakit') selected @endif>Rumah
                                        Sakit</option>
                                    <option value="Klinik" @if ($customer->Kategori == 'Klinik') selected @endif>Klinik</option>
                                    <option value="Puskesmas" @if ($customer->Kategori == 'Puskesmas') selected @endif>Puskesmas
                                    </option>
                                    <option value="Laboratorium" @if ($customer->Kategori == 'Laboratorium') selected @endif>
                                        Laboratorium</option>
                                    <option value="Apotek" @if ($customer->Kategori == 'Apotek') selected @endif>Apotek</option>
                                    <option value="Dokter" @if ($customer->Kategori == 'Dokter') selected @endif>Dokter</option>
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
                                    class="form-control @error('NoAspak') is-invalid @enderror" placeholder="No Aspak"
                                    value="{{ old('NoAspak', $customer->NoAspak) }}">
                                @error('NoAspak')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Nama</label>
                                <input type="text" name="Name"
                                    class="form-control @error('Name') is-invalid @enderror" placeholder="Nama"
                                    value="{{ old('Name', $customer->Name) }}">
                                @error('Name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="Email"
                                    class="form-control @error('Email') is-invalid @enderror" placeholder="Email"
                                    value="{{ old('Email', $customer->Email) }}">
                                @error('Email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Telepon</label>
                                <input type="text" name="Telepon"
                                    class="form-control @error('Telepon') is-invalid @enderror" placeholder="Telepon"
                                    value="{{ old('Telepon', $customer->Telepon) }}">
                                @error('Telepon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Alamat</label>
                                <textarea name="Alamat" class="form-control @error('Alamat') is-invalid @enderror" placeholder="Alamat">{{ old('Alamat', $customer->Alamat) }}</textarea>
                                @error('Alamat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="Deskripsi" class="form-control @error('Deskripsi') is-invalid @enderror" placeholder="Deskripsi">{{ old('Deskripsi', $customer->Deskripsi) }}</textarea>
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
                                    <option value="Aktif"
                                        {{ old('Status', $customer->Status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Tidak Aktif"
                                        {{ old('Status', $customer->Status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak
                                        Baik</option>
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
