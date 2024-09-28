@extends('layouts.template.app')
@section('content')
    <div class="pagetitle">
        <h1>Form Stok Barang Masuk</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('masuk.index') }}">Data Stok Barang Masuk</a></li>
                <li class="breadcrumb-item active">Tambah Data Stok Barang Masuk</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah Data Stok Masuk </h5>
                        <form class="row g-3" action="{{ route('masuk.cart') }}" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <label class="form-label">Barang</label>
                                <select id="product" name="barang_id" class="form-control select2" required>
                                    <option value="" disabled selected>Pilih</option>
                                    @foreach ($datas as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->code }} | {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Nama Barang</label>
                                <select id="name" name="" class="form-control">
                                    <option value="" disabled>Pilih</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Stok</label>
                                <select id="stock" name="" class="form-control">
                                    <option value="" disabled>Pilih</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Jumlah</label>
                                <input type="number" class="form-control" name="qty" value="1" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Nomor PO</label>
                                <input type="text" class="form-control" name="po_number" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Keterangan</label>
                                <input type="text" class="form-control" name="remarks">
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-outline-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">List Data Stok Barang Masuk</h5>
                        <div class="table-responsive">
                            <table id="table" class="table table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Kode Barang</th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Nomor PO</th>
                                        <th scope="col" class="text-center">Stok</th>
                                        <th scope="col" class="text-center">Jumlah</th>
                                        <th scope="col" class="text-center">Stok Aktual</th>
                                        <th scope="col" class="text-center">Keterangan</th>
                                        <th scope="col" class="text-center">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carts as $item)
                                        <tr>
                                            <td>{{ $item->barang->code }}</td>
                                            <td>{{ $item->barang->name }}</td>
                                            <td>{{ $item->po_number }}</td>
                                            <td class="text-center">{{ $item->barang->stock }}</td>
                                            <td class="text-center">{{ $item->qty }}</td>
                                            <td class="text-center">{{ $item->barang->stock + $item->qty }}</td>
                                            <td class="text-center">{{ $item->remarks }}</td>
                                            <td class="text-center">
                                                <form action="{{ route('masuk.cart.delete', $item->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <a href="" class="btn btn-sm btn-outline-info"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#updateCart{{ $item->id }}">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary"
                                                        onclick="return confirm('Are you sure?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @include('pages.stock.stockIn.cart.update')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="row g-3" action="{{ route('masuk.add') }}" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <label class="form-label">Supplier</label>
                                <select name="supplier_id" class="form-control">
                                    <option value="" disabled selected>Pilih</option>
                                    @foreach ($suppliers as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-outline-primary">Simpan</button>
                                <a href="{{ route('barang.index') }}" class="btn btn-outline-danger">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        $('#product').on('change', function(e) {
            console.log(e);

            var id = e.target.value;

            $.get('{{ url('getJson') }}/' + id, function(data) {
                $('#name').empty();
                $.each(data, function(index, dataObj) {
                    $('#name').append('<option value="' + dataObj.name + '" selected>' +
                        dataObj
                        .name +
                        '</option> ');
                });

                $('#stock').empty();
                $.each(data, function(index, dataObj) {
                    $('#stock').append('<option value="' + dataObj.stock + '" selected>' +
                        dataObj
                        .stock +
                        '</option> ');
                });
            });
        });

        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
