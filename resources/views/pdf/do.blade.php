<!DOCTYPE html>
<html>

<head>
    <title>{{ $data->do_number }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        .page-break {
            page-break-after: always;
        }

        .button {
            transition-duration: 0.4s;
        }

        .button:hover {
            background-color: #04AA6D;
            /* Green */
            color: white;
        }

        @page {
            margin: 100px 25px;
        }

        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            background-color: lightblue;
            height: 50px;
        }

        footer {
            position: fixed;
            bottom: 160px;
            left: 0px;
            right: 0px;
            height: 50px;
        }

        p {
            page-break-after: always;
        }

        p:last-child {
            page-break-after: never;
        }
    </style>
</head>

<body>
    <button class="bi bi-print" class="button button-hover" color: white;" href="javascript:void(0);"
        onclick="printPageArea('print')">Print</button>

    <div id="print" class="page-break">
        <footer>
            <div class="mt-4">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">PREPERED BY</th>
                            <th scope="col" class="text-center">APPROVED BY</th>
                            <th scope="col" class="text-center">USER PROJECT</th>
                            <th scope="col" class="text-center">RECEIVED BY</th>
                        </tr>
                    </thead>
                    <tbody style="height: 100px">
                        <tr style="height: 80px">
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
        </footer>
        <div class="row">
            <div class="col-6 p-4 ">
                <img src="{{ asset('img/logo-elnusa.png') }}" width="150" height="50">
            </div>
            <div class="col-6 p-4 text-right">
                <h6>
                    Jl. Mulawarman No.91, Batakan, Kecamatan Balikpapan Selatan, Kota Balikpapan, Kalimantan
                    Timur
                    76116
                </h6>
                <h5>
                    DELIVERY ORDER <br> {{ $data->do_number }}
                </h5>
            </div>
        </div>
        <div class="mt-4">
            <h4 class="text-right">
                </h6>
        </div>
        <div class="row" class="mt-4">
            <div class="col-4">
                <table class="table table-borderless">
                    <tr>
                        <th>
                            <h5>FROM : {{ $data->from }}</h5>
                        </th>
                    </tr>
                    <tr>
                        <td>TO</td>
                        <td>: {{ $data->customer->name }}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>: {{ $data->customer->address }}</td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td>: {{ $data->date }}</td>
                    </tr>
                    <tr>
                        <td>ATTN</td>
                        <td>: {{ $data->attn }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-4">

            </div>
            <div class="col-4">
                <table class="table table-borderless">
                    <tr>
                        <td style="width:200px">VIA</td>
                        <td>: {{ $data->via }}</td>
                    </tr>
                    <tr>
                        <td>Carrier</td>
                        <td>: {{ $data->carrier }}</td>
                    </tr>
                    <tr>
                        <td>REFF</td>
                        <td>: {{ $data->reff }}</td>
                    </tr>
                    <tr>
                        <td>TRUCK NUM</td>
                        <td>: {{ $data->truck_no }}</td>
                    </tr>
                    <tr>
                        <td>DELIVERED BY</td>
                        <td>: {{ $data->delivered_by }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">NO</th>
                        <th scope="col" class="text-center">QTY</th>
                        <th scope="col">UoM</th>
                        <th scope="col">Kode Barang</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Remark</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->detail as $key => $item)
                        <tr>

                            <td class="text-center">{{ $key + 1 }}</td>
                            <td class="text-center">{{ $item->qty }}</td>
                            <td>{{ $item->barang->unit->name }}</td>
                            <td>{{ $item->barang->code }}</td>
                            <td>{{ $item->barang->name }}</td>
                            <td>{{ $item->remarks }}</td>
                        </tr>
                    @endforeach
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
