@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">LEMBAR KERJA PENGUJIAN DAN KALIBRASI</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('job.store')}}">
                        @csrf
                        <div class="row">
                             <h3 class="card-title text-center text-primary fw-bold" style="text-decoration: underline;">ADMINISTRASI</h3>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_order" class="form-label">No. Order</label>
                                    <input type="text" class="form-control" id="no_order" name="no_order" placeholder="Masukkan No. Order">
                                </div>
                                <div class="mb-3">
                                    <label for="merk" class="form-label">Merk</label>
                                    <input type="text" class="form-control" id="merk" name="merk" placeholder="Masukkan Merk">
                                </div>
                                <div class="mb-3">
                                    <label for="type_model" class="form-label">Type/ Model</label>
                                    <input type="text" class="form-control" id="type_model" name="type_model" placeholder="Masukkan Type/ Model">
                                </div>
                                <div class="mb-3">
                                    <label for="nomor_seri" class="form-label">Nomor Seri</label>
                                    <input type="text" class="form-control" id="nomor_seri" name="nomor_seri" placeholder="Masukkan Nomor Seri">
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_kalibrasi" class="form-label">Tanggal Kalibrasi</label>
                                    <input type="date" class="form-control" id="tanggal_kalibrasi" name="tanggal_kalibrasi" placeholder="Masukkan Tanggal Kalibrasi">
                                </div>
                                <div class="mb-3">
                                    <label for="instansi_ruangan" class="form-label">Instansi/ Ruangan</label>
                                    <input type="text" class="form-control" id="instansi_ruangan" name="instansi_ruangan" placeholder="Masukkan Instansi/ Ruangan">
                                </div>
                                <div class="mb-3">
                                    <label for="resolusi" class="form-label">Resolusi (rpm)</label>
                                    <input type="number" class="form-control" id="resolusi" name="resolusi" placeholder="Masukkan Resolusi">
                                </div>
                                <div class="mb-3">
                                    <label for="nama_kalibrator" class="form-label">Nama Kalibrator</label>
                                    <input type="text" class="form-control" id="nama_kalibrator" name="nama_kalibrator" placeholder="Masukkan Nama Kalibrator">
                                </div>
                                <div class="mb-3">
                                    <label for="metoda_kerja" class="form-label">Metoda Kerja</label>
                                    <textarea class="form-control" id="metoda_kerja" name="metoda_kerja" rows="3" placeholder="Masukkan Metoda Kerja"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_pemilik" class="form-label">Nama Pemilik</label>
                                    <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik" placeholder="Masukkan Nama Pemilik">
                                </div>
                                <div class="mb-3">
                                    <label for="alamat_pemilik" class="form-label">Alamat Pemilik</label>
                                    <input type="text" class="form-control" id="alamat_pemilik" name="alamat_pemilik" placeholder="Masukkan Alamat Pemilik">
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_terima" class="form-label">Tanggal Terima</label>
                                    <input type="date" class="form-control" id="tanggal_terima" name="tanggal_terima" placeholder="Masukkan Tanggal Terima">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                              <h3 class="card-title text-center text-primary fw-bold" style="text-decoration: underline;">PENGUKURAN KONDISI LINGKUNGAN</h3>
                              <table class="table">
            <thead class="thead-dark">
             <tr>
              <th scope="col">#</th>
              <th scope="col">Parameter</th>
              <th scope="col" colspan="2">
               <center>Terukur</center>
              </th>
             </tr>
            </thead>
            <tbody style="vertical-align: middle">
             <tr>
              <th scope="row">1</th>
              <td>
               <input type="text" class="form-control" value="Temperatur Ruangan (C)" name="Parameter[]" readonly>
              </td>
              <td>
               <div class="form-control-wrap">
                <div class="input-group">
                 <input type="number" class="form-control" placeholder="Suhu Awal" name="KondisiAwal[]" require>
                 <div class="input-group-append">
                  <span class="input-group-text" id="basic-addon2">
                   <i class="fas fa-thermometer-half"></i>
                  </span>
                 </div>
                </div>
               </div>
              </td>
              <td>
               <div class="form-control-wrap">
                <div class="input-group">
                 <input type="number" class="form-control" placeholder="Suhu Akhir" name="KondisiAkhir[]" require>
                 <div class="input-group-append">
                  <span class="input-group-text" id="basic-addon2">
                   <i class="fas fa-thermometer-half"></i>
                  </span>
                 </div>
                </div>
               </div>
              </td>
             </tr>

             <tr>
              <th scope="row">2</th>
              <td>
               <input type="text" class="form-control" value="Kelembapan Ruangan(%)" name="Parameter[]" readonly>
              </td>
              <td>
               <div class="form-control-wrap">
                <div class="input-group">
                 <input type="number" class="form-control" placeholder="Kelembapan Awal" name="KondisiAwal[]" require>
                 <div class="input-group-append">
                  <span class="input-group-text" id="basic-addon2">
                   <i class="fas fa-percentage"></i>
                  </span>
                 </div>
                </div>
               </div>
              </td>
              <td>
               <div class="form-control-wrap">
                <div class="input-group">
                 <input type="number" class="form-control" placeholder="Kelembapan Akhir" name="KondisiAkhir[]" require>
                 <div class="input-group-append">
                  <span class="input-group-text" id="basic-addon2">
                   <i class="fas fa-percentage"></i>
                  </span>
                 </div>
                </div>
               </div>
              </td>
             </tr>
             <tr>
              <th scope="row">3</th>
              <td>
               <input type="text" class="form-control" value="Tegangan Utama (vAC)" name="TeganganUtama" readonly>
              </td>
              <td>
               <div class="form-control-wrap">
                <div class="input-group">
                 <input type="number" class="form-control" placeholder="L-N" name="val[]">
                 <div class="input-group-append">
                  <span class="input-group-text" id="basic-addon2">
                   <i class="fas fa-bolt"></i>
                  </span>
                 </div>
                </div>
               </div>
              </td>
              <td>

              </td>
             </tr>
             <tr>
            <th scope="row"></th>
                <td></td>
                <td>              <div class="input-group">
                 <input type="number" class="form-control" placeholder="L-PE" name="val[]">
                 <div class="input-group-append">
                  <span class="input-group-text" id="basic-addon2">
                   <i class="fas fa-bolt"></i>
                  </span>
                 </div>
                </div>
               </div></td>
                <td></td>
             </tr>
<tr>
            <th scope="row"></th>
                <td></td>
                <td>              <div class="input-group">
                 <input type="number" class="form-control" placeholder="N-PE" name="val[]">
                 <div class="input-group-append">
                  <span class="input-group-text" id="basic-addon2">
                   <i class="fas fa-bolt"></i>
                  </span>
                 </div>
                </div>
               </div></td>
                <td></td>
             </tr>
            </tbody>
           </table>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if (session()->has('success'))
        <script>
            swal.fire({
                title: "{{ __('Success!') }}",
                text: "{!! \Session::get('success') !!}",
                type: "success"
            });
        </script>
    @endif
@endsection
