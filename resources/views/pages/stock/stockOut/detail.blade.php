@extends('layouts.template.app')
@section('content')
    <div class="pagetitle">
        <h1>Detail {{ $data->bill_no }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('report.index') }}">{{ $data->bill_no }}</a></li>
                <li class="breadcrumb-item active">Detail {{ $data->bill_no }}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            List Barang Keluar
                            <a href="{{ route('keluar.index') }}" class="btn btn-sm btn-outline-secondary m-2">Kembali</a>
                        </h5>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table id="table-in" class="table table table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Nota</th>
                                        <th scope="col">Kode Barang</th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col" class="text-center">Jumlah</th>
                                        <th scope="col">Keterangan</th>
                                        <th scope="col">Dibuat Oleh</th>
                                        <th scope="col">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->detail as $key => $item)
                                        <tr>
                                            <td>{{ $data->bill_no }}</td>
                                            <td>{{ $item->barang->code }}</td>
                                            <td>{{ $item->barang->name }}</td>
                                            <td>{{ $data->customer->name }}</td>
                                            <td class="text-center">{{ $item->qty }}</td>
                                            <td>{{ $item->remarks }}</td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ carbon\Carbon::parse($item->date)->format('d-M-Y') ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- End Table -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
