<div class="row">
    <center>
        <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
            PENGUJIAN SKALA NOMINAL</h3>
    </center>
    <table id="myTable" class="table table-striped" style="vertical-align: mid; text-align:center;">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th>No</th>
                <th>Massa</th>
                <th>Z</th>
                <th>M</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 1; $i < 11; $i++)
                <tr>
                    <td>{{ $i }}</td>
                    <td><input type="text" class="form-control" name="MassaHalf[]" value="{{ $i * 2 }} Kg"
                            readonly>
                    </td>
                    <td><input type="text" class="form-control" name="PengujianZ[]" placeholder="Hasil"></td>
                    <td><input type="text" class="form-control" name="PengujianM[]" placeholder="Hasil"></td>
                </tr>
            @endfor
            <input type="hidden" name="TipePengujian[]" value="SKALA">
        </tbody>
    </table>
</div>
