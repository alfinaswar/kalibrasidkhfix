@extends('layouts.app')
@section('content')
<div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Form Master Alat</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                  <form action="{{ route('inv.update', $alat->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="mb-3 col-md-6">
            <label class="form-label">Nama Alat</label>
            <input type="text" name="Nama" class="form-control @error('Nama') is-invalid @enderror" placeholder="Nama Alat" value="{{ old('Nama', $alat->Nama) }}">
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
                                        <option value="{{ $cat->id }}"
                                            {{ $alat->Kategori == $cat->id ? 'selected' : '' }}>{{ $cat->Kategori }}
                                        </option>
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
            <input type="text" name="Merk" class="form-control @error('Merk') is-invalid @enderror" placeholder="Merk" value="{{ old('Merk', $alat->Merk) }}">
            @error('Merk')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label class="form-label">Tipe</label>
            <input type="text" name="Tipe" class="form-control @error('Tipe') is-invalid @enderror" placeholder="Tipe" value="{{ old('Tipe', $alat->Tipe) }}">
            @error('Tipe')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label class="form-label">Serial Number</label>
            <input type="text" name="Sn" class="form-control @error('Sn') is-invalid @enderror" placeholder="Serial Number" value="{{ old('Sn', $alat->Sn) }}">
            @error('Sn')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label class="form-label">Foto</label>
            <input type="file" name="Foto" class="form-control @error('Foto') is-invalid @enderror">
            @error('Foto')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            {{-- @if($alat->Foto)
            <img src="{{ Storage::url('public/foto_inventori/' . $alat->Foto) }}" alt="Foto Alat" style="width: 100px;">
            @endif --}}
        </div>

        <div class="mb-3 col-md-6">
            <label class="form-label">Tanggal Pembelian</label>
            <input type="date" name="BuyDate" class="form-control @error('BuyDate') is-invalid @enderror" placeholder="Tanggal Pembelian" value="{{ old('BuyDate', $alat->BuyDate) }}">
            @error('BuyDate')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label class="form-label">Tanggal Kalibrasi</label>
            <input type="date" name="KalibrasiDate" class="form-control @error('KalibrasiDate') is-invalid @enderror" placeholder="Tanggal Kalibrasi" value="{{ old('KalibrasiDate', $alat->KalibrasiDate) }}">
            @error('KalibrasiDate')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label class="form-label">Tanggal Jatuh Tempo</label>
            <input type="date" name="KalibrasiDueDate" class="form-control @error('KalibrasiDueDate') is-invalid @enderror" placeholder="Tanggal Jatuh Tempo" value="{{ old('KalibrasiDueDate', $alat->KalibrasiDueDate) }}">
            @error('KalibrasiDueDate')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label class="form-label">Tertelusur</label>
            <input type="text" name="Tertelusur" class="form-control @error('Tertelusur') is-invalid @enderror" placeholder="Tertelusur" value="{{ old('Tertelusur', $alat->Tertelusur) }}">
            @error('Tertelusur')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label class="form-label">Status</label>
            <select name="Status" class="form-control @error('Status') is-invalid @enderror">
                <option value="">Pilih Status</option>
                <option value="AKTIF" {{ old('Status', $alat->Status) == 'AKTIF' ? 'selected' : '' }}>AKTIF</option>
                <option value="TIDAK" {{ old('Status', $alat->Status) == 'TIDAK' ? 'selected' : '' }}>TIDAK AKTIF</option>
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
