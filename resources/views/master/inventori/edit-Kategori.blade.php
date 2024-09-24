@extends('layouts.app')
@section('content')
<div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Form Ubah Kategori Inventori</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form action="{{route('inv.update-kategori',$data->id)}}" method="POST" enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        <div class="row">
                                            <div class="mb-3 col-md-12">
                                                <label class="form-label">Kategori</label>
                                                <input type="text" name="Kategori" class="form-control @error('Kategori') is-invalid @enderror" placeholder="Kategori" value="{{old('Kategori',$data->Kategori)}}">
                                                @error('Kategori')
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
