{{-- UJI KEBOCORAN --}}
<div class="row">
    <center>
        <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
            PENGUJIAN KINERJA</h3>
        <span class="text-primary fw-bold text-uppercase">UJI KEBOCORAN</span>
    </center>
    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th width="30%" style="vertical-align: middle; text-align: center;">Penunjujan Alat (mmHg)</th>
                <th width="40%" style="vertical-align: middle; text-align: center;">Penunjukan Standar (mmHg)</th>
                <th width="30%" style="vertical-align: middle; text-align: center;">Toleransi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center; font-weight: bold;">250</td>
                <td><input type="number" class="form-control" name="penunjukan_standar" placeholder="Hasil"></td>
                <td style="text-align: center; font-weight: bold;">&lt; 15 mmHg / Menit</td>
            </tr>
        </tbody>
    </table>
</div>

{{-- UJI LAJU BUANG CEPAT --}}
<div class="row">
    <center>
        <span class="text-primary fw-bold text-uppercase">UJI LAJU BUANG CEPAT</span>
    </center>
    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th width="25%" style="vertical-align: middle; text-align: center;">Penunjujan Alat (mmHg)</th>
                <th width="25%" style="vertical-align: middle; text-align: center;">Tekanan Akhir (mmHg)</th>
                <th width="25%" style="vertical-align: middle; text-align: center;">Waktu Terukur (Detik)</th>
                <th width="25%" style="vertical-align: middle; text-align: center;">Toleransi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center; font-weight: bold;">260</td>
                <td><input type="number" class="form-control" name="tekananAkhir" value="15" readonly></td>
                <td><input type="number" class="form-control" name="waktuTerukur" placeholder="Hasil"></td>
                <td style="text-align: center; font-weight: bold;">&lt;= 10 Detik</td>
            </tr>
        </tbody>
    </table>
</div>

{{-- AKURASI TEKANAN --}}
<div class="row">
    <center>
        <span class="text-primary fw-bold text-uppercase">AKURASI TEKANAN</span>
    </center>
    <table class="table table-striped">
        <thead class="thead-dark bg-primary text-white">
            <tr>
                <th rowspan="2" width="25%" style="vertical-align: middle; text-align: center;">Penunjujan Alat
                    (mmHg)</th>
                <th colspan="6" width="60%" style="vertical-align: middle; text-align: center;">Penunjukan Standar
                    (mmHg)</th>
                <th rowspan="2" width="15%" style="vertical-align: middle; text-align: center;">Penyimpangan yang
                    diijinkan</th>
            </tr>
            <tr>
                <td width="10%" style="vertical-align: middle; text-align: center;">Naik</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">Turun</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">Naik</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">Turun</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">Naik</td>
                <td width="10%" style="vertical-align: middle; text-align: center;">Turun</td>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i <= 250; $i += 50)
                <tr>
                    <td style="text-align: center; font-weight: bold;"><input type="text" class="form-control" name="penunjukan[]" value="{{ $i }}" readonly></td>
                    <td><input type="number" class="form-control" name="standartNaik1[]" placeholder="Hasil"></td>
                    <td><input type="number" class="form-control" name="standartTurun1[]" placeholder="Hasil"></td>
                    <td><input type="number" class="form-control" name="standartNaik2[]" placeholder="Hasil"></td>
                    <td><input type="number" class="form-control" name="standartTurun2[]" placeholder="Hasil"></td>
                    <td><input type="number" class="form-control" name="standartNaik3[]" placeholder="Hasil"></td>
                    <td><input type="number" class="form-control" name="standartTurun3[]" placeholder="Hasil"></td>
                    @if ($i == 0)
                        <td rowspan="6" style="text-align: center; font-weight: bold;">± 3 mmHg</td>
                    @endif
                </tr>
            @endfor
        </tbody>
    </table>
</div>
