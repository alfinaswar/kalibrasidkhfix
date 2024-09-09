<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Surat Tugas</title>
     <style>

        @page {
            margin: 0cm 0cm;
        }

        body {
            font-family: 'Arial ', sans-serif;
            /* font-size: 12px; */
            margin-top: 3.7cm;
            margin-bottom: 4.0cm;
            margin-left: 2.54cm;
            margin-right: 2.54cm;
            font-size: 14px;
            text-align: justify;
            line-height: 0.8cm;

        }
        .header {
            text-align: center;
        }
        .watermark{
          position: fixed;
            bottom: 0px;
            left: 0px;
            top: 0px;
            right: 0px;
            width: 21cm;
            height: 29.7cm;
            z-index: -10;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            margin-top: 20px;
        }


        table {
            width: 100%;
        }
        .gm{
           padding-top: 10px;
        }
         .isi{
           /* padding-top: 10px; */
           /* justify-content: center; */
           text-align: justify;
        }
        .ttd{
           padding-top: 60px;

        }
    </style>
</head>
<body>
        <div class="watermark">
            <img src="{{ asset('assets/images/bgsurat/bgsurat.jpg') }}" alt="" width="100%" height="100%">
        </div>
        <br>
<table style="undefined;table-layout: fixed; width: 100%;"><colgroup>

</colgroup>
<thead>
  <tr>
    <th colspan="3" style="text-align: center; font-size: 14pt;">SURAT TUGAS</th>
  </tr></thead>
<tbody>
  <tr>
    <td colspan="3" style="text-align: center; font-size: 12pt; font-weight: bold; padding-top: 0cm;">NOMOR : {{$SuratTugas->KodeSpk}}</td>
  </tr>
  <tr >
    <td colspan="3" style="padding-top: 25px;">Yang bertanda tangan dibawah ini</td>
  </tr>
  <tr>
    <td width="10%" class="gm"></td>
    <td  width="10%" class="gm">Nama</td>
    <td class="gm">: dr. Gina Adiana, MARS, MHKes, FISQua</td>
  </tr>
  <tr>
    <td></td>
    <td>Jabatan</td>
    <td>: General Manager</td>
  </tr>
  <tr>
    <td colspan="3" class="gm">Mengacu pada purchase Order Nomor <strong>{{$SuratTugas->getNomorPO->KodePo}}</strong> Dengan ini menugaskan</td>
  </tr>
  <tr>
    <td class="gm"></td>
    <td class="gm" style="vertical-align: top;">Nama</td>
    <td class="gm">{!!$SuratTugas->info!!}</td>
  </tr>
  <tr>
    <td colspan="3" class="isi">&nbsp;{!! $SuratTugas->Deskripsi !!}</td>
  </tr>

  <tr>
    <td colspan="3">Pekanbaru, {{ \Carbon\Carbon::parse($SuratTugas->Tanggal)->format('d F Y') }}</td>
  </tr>
  <tr>
    <td class="ttd">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">dr. Gina Adiana, MARS, MHKes, FISQua<br>General Manager</td>
  </tr>
</tbody></table>
</body>
</html>
