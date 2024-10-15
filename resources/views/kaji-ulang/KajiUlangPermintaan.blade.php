asd
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Kaji Ulang Permintaan</title>
    <style>
        @page {
            margin: 0cm 0cm;
        }

        body {
            font-family: 'Arial ', sans-serif;
            /* font-size: 12px; */
            margin-top: 4cm;
            margin-bottom: 2.0cm;
            margin-left: 1.5cm;
            margin-right: 1cm;
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
            height: 3.5cm;
            position: absolute;
            bottom: 0;
            padding: 1px 0px;

        }

        /* #tableheader {
            width: 100%;
            line-height: 0.5cm;
        }

        #tableheader th {
            text-align: center;
        }

        #tableheader td {
            text-align: left;
            vertical-align: middle;

        } */

        #tableisi {
            /* width: 100%; */
            line-height: 0.5cm;
            font-size: 10px;
            border-collapse: collapse;
        }

        #tableisi th {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }

        #tableisi td {
            text-align: left;
            vertical-align: middle;
            border: 1px solid black;
            border-collapse: collapse;

        }

        #logo {
            float: left;

        }

        #logo img {
            height: 70px;
        }

        #company {
            /* margin-top: 8px; */
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
        <span style="font-size: 14pt; font-weight: bold;">Kaji Ulang Permintaan,Tender dan Kontrak</span><br>
    </div>
    <div style="margin-top:1cm;">
        <table id="tableheader">
            <tbody>
                <tr>
                    <td style="width: 3cm;">Tanggal </td>
                    <td style="width: 3%;">:</td>
                    <td style="width: auto;">{{ now()->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td>Pukul</td>
                    <td>:</td>
                    <td>{{ now()->format('h:i:s A') }}</td>
                </tr>
                <tr>
                    <td>Nama Instansi</td>
                    <td>:</td>
                    <td>{{ $data->getCustomer->Kategori }} {{ $data->getCustomer->Name }}</td>
                </tr>
            </tbody>
        </table>
        <br />
        <table width="100%" id="tableisi">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Alat</th>
                    <th>Qty</th>
                    <th>Metode 1</th>
                    <th>Metode 2</th>
                    <th>Status</th>
                    <th>Kondisi Alat</th>
                </tr>
            </thead>
            <tbody>
                {{-- {{ dd($data->dataKaji) }} --}}
                @foreach ($data->dataKaji as $key => $kajiulang)
                    <tr>
                        <td style="text-align: center;">1</td>
                        <td>{{ $kajiulang->getInstrumen->Nama }}</td>

                        <td>{{ $kajiulang->Qty }}</td>
                        <td>{{ $kajiulang->getMetode1->Nama }}</td>
                        <td>{{ $kajiulang->getMetode2->Nama }}</td>
                        <td>
                            @if ($kajiulang->Status == 1)
                                DITERIMA
                            @elseif($kajiulang->Status == 2)
                                DITOLAK
                            @elseif($kajiulang->Status == 3)
                                DITERIMA SEBAGIAN
                            @else
                                DISUBKONTRAKKAN
                            @endif
                        </td>
                        <td>{{ $kajiulang->Kondisi }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p>Catatan : </p>
        <br> <br> <br>
        <table width="100%">
            <thead>
                <tr>
                    <td style="line-height: 0.2cm;">
                        Dibuat Oleh,
                    </td>
                    <td style="line-height: 0.2cm;">

                    </td>
                    <td style="line-height: 0.2cm;">
                        Pelanggan,
                    </td>
                </tr>
            </thead>
            <tbody>

                <tr style="line-height: 2cm;">
                    <td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                    </td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                    </td>
                    <td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                    </td>
                </tr>
                <tr style="line-height: 20px;">
                    <td>Nama Lengkap &amp; TTD</td>
                    <td></td>
                    <td>Nama Lengkap &amp; TTD</td>
                </tr>
            </tbody>
        </table>
        <br />


        <footer>
            <p style="font-size: 8px; margin-left: -30; margin-top:50px;">*Pada permintaan pengujian kalibrasi in-situ,
                informasi data
                alat berfungsi di
                dapat dari pelanggan.
                Untuk kepastian alat berfungsi akan di lakukan pemeriksaan fisik dan fungsi saat pengujian
                kalibrasi in-situ dilakukan</p>
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
