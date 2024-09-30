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

        footer {
            color: #000;
            width: 100%;
            height: 45px;
            position: absolute;
            bottom: 0;
            padding: 8px 0;
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

        #logo {
            float: left;
            margin-top: 8px;
        }

        #logo img {
            height: 70px;
        }

        #company {
            margin-top: 8px;
            margin-right: 110px;
            float: right;
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
        <br>
        <table>
            <thead>
                <tr>
                    <td colspan="3"><u>Sebelum Pengujian/Kalibrasi</u></td>
                    <td style="text-align: center !important;">Diserahkan Oleh,</td>
                    <td style="text-align: center !important;">Diterima Oleh,</td>
                </tr>
                <tr>
                    <td>Hari/Tgl alat diterima</td>
                    <td style="width: 2%;">:</td>
                    <td>{{ \Carbon\Carbon::parse($instrumen->TanggalDiterima)->format('d M Y') }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Jam</td>
                    <td>:</td>
                    <td>{{ \Carbon\Carbon::parse($instrumen->TanggalDiterima)->format('H:i:s') }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="border-top:0; padding: 0;"></td>
                    <td style="border-top:0; padding: 0;text-align: center !important;">
                        <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                    </td>
                    <td style="border-top:0; padding: 0;text-align: center !important;">
                        <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: center !important;">Nama Lengkap & TTD</td>
                    <td style="text-align: center !important;">Nama Lengkap & TTD</td>
                </tr>
            </thead>
        </table>
        @if ($instrumen->TanggalDiserahkan == null)
        @else
            <table>
                <thead>
                    <tr>
                        <td colspan="3"><u>Setelah Pengujian/Kalibrasi</u></td>
                        <td style="text-align: center !important;">Diserahkan Oleh,</td>
                        <td style="text-align: center !important;">Diterima Oleh,</td>
                    </tr>
                    <tr>
                        <td>Hari/Tgl alat diterima</td>
                        <td style="width: 2%;">:</td>
                        <td><?= date('Y-m-d', strtotime($instrumen->tanggalDiterima)) ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Jam</td>
                        <td>:</td>
                        <td><?= date('H:i:s', strtotime($instrumen->tanggalDiterima)) ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="border-top:0; padding: 0;"></td>
                        <td style="border-top:0; padding: 0;text-align: center !important;">
                            <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                        </td>
                        <td style="border-top:0; padding: 0;text-align: center !important;">
                            <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: center !important;">Nama Lengkap & TTD</td>
                        <td style="text-align: center !important;">Nama Lengkap & TTD</td>
                    </tr>
                </thead>
            </table>
        @endif
        <footer>
            <div id="logo">
                <p style="float:left;">DIGICAL-4021</p>
            </div>
            <div id="company">
                <p>DigiCal/004/STB-DKH/2022/Rev.01</p>
            </div>
        </footer>
    </div>
</body>

</html>
