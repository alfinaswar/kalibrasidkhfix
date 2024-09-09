
@extends('layouts.app')
@section('content')
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Buat Surat Tugas</h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form action="{{ route('spk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Customer</label>
                                <select name="CustomerId"
                                    class="form-control @error('CustomerId') is-invalid @enderror" style="pointer-events:none;" tabindex="-1" aria-disabled="true">
                                    <option>Pilih Customer</option>
                                    @foreach ($user as $i)
                                        <option value="{{ $i->id }}" @if ($i->id == $po->CustomerId)
                                        selected
                                        @endif>{{ $i->name }}</option>
                                    @endforeach
                                </select>
                                @error('CustomerId')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Tanggal PO</label>
                                <input type="text" name="Tanggal" value="{{ now()->format('Y-m-d') }}"
                                    class="form-control  @error('Tanggal') is-invalid @enderror"
                                    placeholder="{{ $po->Tanggal }}" id="mdate">
                                @error('Tanggal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Ditugaskan Ke</label>
                                <select class="multi-pilih-placeholder select2-hidden-accessible  @error('karyawanId') is-invalid @enderror" name="karyawanId" multiple="" data-select2-id="3" tabindex="-1"  aria-hidden="true">
                                    <option value="">Pilih Petugas (Multiple)</option>
                                    @foreach ($user as $x)
                                           <option value="{{$x->id}}" data-select2-id="{{$x->id}}">{{$x->name}}</option>
                                    @endforeach
                                </select>
                                 @error('karyawanId')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="Deskripsi" id="Deskripsi" class="tinymce" class="@error('karyawanId') is-invalid @enderror" placeholder="Lampiran">Untuk melakukan “Kalibrasi Alat Kesehatan di {{$po->getCustomer->Kategori}} {{$po->getCustomer->Name}} yang beralamat di {{$po->getCustomer->Alamat}}, pada tanggal {{now()->format('d F Y')}} Sampai Dengan {{now()->format('d F Y')}}”

Demikianlah surat tugas ini dibuat untuk dapat dilaksanakan dengan penuh tanggung jawab dan sebagaimana mestinya.
</textarea>
 @error('Deskripsi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>

                        </div>


                </div>
                <input type="hidden" name="PoId" value="{{ $po->id }}">
                <button type="submit" class="btn btn-md btn-primary btn-block">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    </div>



@endsection
