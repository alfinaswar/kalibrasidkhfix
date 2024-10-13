<div class="row">
    <center>
        <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
            PENGUJIAN KINERJA</h3>
    </center>
    <table id="myTable" class="table table-striped" style="vertical-align: mid; text-align:center;">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th>No</th>
                <th>Kapasitas 1/2 max</th>
                <th>Z</th>
                <th>M</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < 10; $i++)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><input type="text" class="form-control" name="MassaHalf[]" value="10 Kg" readonly></td>
                    <td><input type="text" class="form-control" name="PengujianZ[]" placeholder="Hasil"></td>
                    <td><input type="text" class="form-control" name="PengujianM[]" placeholder="Hasil"></td>
                </tr>
            @endfor
            <input type="hidden" name="TipePengujian[]" value="KINERJA">
        </tbody>
    </table>
</div>
