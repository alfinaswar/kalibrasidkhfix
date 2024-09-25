@extends('layouts.app')
@section('content')
<div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Edit Master Metode</h4>
                                <button class="btn btn-secondary" onclick="window.history.back();">Back</button>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{route('metode.update',$data->id)}}" method="POST" enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        <div class="row">
                                            <div class="mb-3 col-md-12">
                                                <label class="form-label">Nama Metode</label>
                                                <input type="text" name="Nama" class="form-control @error('Nama') is-invalid @enderror" placeholder="Nama Metode" value="{{old('Nama',$data->Nama)}}">
                                                @error('Nama')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-md btn-primary btn-block">Tambah</button>
                                    </form>
                                </div>

                            </div>
                        </div>
					</div>

@endsection
