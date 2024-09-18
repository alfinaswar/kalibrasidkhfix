<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Serah Terima Barang</title>
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

        .watermark {
            position: fixed;
            bottom: 0px;
            left: 0px;
            top: 0px;
            right: 0px;
            /* width: 21cm;
            height: 29.7cm; */
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

        #tabelitem {
            border-collapse: collapse;
            width: 100%;
        }

        #tabelitem th,
        #tabelitem td {
            border: 1px solid #000000;
            padding: 5px;
            text-align: left;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="watermark">
        <img src="{{ asset('assets/images/bgsurat/bgsurat.jpg') }}" alt="" width="100%" height="100%">
    </div>

    <div style="text-align: center;">
        <span style="font-size: 14pt; font-weight: bold;">{{ $judul }}</span><br>
        <span style="font-size: 12pt; font-weight: bold;">NOMOR : {{ $KodeSt }}</span>
    </div>
    <div style="margin-top:1cm;">
        <span>Nama Instansi : {{ $instrumen->getCustomer->Name }}</span>
        <table id="tabelitem">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Alat</th>
                    <th>Merk</th>
                    <th>Type</th>
                    <th>No Seri</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($instrumen->Stdetail as $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detail->Nama }}</td>
                        <td>{{ $detail->Merk }}</td>
                        <td>{{ $detail->Type }}</td>
                        <td>{{ $detail->SerialNumber }}</td>
                        <td>{{ $detail->total }}</td>
                        <td>{{ $detail->Deskripsi }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table border="0" width="100%">
            <thead>
                <tr>
                    <th>Sebelum Pengujian/Kalirasi</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Diserahkan Oleh,</th>
                    <th>Diterima Oleh</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Tanggal Alat Diterima</td>
                    <td>:</td>
                    <td>{{ $instrumen->TanggalDiterima }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Jam</td>
                    <td>:</td>
                    <td>jam</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td>Nama Lengkap &amp; TTD</td>
                    <td>Nama Lengkap &amp; TTD</td>
                </tr>
            </tbody>
        </table>
        <table border="0" width="100%">
            <thead>
                <tr>
                    <th>Sebelum Pengujian/Kalirasi</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Diserahkan Oleh,</th>
                    <th>Diterima Oleh</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Tanggal Alat Diterima</td>
                    <td>:</td>
                    <td>{{ $instrumen->TanggalDiterima }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Jam</td>
                    <td>:</td>
                    <td>jam</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td>Nama Lengkap &amp; TTD</td>
                    <td>Nama Lengkap &amp; TTD</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
