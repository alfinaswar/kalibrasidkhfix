                                               <div class="row">
                                                    <center>
                            <h3 class="card-title text-center text-black fw-bold" style="text-decoration: underline;">
                                PENGUJIAN KINERJA</h3>
                               <span class="text-primary fw-bold text-uppercase">RESPIRASI</span>
                               </center>
                         <table class="table table-striped">
         <thead class="thead-dark bg-primary text-white">
  <tr>
    <th colspan="2" rowspan="2" width="10%" style="vertical-align: middle;">Parameter</th>
    <th rowspan="2" width="20%"  style="vertical-align: middle; text-align: center;">Titik Ukur</th>
    <th colspan="3"><CENTER>Pengulangan</CENTER></th>
    <th rowspan="2"  style="vertical-align: middle; text-align: center;">Toleransi</th>
  </tr>
  <tr>
    <th><center>1</center></th>
    <th><center>2</center></th>
    <th><center>3</center></th>
  </tr></thead>
<tbody>
  <tr>
    <td colspan="2" rowspan="4" style="text-align: center; font-weight: bold;">BPM</td>
    <td><input type="text" class="form-control" name="Titik_Ukur_Respirasi[]" placeholder="Titik Ukur"></td>
    <td><input type="text" class="form-control" name="Pengulangan1_Respirasi[]" placeholder="Hasil"></td>
    <td><input type="text" class="form-control" name="Pengulangan2_Respirasi[]" placeholder="Hasil"></td>
    <td><input type="text" class="form-control" name="Pengulangan3_Respirasi[]" placeholder="Hasil"></td>
    <td rowspan="4" style="text-align: center; font-weight: bold;" width="10%">±5%</td>
  </tr>
  @for ($i = 0; $i < 3; $i++)
        <tr>
            <td><input type="text" class="form-control" name="Titik_Ukur_Respirasi[]" placeholder="Titik Ukur"></td>
    <td><input type="text" class="form-control" name="Pengulangan1_Respirasi[]" placeholder="Hasil"></td>
    <td><input type="text" class="form-control" name="Pengulangan2_Respirasi[]" placeholder="Hasil"></td>
    <td><input type="text" class="form-control" name="Pengulangan3_Respirasi[]" placeholder="Hasil"></td>
        </tr>
    @endfor
</tbody>
</table>
                        </div>
