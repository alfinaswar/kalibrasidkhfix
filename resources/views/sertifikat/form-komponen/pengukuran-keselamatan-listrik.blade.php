 <div class="row">
     <h3 class="card-title text-center text-primary fw-bold" style="text-decoration: underline;">
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
                     <input type="text" class="form-control" value="Tegangan (main voltage) (V)" readonly>
                 </td>
                 <td>
                     <div class="form-control-wrap">
                         <div class="input-group">
                             <input type="text" name="TerukurListrik2[]" class="form-control" require
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
                     <input type="text" class="form-control" value="Resistansi PE (protective earth) Ω" readonly>
                 </td>
                 <td>
                     <div class="form-control-wrap">
                         <div class="input-group">
                             <input type="text" name="TerukurListrik2[]" class="form-control" require
                                 placeholder="Resistansi PE (protective earth) Ω">
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
                     <input type="text" class="form-control" value="Arus bocor peralatan  µA" readonly>
                 <td>
                     <div class="form-control-wrap">
                         <div class="input-group">
                             <input type="text" name="TerukurListrik2[]" class="form-control" require
                                 placeholder="Arus bocor peralatan µA">
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
                     <input type="text" class="form-control" value="Arus bocor bagian yang diaplikasikan µA"
                         readonly>
                 <td>
                     <div class="form-control-wrap">
                         <div class="input-group">
                             <input type="text" name="TerukurListrik2[]" class="form-control" require
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
                     <input type="text" class="form-control" value="Resistansi Isolasi" readonly>
                 </td>
                 <td>
                     <div class="form-control-wrap">
                         <div class="input-group">
                             <input type="text" name="TerukurListrik2[]" class="form-control" require
                                 placeholder="Resistansi Isolasi">
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
                             <input type="text" name="TerukurListrik2[]" class="form-control" require
                                 placeholder="Ampere">
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
