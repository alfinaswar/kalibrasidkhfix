@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title fw-bold">LK PENGUJIAN DAN KALIBRASI <span
                            class="text-primary text-uppercase">{{ $sertifikat->getNamaAlat->Nama }}</span></h4>
                    <span></span>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('job.store') }}">
                        @csrf
                        <div class="row">
                            <center class="mb-4">
                                <h3 class="fw-bold" style="text-decoration: underline;">
                                    ADMINISTRASI</h3>
                                <span class="text-primary fw-bold">{{ $sertifikat->SertifikatOrder }} /
                                    {{ $sertifikat->NoSertifikat }}</span>
                            </center>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="merk" class="form-label">Merk</label>
                                    <input type="text" class="form-control" id="merk" name="merk"
                                        placeholder="Masukkan Merk">
                                    <input type="hidden" class="form-control" id="merk" name="no_order"
                                        value="{{ $sertifikat->SertifikatOrder }}">
                                </div>
                                <div class="mb-3">
                                    <label for="type_model" class="form-label">Type/ Model</label>
                                    <input type="text" class="form-control" id="type_model" name="type_model"
                                        placeholder="Masukkan Type/ Model">
                                </div>
                                <div class="mb-3">
                                    <label for="nomor_seri" class="form-label">Nomor Seri</label>
                                    <input type="text" class="form-control" id="nomor_seri" name="nomor_seri"
                                        placeholder="Masukkan Nomor Seri">
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_kalibrasi" class="form-label">Tanggal Kalibrasi</label>
                                    <input type="date" class="form-control" id="mdate" name="tanggal_kalibrasi"
                                        placeholder="Masukkan Tanggal Terima">
                                </div>
                                <div class="mb-3">
                                    <label for="instansi_ruangan" class="form-label">Instansi/ Ruangan</label>
                                    <input type="text" class="form-control" id="instansi_ruangan" name="instansi_ruangan"
                                        placeholder="Masukkan Instansi/ Ruangan">
                                </div>
                                <div class="mb-3">
                                    <label for="resolusi" class="form-label">Resolusi (rpm)</label>
                                    <input type="number" class="form-control" id="resolusi" name="resolusi"
                                        placeholder="Masukkan Resolusi">
                                </div>
                                <div class="mb-3">
                                    <label for="nama_kalibrator" class="form-label">Nama Kalibrator</label>
                                    <input type="text" class="form-control" id="nama_kalibrator" name="nama_kalibrator"
                                        placeholder="Masukkan Nama Kalibrator" value="{{ auth()->user()->name }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="metoda_kerja" class="form-label">Metoda Kerja</label>
                                    <textarea class="form-control" id="metoda_kerja" name="metoda_kerja" rows="3" placeholder="Masukkan Metoda Kerja"
                                        onclick="$('#ModalMetoda').modal('show');"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_pemilik" class="form-label">Nama Pemilik</label>
                                    <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik"
                                        placeholder="Masukkan Nama Pemilik"
                                        value="{{ $sertifikat->getCustomer->Kategori }} {{ $sertifikat->getCustomer->Name }}">
                                </div>
                                <div class="mb-3">
                                    <label for="alamat_pemilik" class="form-label">Alamat Pemilik</label>
                                    <input type="text" class="form-control" id="alamat_pemilik" name="alamat_pemilik"
                                        placeholder="Masukkan Alamat Pemilik"
                                        value="{{ $sertifikat->getCustomer->Alamat }}">
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_terima" class="form-label">Tanggal Terima</label>
                                    <input type="date" class="form-control" id="mdate" name="tanggal_terima"
                                        placeholder="Masukkan Tanggal Terima">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <center>
                                <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
                                    DAFTAR ALAT UKUR</h3>
                                <span
                                    class="text-primary fw-bold text-uppercase">{{ $sertifikat->getNamaAlat->Nama }}</span>
                            </center>
                            <table class="table table-striped">
                                <thead class="thead-dark bg-primary text-white">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama Alat</th>
                                        <th scope="col">Merk</th>
                                        <th scope="col">Model/Type</th>
                                        <th scope="col">Nomor Seri</th>
                                        <th scope="col">Tertelusur</th>
                                    </tr>
                                </thead>
                                <tbody style="vertical-align: middle">
                                    @foreach ($getAlatUkur as $key => $NamaAlatUkur)
                                        <tr>
                                            <td>
                                                {{ $key + 1 }}
                                            </td>
                                            <td>
                                                <input type="text" name="nama_alat_ukur[]" class="form-control"
                                                    value="{{ $NamaAlatUkur->Nama }}" required>
                                            </td>
                                            <td>
                                                <input type="text" name="merk_alat_ukur[]" class="form-control"
                                                    value="{{ $NamaAlatUkur->Merk }}" required>
                                            </td>
                                            <td>
                                                <input type="text" name="model_alat_ukur[]" class="form-control"
                                                    value="{{ $NamaAlatUkur->Tipe }}" required>
                                            </td>
                                            <td>
                                                <input type="text" name="nomor_seri_alat_ukur[]" class="form-control"
                                                    value="{{ $NamaAlatUkur->Sn }}" required>
                                            </td>
                                            <td>
                                                <input type="text" name="tertelusur_alat_ukur[]" class="form-control"
                                                    value="{{ $NamaAlatUkur->Tertelusur }}" required>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
                                PENGUKURAN KONDISI LINGKUNGAN</h3>
                            <table class="table table-striped">
                                <thead class="thead-dark bg-primary text-white">
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
                                            <input type="text" class="form-control" value="Temperatur Ruangan (C)"
                                                name="Parameter[]" readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="number" class="form-control" placeholder="Suhu Awal"
                                                        name="KondisiAwal[]" require>
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
                                                    <input type="number" class="form-control" placeholder="Suhu Akhir"
                                                        name="KondisiAkhir[]" require>
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
                                            <input type="text" class="form-control" value="Kelembapan Ruangan(%)"
                                                name="Parameter[]" readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="number" class="form-control"
                                                        placeholder="Kelembapan Awal" name="KondisiAwal[]" require>
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
                                                    <input type="number" class="form-control"
                                                        placeholder="Kelembapan Akhir" name="KondisiAkhir[]" require>
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
                                            <input type="text" class="form-control" value="Tegangan Utama (vAC)"
                                                name="TeganganUtama" readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="number" class="form-control" placeholder="L-N"
                                                        name="val[]">
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
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" placeholder="L-PE"
                                                    name="val[]">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">
                                                        <i class="fas fa-bolt"></i>
                                                    </span>
                                                </div>
                                            </div>

                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" placeholder="N-PE"
                                                    name="val[]">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">
                                                        <i class="fas fa-bolt"></i>
                                                    </span>
                                                </div>
                                            </div>

                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
                                PENGUKURAN FISIK DAN FUNGSI</h3>

                            <table class="table table-striped">
                                <thead class="thead-dark bg-primary text-white">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Parameter</th>
                                        <th scope="col" colspan="2">
                                            <center>Hasil</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody style="vertical-align: middle">
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>
                                            <input type="text" class="form-control" name="ParameterFisikAlat[]"
                                                value="Badan dan Permukaan" readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <select name="Hasil[]" class="form-control">
                                                        <option value=""> --Plih Status-- </option>
                                                        <option value="1"> Baik</option>
                                                        <option value="0"> Tidak Baik</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>
                                            <input type="text" class="form-control" name="ParameterFisikAlat[]"
                                                value="Kotak Kontak Alat" readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <select name="Hasil[]" class="form-control">
                                                        <option value=""> --Plih Status-- </option>
                                                        <option value="1"> Baik</option>
                                                        <option value="0"> Tidak Baik</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>
                                            <input type="text" class="form-control" name="ParameterFisikAlat[]"
                                                value="Kabel catu utama
" readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <select name="Hasil[]" class="form-control">
                                                        <option value=""> --Plih Status-- </option>
                                                        <option value="1"> Baik</option>
                                                        <option value="0"> Tidak Baik</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4</th>
                                        <td>
                                            <input type="text" class="form-control" name="ParameterFisikAlat[]"
                                                value="Skring Pengaman" readonly>
                                        </td>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <select name="Hasil[]" class="form-control">
                                                        <option value=""> --Plih Status-- </option>
                                                        <option value="1"> Baik</option>
                                                        <option value="0"> Tidak Baik</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">5</th>
                                        <td>
                                            <input type="text" class="form-control" name="ParameterFisikAlat[]"
                                                value="Tombol, skalar, dan kontrol" readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <select name="Hasil[]" class="form-control">
                                                        <option value=""> --Plih Status-- </option>
                                                        <option value="1"> Baik</option>
                                                        <option value="0"> Tidak Baik</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">6</th>
                                        <td>
                                            <input type="text" class="form-control" name="ParameterFisikAlat[]"
                                                value="Tampilan dan Indikator" readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <select name="Hasil[]" class="form-control">
                                                        <option value=""> --Plih Status-- </option>
                                                        <option value="1"> Baik</option>
                                                        <option value="0"> Tidak Baik</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
                                PENGUKURAN KESELAMATAN LISTRIK</h3>
                            <table class="table table-striped">
                                <thead class="thead-dark bg-primary text-white">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">#</th>
                                        <th scope="col">#</th>
                                    </tr>
                                </thead>
                                <tbody style="vertical-align: middle">
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>
                                            <strong>Tipe</strong>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <select name="TipeListrik" class="form-control">
                                                        <option value=""> --Plih Tipe-- </option>
                                                        <option value="B"> B</option>
                                                        <option value="BF"> BF</option>
                                                        <option value="CF"> CF</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>
                                            <strong>Kelas</strong>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <select name="Kelas" class="form-control">
                                                        <option value=""> --Plih Tipe-- </option>
                                                        <option value="I"> I</option>
                                                        <option value="II"> II</option>
                                                        <option value="IP"> IP</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <table class="table table-striped">
                                <thead class="thead-dark bg-primary text-white">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Parameter</th>
                                        <th scope="col">Terukur</th>
                                        <th scope="col">Ambang Batas</th>
                                    </tr>
                                </thead>
                                <tbody style="vertical-align: middle">
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>
                                            <input type="text" class="form-control"
                                                value="Tegangan (main voltage) (V)" readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" name="TerukurListrik2[]" class="form-control"
                                                        require
                                                        placeholder="Tegangan (main voltage)
                                                                                        (V)">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>220 V ± 10 %</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>
                                            <input type="text" class="form-control"
                                                value="Resistansi PE (protective earth) Ω" readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" name="TerukurListrik2[]" class="form-control"
                                                        require placeholder="Resistansi PE (protective earth) Ω">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>≤ 0,2 Ω</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>
                                            <input type="text" class="form-control" value="Arus bocor peralatan  µA"
                                                readonly>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" name="TerukurListrik2[]" class="form-control"
                                                        require placeholder="Arus bocor peralatan µA">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>≤ 500 µA</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4</th>
                                        <td>
                                            <input type="text" class="form-control"
                                                value="Arus bocor bagian yang diaplikasikan µA" readonly>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" name="TerukurListrik2[]" class="form-control"
                                                        require
                                                        placeholder="Arus bocor bagian yang diaplikasikan
                                                                                        µA">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>≤ 50 µA</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">5</th>
                                        <td>
                                            <input type="text" class="form-control" value="Resistansi Isolasi"
                                                readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" name="TerukurListrik2[]" class="form-control"
                                                        require placeholder="Resistansi Isolasi">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>> 2 MΩ</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">6</th>
                                        <td>
                                            <input type="text" class="form-control" value="Ampere" readonly>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <input type="text" name="TerukurListrik2[]" class="form-control"
                                                        require placeholder="Ampere">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>Ampere</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
                                PENGUJIAN KINERJA</h3>
                            <div class="text-end mb-3">
                                <a class="btn btn-secondary" onclick="addRow()"><i class="fas fa-plus"></i></a>
                                <a class="btn btn-danger" onclick="deleteRow()"><i class="fas fa-minus"></i></a>
                            </div>
                            <br>
                            <table id="myTable" class="table table-striped"
                                style="vertical-align: mid; text-align:center;">
                                <thead class="thead-dark bg-primary text-white">
                                    <tr>
                                        <th scope="col" style="vertical-align: middle;">Titik Ukur</th>
                                        <th>Running Pertama</th>
                                        <th>Running Kedua</th>
                                        <th>Running Ketiga</th>
                                        <th>Rata-Rata</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="TestingStandart[]"
                                                    placeholder="Standar Testing RPM">

                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-tachometer-alt"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" name="PembacaanAlat1[]" id="PembacaanAlat1"
                                                placeholder="Uji 1" class="form-control" onchange="checkValue(this)">
                                        </td>
                                        <td>
                                            <input type="text" name="PembacaanAlat2[]" id="PembacaanAlat2"
                                                placeholder="Uji 2" class="form-control" onchange="checkValue(this)">
                                        </td>
                                        <td>
                                            <input type="text" name="PembacaanAlat3[]" id="PembacaanAlat3"
                                                placeholder="Uji 3" class="form-control" onchange="checkValue(this)">
                                        </td>
                                        <td>
                                            <input type="text" name="RataRata[]" placeholder="Rata-rata"
                                                class="form-control" id="RataRata">
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <table id="myTable" class="table table-striped"
                                style="vertical-align: mid; text-align:center;">
                                <thead class="thead-dark bg-primary text-white">
                                    <tr class="text-center">
                                        <th scope="col" rowspan="2" style="vertical-align: middle;">Standar Waktu
                                        </th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="TestingStandart[]"
                                                    placeholder="Standar Testing RPM">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-tachometer-alt"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" name="PembacaanAlat1[]" placeholder="Uji 1"
                                                class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="PembacaanAlat2[]" placeholder="Uji 2"
                                                class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="PembacaanAlat3[]" placeholder="Uji 3"
                                                class="form-control">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
                                TELAAH TEKNIS</h3>
                            <table id="myTable" class="table table-striped"
                                style="vertical-align: mid; text-align:center;">
                                <thead class="thead-dark bg-primary text-white">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Indikator</th>
                                        <th class="text-center">Hasil</th>
                                    </tr>
                                </thead>
                                <tbody style="vertical-align: middle">
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>
                                            <span name="ParameterTeknis[]">Fisik dan Fungsi</span>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <select name="HasilTeknis[]" class="form-control">
                                                        <option value=""> --Plih Status-- </option>
                                                        <option value="BAIK"> Baik</option>
                                                        <option value="TIDAKBAIK"> Tidak Baik</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>
                                            <span name="ParameterTeknis[]">Keselamatan Listrik</span>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <select name="HasilTeknis[]" class="form-control">
                                                        <option value=""> --Plih Status-- </option>
                                                        <option value="AMAN"> Aman</option>
                                                        <option value="TIDAKAMAN"> Tidak Aman</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>
                                            <span name="ParameterTeknis[]">Fisik dan Fungsi</span>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <select name="HasilTeknis[]" class="form-control">
                                                        <option value=""> --Plih Status-- </option>
                                                        <option value="PERLUPERBAIKAN"> Perlu Perbaikan </option>
                                                        <option value="DALAMBATASTOLERABSI"> Dalam Batas Toleransi</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4</th>
                                        <td>
                                            <span name="Catatan">Catatan</span>
                                        </td>
                                        </td>
                                        <td>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <textarea name="Catatan" class="form-control" placeholder="Catatan"></textarea>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="idinstrumen" value="{{ $sertifikat->InstrumenId }}">
        <input type="hidden" name="sertifikatid" value="{{ $sertifikat->id }}">
        <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="ModalMetoda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Metoda Kerja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="example" class="display table-striped" width="100%">
                        <thead>
                            <tr>
                                <th width="10%">#</th>
                                <th>Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
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
    <script>
        function addRow() {
            var table = document.getElementById("myTable").getElementsByTagName('tbody')[0];
            var newRow = table.insertRow(table.rows.length);
            var cells = [];
            for (var i = 0; i < 5; i++) {
                cells[i] = newRow.insertCell(i);
                if (i === 0) {
                    cells[i].innerHTML = `
                <div class="input-group">
                    <input type="number" class="form-control" name="TestingStandart[]" placeholder="Standart Testing RPM" value="">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-tachometer-alt"></i>
                        </span>
                    </div>
                </div>`;
                } else if (i < 4) {
                    cells[i].innerHTML = `
                <input type="text" name="PembacaanAlat${i}[]" placeholder="Uji ${i}" class="form-control" onclick="checkValue(this)">
            `;
                } else {
                    cells[i].innerHTML = `
                <input type="text" name="RataRata${i}[]" placeholder="Rata-rata" class="form-control">
            `;
                }
            }
            updateTestingStandart();
        }

        function deleteRow() {
            var table = document.getElementById("myTable").getElementsByTagName('tbody')[0];
            if (table.rows.length > 1) {
                table.deleteRow(table.rows.length - 1);
                updateTestingStandart();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Tidak dapat menghapus baris, tabel harus memiliki setidaknya satu baris.'
                });
            }
        }

        function updateTestingStandart() {
            var rows = document.querySelectorAll('#myTable tbody tr');
            var lastRowIndex = rows.length - 1;
            var lastRowTestingStandartInput = rows[lastRowIndex].querySelector('input[name="TestingStandart[]"]');
            if (lastRowIndex > 0) {
                var prevRowTestingStandartInput = rows[lastRowIndex - 1].querySelector('input[name="TestingStandart[]"]');
                lastRowTestingStandartInput.value = prevRowTestingStandartInput.value;
            }
        }

        function saveMetodaKerja() {
            var modalValue = document.getElementById('modal_metoda_kerja').value;
            document.getElementById('metoda_kerja').value = modalValue;
            $('#ModalMetoda').modal('hide');
        }
        $(document).ready(function() {
            var dataTable = function() {
                var table = $('#example').DataTable({
                    responsive: true,
                    serverSide: true,
                    destroy: true,
                    processing: true,
                    language: {
                        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Memuat...</span> ',
                        paginate: {
                            next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                            previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                        }
                    },
                    columnDefs: [{
                        width: '10%',
                        targets: 0
                    }],
                    ajax: "{{ route('metode.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'Nama',
                            name: 'Nama'
                        },
                    ]
                });

                $('#example tbody').on('click', 'tr', function() {
                    var data = table.row(this).data();
                    $("#metoda_kerja").val(data.Nama);
                    $('#ModalMetoda').modal('hide');
                });
            };
            dataTable();
        });

        function checkValue(input) {
            var row = input.parentNode.parentNode;
            var testingStandartInput = row.querySelector('input[name="TestingStandart[]"]');
            var testingStandartValue = parseFloat(testingStandartInput.value);
            var pembacaanAlatValue = parseFloat(input.value);
            var allowedRange = testingStandartValue * 0.1;
            if (pembacaanAlatValue < (testingStandartValue - allowedRange) || pembacaanAlatValue > (testingStandartValue +
                    allowedRange)) {
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }


        }
    </script>
@endsection
