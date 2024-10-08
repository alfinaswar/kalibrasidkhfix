<div class="row">
    <center>
        <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
            PENGUJIAN KINERJA</h3>
        <span class="text-primary fw-bold text-uppercase">TEKANAN DARAH</span>
    </center>
    <center>
        <table class="table table-striped">
            <thead class="thead-dark bg-primary text-white">
                <tr>
                    <th colspan="3" rowspan="2" style="vertical-align: middle;">Parameter</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center;">No</th>
                    <th colspan="2" style="vertical-align: middle; text-align: center;">Titik&nbsp;&nbsp;&nbsp;Ukur
                    </th>
                    <th colspan="3" style="vertical-align: middle; text-align: center;">Pengulangan</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Toleransi</th>
                </tr>
                <tr>
                    <th colspan="2" style="vertical-align: middle; text-align: center;">(mmHg)</th>
                    <th style="vertical-align: middle; text-align: center;">1</th>
                    <th style="vertical-align: middle; text-align: center;">2</th>
                    <th style="vertical-align: middle; text-align: center;">3</th>
                </tr>
            </thead>
            <tbody>
                @for ($section = 0; $section < 4; $section++)
                    @for ($row = 0; $row < 3; $row++)
                        <tr>
                            @if ($row == 0)
                                <td colspan="3" rowspan="3"
                                    style="vertical-align: middle; font-weight: bold; text-align: center;"
                                    width="10%">Tekanan (mmHg)</td>
                                <td rowspan="3">{{ $section + 1 }}</td>
                                <td><select name="Titik_Ukur_Nama[]" class="form-control">
                                        <option>PILIH TIPE PENGUJIAN</option>
                                        <option value="SYSTOL">SYSTOL</option>
                                        <option value="MAP">MAP</option>
                                        <option value="DIASTOLE">DIASTOLE</option>
                                        <option value="FREE">FREE</option>
                                    </select></td>
                                <td><input type="text" class="form-control" name="Titik_Ukur_Hasil[]"
                                        placeholder="Hasil"></td>
                                <td><input type="text" class="form-control" name="Pengulangan1_Tekanan_Darah[]"
                                        placeholder="Hasil"></td>
                                <td><input type="text" class="form-control" name="Pengulangan2_Tekanan_Darah[]"
                                        placeholder="Hasil"></td>
                                <td><input type="text" class="form-control" name="Pengulangan3_Tekanan_Darah[]"
                                        placeholder="Hasil"></td>
                                <td rowspan="3">± 5&nbsp;&nbsp;&nbsp;mmHg</td>
                            @else
                                <td><select name="Titik_Ukur_Nama[]" class="form-control">
                                        <option>PILIH TIPE PENGUJIAN</option>
                                        <option value="SYSTOL">SYSTOL</option>
                                        <option value="MAP">MAP</option>
                                        <option value="DIASTOLE">DIASTOLE</option>
                                        <option value="FREE">FREE</option>
                                    </select></td>
                                <td><input type="text" class="form-control" name="Titik_Ukur_Hasil[]"
                                        placeholder="Hasil"></td>
                                <td><input type="text" class="form-control" name="Pengulangan1_Tekanan_Darah[]"
                                        placeholder="Hasil"></td>
                                <td><input type="text" class="form-control" name="Pengulangan2_Tekanan_Darah[]"
                                        placeholder="Hasil"></td>
                                <td><input type="text" class="form-control" name="Pengulangan3_Tekanan_Darah[]"
                                        placeholder="Hasil"></td>
                            @endif
                        </tr>
                    @endfor
                @endfor
            </tbody>
        </table>

    </center>
</div>
