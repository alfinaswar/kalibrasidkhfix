<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
</style>


<body>
    @foreach ($data->Stdetail as $item)
        <div class="container">
            <table id="main">
                <thead>
                    <tr>
                        <th><img src="{{ asset('assets/images/avatar/logo-dkh.png') }}" width="40px"></th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Customer</td>
                        <td>:</td>
                        <td>{{ $data->getCustomer->Name }}</td>
                    </tr>
                    <tr>
                        <td>Nama Alat</td>
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
        </div>
    @endforeach
</body>

</html>
