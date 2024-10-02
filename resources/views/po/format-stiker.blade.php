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
    .barcode{
            position: fixed;
            bottom: 10px;
            left: 15px;
            top: 0.42cm;
            right: 0px;
            z-index: -10;
    }
</style>

<body>
    @foreach ($data->DetailPo as $item)
        <div class="container">
           <table id="main" border="0" width="100%">
    <thead>
        <tr>
            <th><img src="{{ asset('assets/images/avatar/logo-dkh.png') }}" width="40px"></th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th rowspan="2" style="padding: 0; margin: 0;"></th>
            <td>:</td>
            <td>{{ $data->getCustomer->Name }}</td>
        </tr>
        <tr>
            <td>:</td>
            <td>{{ $item->getNamaAlat->Nama }}</td>
        </tr>
    </tbody>
</table>

            <table width="100%" id="footer">
                <tr>
                    <td style="text-align: left;">DIGICAL-4039</td>
                    <td style="text-align: right;">DigiCal/004/LI-DKH/2022/Rev.0</td>
                </tr>
            </table>
            <!-- Display the barcode -->
            <div class="barcode">
<img src="data:image/png;base64,{{ $barcode[$item->id] }}" alt="barcode" width="65px"/>
            </div>
        </div>
    @endforeach
</body>

</html>
