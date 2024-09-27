@extends('layouts.template.app')
@section('content')
    <div class="pagetitle">
        <h1>Detail Penyesuaian Stok</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('penyesuaian.stok.index') }}">Data Penyesuaian Stok</a></li>
                <li class="breadcrumb-item active">Detail Data Penyesuaian Stok</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            List Data Penyesuaian Stok
                            <a href="{{ route('penyesuaian.stok.index') }}"
                                class="btn btn-sm btn-outline-secondary m-2">Kembali</a>
                        </h5>
                        <div class="table-responsive">
                            <table id="table" class="table table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Kode Barang</th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col" class="text-center">Stok Awal</th>
                                        <th scope="col" class="text-center">Stok Aktual</th>
                                        <th scope="col">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->detail as $item)
                                        <tr>
                                            <td>{{ $item->barang->code }}</td>
                                            <td>{{ $item->barang->name }}</td>
                                            <td class="text-center">{{ $item->stock_existing }}</td>
                                            <td class="text-center">{{ $item->stock_actual }}</td>
                                            <td>{{ $item->remark }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
