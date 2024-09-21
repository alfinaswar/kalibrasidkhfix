<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Kalibrasi</title>
    <style>

        @page {
            margin: 0cm 0cm;
        }

        body {
            font-family: 'Arial ', sans-serif;
            font-size: 12px;
            margin-top: 3.7cm;
            margin-bottom: 4.0cm;
            margin-left: 1cm;
            margin-right: 1cm;
            font-size: 14px;

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

        .content {
            margin-bottom: 10px;
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
        }
        small{
            font-size: 8px;
            font-style: italic;
        }
    </style>
</head>

<body>

    <body>
        <div class="watermark">
            <img src="{{ asset('assets/images/bgsurat/bgsurat.jpg') }}" alt="" width="100%" height="100%">
        </div>
        <div class="header">
<img src="" width="800px">
        </div>

        <div class="content">
            <div class="kop-surat">
            </div>
            <center>
                <u>SERTIFIKAT KALIBRASI</u><br>
                CALIBRATION CERTIFICATE</P>
            </center>
            <p>
            <table width="100%"
                style="background-color: #ffffff; filter: alpha(opacity=40); opacity: 0.95;border:1px rgb(255, 166, 0) solid; font-weight:bold;">
                <tr>
                    <td width="25%">
                        <u>No. Order</u><br><small>Order Number</small>
                    </td>
                    <td>
                        : {{ $data->SertifikatOrder }}
                    </td>
                    <td>
                        <u>No. Sertifikat</u><br><small>Certificate Number</small>
                    </td>
                    <td>
                        : {{ $data->NoSertifikat }}
                    </td>
                </tr>

            </table>
            </p>
            <p>
            <table class="table1" width="100%">
                <tr>
                    <td colspan="2">Identitas Pemilik</td>
                </tr>
                <tr>
                    <td width="25%">
                        <u>Nama</u><br><small>Designation</small>
                    <td>
                        : {{ $data->getCustomer->Name }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <u>Alamat</u><br><small>Address</small>
                    </td>
                    <td>
                        : {{ $data->getCustomer->Alamat }}
                    </td>
                </tr>
            </table>
            </p>
            <p>
            <table width="100%">
                <tr>
                    <td width="40%"><u>Nama Alat</u><br><small>Device Name</small></td>
                    <td>: {{ $data->getNamaAlat->Nama }}</td>
                </tr>
                <tr>
                    <td><u>Merek</u><br><small>Brand</small></td>
                    <td>: {{ $data->Merk }}</td>
                </tr>
                <tr>
                    <td><u>Type / Model</u><br><small>Type / Model</small></td>
                    <td>: {{ $data->Type }}</td>
                </tr>
                <tr>
                    <td><u>No Seri</u><br><small>Serial Number</small></td>
                    <td>: {{ $data->SerialNumber }}</td>

                </tr>
                <tr>
                    <td><u>Ruangan</u><br><small>Room</small></td>
                    <td>: {{ $data->Ruangan }}</td>
                </tr>
                <td><u>Penanggung Jawab Ujian</u><br><small>Person in the Charge of the Exam</small></td>
                <td>: - </td>
                </tr>
                <tr>
                    <td><u>Tingkat Ketelitian</u><br><small>Level of Precision</small></td>
                    <td>: 1 RPM</td>
                </tr>
                <tr>
                    <td><u>Hasil Kalibrasi</u><br><small>Calibration Result</small></td>
                    <td>: {{ $data->MetodeId }}</td>
                </tr>


            </table>
            </p>
            <p>
            <table width="100%">
                <tr>
                    <td width="40%">&nbsp;</td>
                    <td><u>Sertifikat ini terdiri dari : - Hal </u><br>
                        <small>This Certificate Consist of</small><br>
                        <u>Diterbitkan Tanggal : 09 Februari 2024</u><br>
                        <small>Published Date</small><br>
                        <center><u>Manajer Umum</u><br><small>General Manager</small></center>
                        <br><br><br><br>
                        <center>dr Gina Adriana,MARS,MHKES, FISQua</center>
                    </td>
                </tr>
            </table>
</body>
</html>
