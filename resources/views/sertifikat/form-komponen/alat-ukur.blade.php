                                               <div class="row">
                                                    <center>
                            <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
                                DAFTAR ALAT UKUR</h3>
                               <span class="text-primary fw-bold text-uppercase">{{ $sertifikat->getNamaAlat->Nama }}</span>
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
{{$key+1}}
                </td>
                <td>
                    <input type="text" name="nama_alat_ukur[]" class="form-control" value="{{$NamaAlatUkur->Nama}}" required>
                </td>
                <td>
                    <input type="text" name="merk_alat_ukur[]" class="form-control" value="{{ $NamaAlatUkur->Merk }}" required>
                </td>
                <td>
                    <input type="text" name="model_alat_ukur[]" class="form-control" value="{{ $NamaAlatUkur->Tipe }}" required>
                </td>
                <td>
                    <input type="text" name="nomor_seri_alat_ukur[]" class="form-control" value="{{ $NamaAlatUkur->Sn }}" required>
                </td>
                <td>
                    <input type="text" name="tertelusur_alat_ukur[]" class="form-control" value="{{ $NamaAlatUkur->Tertelusur }}" required>
                </td>
            </tr>
            @endforeach
                                </tbody>
                            </table>
                        </div>
