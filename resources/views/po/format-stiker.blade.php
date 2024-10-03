<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Stiker</title>
</head>
<style>
    @page {
        margin: 0px;
        size: auto;
    }

    body {
        margin-top: 1px;
        margin-left: 1px;
        margin-right: 1px;
        font-size: 8pt;
        font-weight: bold;
    }

    .container {
        margin-left: 10;
        margin-right: 10;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        font-style: :bold;
        scale: 100%;
    }

    #main {
        font-size: 7pt;
    }

    #footer {
        font-size: 5pt;
        margin-top: 10px;
    }

    .barcode {
        position: fixed;
        bottom: 10px;
        left: 10px;
        top: 15px;
        right: 0px;
        z-index: -10;
    }
</style>

<body>
    @foreach ($data->DetailPo as $item)
        <div class="container">
            <table id="main" border="0" width="100%">
                <tbody>
                    <tr>
                        <td><img src="{{ asset('assets/images/avatar/logo-dkh.png') }}" width="40px"></td>
                        <td colspan="">:</td>
                        <td colspan="">
                            {{ strlen($data->getCustomer->Name) > 18 ? substr($data->getCustomer->Name, 0, 18) . '...' : $data->getCustomer->Name }}
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="4" style="padding: 0; margin: 0;"></td>
                        <td>:</td>
                        <td>{{ strlen($item->getNamaAlat->Nama) > 18 ? substr($item->getNamaAlat->Nama, 0, 18) . '...' : $item->getNamaAlat->Nama }}
                        </td>
                    </tr>
                    <tr>
                        <td>:</td>
                        <td>{{ $item->getSertifikat->SertifikatOrder }}</td>
                    </tr>
                    <tr>
                        <td>:</td>
                        <td>{{ $item->getSertifikat->NoSertifikat }}</td>
                    </tr>

                </tbody>
            </table>

            <!-- Display the barcode -->
            <div class="barcode">
                <img src="data:image/png;base64,{{ $barcode[$item->id] }}" alt="barcode" width="75px" />
            </div>
        </div>
    @endforeach
</body>

</html>
