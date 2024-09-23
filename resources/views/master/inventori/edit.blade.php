@extends('layouts.app')
@section('content')
<div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Form Master Alat</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{route('alat.update',$alat->id)}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Nama Alat</label>
                                                <input type="text" name="NamaAlat" class="form-control @error('NamaAlat') is-invalid @enderror" placeholder="Nama Alat" value="{{ old('NamaAlat', $alat->NamaAlat) }}">
                                                @error('NamaAlat')
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
                                                <label class="form-label">Type</label>
                                                <input type="text" name="Type" class="form-control @error('Type') is-invalid @enderror" placeholder="Type" value="{{ old('Type', $alat->Type) }}">
                                                @error('Type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Serial Number</label>
                                                <input type="text" name="SerialNumber" class="form-control @error('SerialNumber') is-invalid @enderror" placeholder="Serial Number" value="{{ old('SerialNumber', $alat->SerialNumber) }}">
                                                @error('SerialNumber')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Foto</label>
                                                <input type="file" name="Foto" class="form-control @error('Foto') is-invalid @enderror" placeholder="Foto">
                                                @error('Foto')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
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
                                                <input type="date" name="TanggalKalibrasi" class="form-control @error('TanggalKalibrasi') is-invalid @enderror" placeholder="Tanggal Kalibrasi" value="{{ old('TanggalKalibrasi', $alat->TanggalKalibrasi) }}">
                                                @error('TanggalKalibrasi')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Tanggal Jatuh Tempo</label>
                                                <input type="date" name="DueDate" class="form-control @error('DueDate') is-invalid @enderror" placeholder="Tanggal Jatuh Tempo" value="{{ old('DueDate', $alat->DueDate) }}">
                                                @error('DueDate')
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
                                                <select name="Status" id="" class="form-control @error('Status') is-invalid @enderror">
                                                    <option value="">Pilih Status</option>
                                                    <option value="Baik" {{ old('Status', $alat->Status) == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                    <option value="Tidak Baik" {{ old('Status', $alat->Status) == 'Tidak Baik' ? 'selected' : '' }}>Tidak Baik</option>
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
