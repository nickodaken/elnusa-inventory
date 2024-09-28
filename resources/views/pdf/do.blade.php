<!DOCTYPE html>
<html>

<head>
    <title>{{ $data->do_number }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .button {
            transition-duration: 0.4s;
        }

        .button:hover {
            background-color: #04AA6D;
            /* Green */
            color: white;
        }
    </style>
</head>

<body>
    <button class="bi bi-print" class="button button-hover" color: white;" href="javascript:void(0);"
        onclick="printPageArea('printableArea')">Print</button>

    <div id="printableArea">
        <div class="row">
            <div class="col-6 p-4 ">
                <img src="{{ asset('img/logo-elnusa.png') }}" width="150" height="50">
            </div>
            <div class="col-6 p-4 text-right">
                <h5> {{ $data->customer->address }}</h5>
            </div>
        </div>
        <div class="mt-4">
            <h4 class="text-center">DELIVERY ORDER <br>{{ $data->do_number }}</h6>
        </div>
        <div class="row" class="mt-4">
            <div class="col-4">
                <table class="table table-borderless">
                    <tr>
                        <th>
                            <h5>FROM</h5>
                        </th>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>:Jl. Mulawarman No.91, Batakan, Kecamatan Balikpapan Selatan, Kota Balikpapan, Kalimantan
                            Timur
                            76116</td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td>: {{ $data->date }}</td>
                    </tr>
                    <tr>
                        <td>ATTN</td>
                        <td>:</td>
                    </tr>
                </table>
            </div>
            <div class="col-4">

            </div>
            <div class="col-4">
                <table class="table table-borderless">
                    <tr>
                        <td style="width:200px">VIA</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>Carrier</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>REFF</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>TRUCK NUM</td>
                        <td>:</td>
                    </tr>
                    <tr>
                        <td>DELIVERED BY</td>
                        <td>:</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <table class="table">
                <thead>
                    <th scope="col">NO</th>
                    <th scope="col" class="text-center">QTY</th>
                    <th scope="col">UoM</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Remark</th>
                </thead>
                <tbody>
                    @foreach ($data->detail as $key => $item)
                        <td>{{ $key + 1 }}</td>
                        <td class="text-center">{{ $item->qty }}</td>
                        <td>{{ $item->barang->unit->name }}</td>
                        <td>{{ $item->barang->name }}</td>
                        <td>{{ $item->remarks }}</td>
                        <td></td>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">PREPERED BY</th>
                        <th scope="col" class="text-center">APPROVED BY</th>
                        <th scope="col" class="text-center">USER PROJECT</th>
                        <th scope="col" class="text-center">RECEIVED BY</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th scope="col" class="text-center">{{ $data->user->name }}</th>
                        <th scope="col" class="text-center"></th>
                        <th scope="col" class="text-center"></th>
                        <th scope="col" class="text-center"></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function printPageArea(areaID) {
            var printContent = document.getElementById(areaID).innerHTML;
            var originalContent = document.body.innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
        }
    </script>
</body>

</html>
