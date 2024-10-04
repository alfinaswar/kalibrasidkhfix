    <div class="row">
        <h3 class="card-title text-center text-primary fw-bold" style="text-decoration: underline;">
            PENGUJIAN KINERJA</h3>
        <div class="text-end mb-3">
            <a class="btn btn-secondary" onclick="addRow()"><i class="fas fa-plus"></i></a>
            <a class="btn btn-danger" onclick="deleteRow()"><i class="fas fa-minus"></i></a>
        </div>
        <br>
        <table id="myTable" class="table table-striped" style="vertical-align: mid; text-align:center;">
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
                        <input type="text" name="PembacaanAlat1[]" id="PembacaanAlat1" placeholder="Uji 1"
                            class="form-control" onchange="checkValue(this)">
                    </td>
                    <td>
                        <input type="text" name="PembacaanAlat2[]" id="PembacaanAlat2" placeholder="Uji 2"
                            class="form-control" onchange="checkValue(this)">
                    </td>
                    <td>
                        <input type="text" name="PembacaanAlat3[]" id="PembacaanAlat3" placeholder="Uji 3"
                            class="form-control" onchange="checkValue(this)">
                    </td>
                    <td>
                        <input type="text" name="RataRata[]" placeholder="Rata-rata" class="form-control"
                            id="RataRata">
                    </td>
                </tr>

            </tbody>
        </table>
        <table id="myTable" class="table table-striped" style="vertical-align: mid; text-align:center;">
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
                            <input type="number" class="form-control" name="StandarWaktu"
                                placeholder="Standar Testing RPM">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-tachometer-alt"></i>
                                </span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <input type="text" name="Waktu1" placeholder="Uji 1" class="form-control">
                    </td>
                    <td>
                        <input type="text" name="Waktu2" placeholder="Uji 2" class="form-control">
                    </td>
                    <td>
                        <input type="text" name="Waktu3" placeholder="Uji 3" class="form-control">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
