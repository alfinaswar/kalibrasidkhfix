asd
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Instruksi Kerja</title>
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

        #tableheader {
            width: 100%;
            line-height: 0.5cm;
        }

        #tableheader th,
        #tableheader td {
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
    @foreach ($data->dataKaji as $key => $item)
        <div class="watermark">
            <img src="{{ asset('assets/images/bgsurat/bgsurat.jpg') }}" alt="" width="100%" height="100%">
        </div>

        <div style="text-align: center;">
            <span style="font-size: 14pt; font-weight: bold;">Instruksi Kerja Laboratorium</span><br>
        </div>
        <div style="margin-top:1cm;">
            <table width="100%" id="tableheader">
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
                        <td>{{ $data->getCustomer->Name }}</td>
                    </tr>
                    <tr>
                        <td>Nama Alat</td>
                        <td>:</td>
                        <td>{{ $item->getInstrumen->Nama }}</td>
                    </tr>
                    <tr>
                        <td>Merk</td>
                        <td>:</td>
                        <td>{{ $data->Stdetail[$key]->Merk }}</td>
                    </tr>
                    <tr>
                        <td>Type</td>
                        <td>:</td>
                        <td>{{ $data->Stdetail[$key]->Type }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Seri</td>
                        <td>:</td>
                        <td>{{ $data->Stdetail[$key]->SerialNumber }}</td>
                    </tr>
                    <tr>
                        <td>Metode </td>
                        <td>:</td>
                        <td>{{ $item->Metode1 }}<br>{{ $item->Metode2 }}</td>
                    </tr>
                    <tr>
                        <td>Parameter</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Catatan</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <br />
            <table width="100%">
                <thead>
                    <tr>
                        <td style="line-height: 0.2cm;">
                            <p>Tanggal:</p>
                            <p>Jam:</p>
                            <p>Penanggung Jawab Teknis,</p>
                        </td>
                        <td style="line-height: 0.2cm;">
                            <p>Tanggal:</p>
                            <p>Jam:</p>
                            <p>Penyelia</p>
                        </td>
                        <td style="line-height: 0.2cm;">
                            <p>Tanggal:</p>
                            <p>Jam:</p>
                            <p>Kalibrator</p>
                        </td>
                    </tr>
                </thead>
                <tbody>

                    <tr style="line-height: 2cm;">
                        <td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                        </td>
                        <td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                        </td>
                        <td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                        </td>
                    </tr>
                    <tr style="line-height: 20px;">
                        <td>Nama Lengkap &amp; TTD</td>
                        <td>Nama Lengkap &amp; TTD</td>
                        <td>Nama Lengkap &amp; TTD</td>
                    </tr>
                </tbody>
            </table>
            <br />
            <table width="100%">
                <thead>
                    <tr>
                        <td style="line-height: 0.2cm;">
                            <p>Tanggal:</p>
                            <p>Jam:</p>
                            <p>Penyelia</p>
                        </td>
                        <td style="line-height: 0.2cm;">
                            <p>Tanggal:</p>
                            <p>Jam:</p>
                            <p>Kalibrator</p>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr style="line-height: 2cm;">
                        <td>
                            <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                        </td>
                        <td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                        </td>


                    </tr>
                    <tr style="line-height: 20px;">
                        <td>Nama Lengkap &amp; TTD</td>
                        <td>Nama Lengkap &amp; TTD</td>

                    </tr>
                </tbody>
            </table>
            <footer>
                <div id="logo">
                    <p style="float:left;">DIGICAL-4021</p>
                </div>
                <div id="company">
                    <p>DigiCal/004/STB-DKH/2022/Rev.01</p>
                </div>
            </footer>
        </div>
    @endforeach

</body>

</html>
