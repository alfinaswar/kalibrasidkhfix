<div class="row">
    <h3 class="card-title text-center text-primary fw-bold" style="text-decoration: underline;">
        TELAAH TEKNIS</h3>
    <div class="alert alert-danger alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
            stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
        <strong>Warning!</strong> Kosongkan Jika Tidak Ada.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
        </button>
    </div>
    <table id="myTable" class="table table-striped" style="vertical-align: mid; text-align:center;">
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
                    <span name="ParameterTeknis[]">Kinerja</span>
                </td>
                <td>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <select name="HasilTeknis[]" class="form-control">
                                <option value=""> --Plih Status-- </option>
                                <option value="PERLUPERBAIKAN"> Perlu Perbaikan </option>
                                <option value="DALAMBATASTOLERANSI"> Dalam Batas Toleransi</option>
                            </select>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">3</th>
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
