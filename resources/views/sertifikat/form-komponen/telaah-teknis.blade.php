<div class="row">
    <h3 class="card-title text-center text-primary fw-bold" style="text-decoration: underline;">
        TELAAH TEKNIS</h3>
        <span class="text-center">Kosongkan jika tidak ada</span>
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
