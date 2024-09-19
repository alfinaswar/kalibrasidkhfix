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
            line-height: 0.7cm;

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

        #pembuka {
            border-collapse: collapse;
            width: 100%;
            padding: 1px;
            vertical-align: middle;
        }

        #pembuka td {
            vertical-align: middle;
        }

        #dituju {
            line-height: 0.5cm;
        }

        #tabelalat {
            border-collapse: collapse;
            width: 100%;
            padding: 1px;
            vertical-align: middle;
        }

        #tabelalat th {
            border: 1px solid #000000;
            text-align: center;
            vertical-align: middle;
        }

        #tabelalat td {
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
    <table width = "100%" id="pembuka">
        <thead>
            <tr>
                <th colspan="3" style="text-align: left;">Pekanbaru, {{ date('d F Y', strtotime($data->Tanggal)) }}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="10%">Nomor</td>
                <td width="1%">:</td>
                <td width="80%">Nomor</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>{!! $data->Lampiran !!}</td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>:</td>
                <td>Kalibrasi Alat</td>
            </tr>
        </tbody>
    </table>

    <div id="dituju">
        <p>Kepada Yth,<br>{{ $data->getCustomer->Kategori }} {{ $data->getCustomer->Name }}<br>di Tempat</p>
    </div>
    <div>
        {!! $data->Header !!}
    </div>
    <div>
        <table id="tabelalat">
            <thead>
                <tr>
                    <th>Nama Alat</th>
                    <th>Jumlah Alat</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalAlat = 0;
                    function penyebut($nilai)
                    {
                        $nilai = abs($nilai);
                        $huruf = [
                            '',
                            'Satu',
                            'Dua',
                            'Tiga',
                            'Empat',
                            'Lima',
                            'Enam',
                            'Tujuh',
                            'Delapan',
                            'Sembilan',
                            'Sepuluh',
                            'sebelas',
                        ];
                        $temp = '';
                        if ($nilai < 12) {
                            $temp = ' ' . $huruf[$nilai];
                        } elseif ($nilai < 20) {
                            $temp = penyebut($nilai - 10) . ' Belas';
                        } elseif ($nilai < 100) {
                            $temp = penyebut($nilai / 10) . ' Puluh' . penyebut($nilai % 10);
                        } elseif ($nilai < 200) {
                            $temp = ' seratus' . penyebut($nilai - 100);
                        } elseif ($nilai < 1000) {
                            $temp = penyebut($nilai / 100) . ' Ratus' . penyebut($nilai % 100);
                        } elseif ($nilai < 2000) {
                            $temp = ' seribu' . penyebut($nilai - 1000);
                        } elseif ($nilai < 1000000) {
                            $temp = penyebut($nilai / 1000) . ' Ribu' . penyebut($nilai % 1000);
                        } elseif ($nilai < 1000000000) {
                            $temp = penyebut($nilai / 1000000) . ' Juta' . penyebut($nilai % 1000000);
                        } elseif ($nilai < 1000000000000) {
                            $temp = penyebut($nilai / 1000000000) . ' Milyar' . penyebut(fmod($nilai, 1000000000));
                        } elseif ($nilai < 1000000000000000) {
                            $temp =
                                penyebut($nilai / 1000000000000) . ' Trilyun' . penyebut(fmod($nilai, 1000000000000));
                        }
                        return $temp;
                    }

                    function terbilang($nilai)
                    {
                        if ($nilai < 0) {
                            $hasil = 'minus ' . trim(penyebut($nilai));
                        } else {
                            $hasil = trim(penyebut($nilai));
                        }
                        return $hasil;
                    }
                @endphp
                @foreach ($data->DetailQuotation as $item)
                    @php
                        $totalAlat += $item->jumlahAlat;
                    @endphp
                    <tr>
                        <td>{{ $item->getNamaAlat->Nama }}</td>
                        <td>{{ $item->jumlahAlat }}</td>
                        <td style="text-align: right;">{{ 'Rp. ' . number_format($item->Harga, 2, ',', '.') }}</td>
                        <td style="text-align: right;">{{ 'Rp. ' . number_format($item->SubTotal, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2"></td>
                    <td style="text-align: right; font-weight: bold;">Sub Total</td>
                    <td style="text-align: right; font-weight: bold;">
                        {{ 'Rp. ' . number_format($data->SubTotal, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td style="text-align: right; font-weight: bold;">Diskon</td>
                    <td style="text-align: right; font-weight: bold;">
                        {{ 'Rp. ' . number_format($data->Diskon, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td style="text-align: right; font-weight: bold;">Qty</td>
                    <td style="text-align: right; font-weight: bold;">{{ $totalAlat }}</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td style="text-align: right; font-weight: bold;">Total</td>
                    <td style="text-align: right; font-weight: bold;">
                        {{ 'Rp. ' . number_format($data->Total, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        <span>Terbilang : {{ terbilang($data->Total) }} rupiah</span>
    </div>
    <div id="deskripsi">
        {!! $data->Deskripsi !!}
    </div>
</body>

</html>
