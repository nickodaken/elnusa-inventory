@extends('layouts.template.app')
@section('content')
    <div class="pagetitle">
        <h1>Form Stock Out</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('keluar.index') }}">Stock Out Data</a></li>
                <li class="breadcrumb-item active">Add Stock Out Data</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Product </h5>
                        <form class="row g-3" action="{{ route('keluar.cart') }}" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <label class="form-label">Produck</label>
                                <select id="product" name="barang_id" class="form-control select2" required>
                                    <option value="" disabled selected>Choose</option>
                                    @foreach ($datas as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->code }} | {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Produck</label>
                                <select id="name" name="" class="form-control">
                                    <option value="" disabled>Choose</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Stock</label>
                                <select id="stock" name="" class="form-control">
                                    <option value="" disabled>Choose</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Qty</label>
                                <input type="number" class="form-control" name="qty" value="1" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Remark</label>
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
                        <h5 class="card-title">Stock In</h5>
                        <div class="table-responsive">
                            <table id="table" class="table table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Code Produck</th>
                                        <th scope="col">Produck</th>
                                        <th scope="col">DO No</th>
                                        <th scope="col" class="text-center">Stock</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center">Actual Stock</th>
                                        <th scope="col">Remar</th>
                                        <th scope="col" class="text-center">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carts as $item)
                                        <tr>
                                            <td>{{ $item->barang->code }}</td>
                                            <td>{{ $item->barang->name }}</td>
                                            <td>{{ $item->do_number }}</td>
                                            <td class="text-center">{{ $item->barang->stock }}</td>
                                            <td class="text-center">{{ $item->qty }}</td>
                                            <td class="text-center">{{ $item->barang->stock - $item->qty }}</td>
                                            <td>{{ $item->remarks }}</td>

                                            <td class="text-center">
                                                <form action="{{ route('keluar.cart.delete', $item->id) }}" method="post">
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
                        <form class="row g-3" action="{{ route('keluar.add') }}" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <label class="form-label">DO No</label>
                                <input type="text" class="form-control" name="do_number" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Customer</label>
                                <select name="customer_id" class="form-control" required>
                                    <option value="" disabled selected>Choose</option>
                                    @foreach ($customers as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">ATTN</label>
                                <input type="text" class="form-control" name="attn">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Via</label>
                                <input type="text" class="form-control" name="via">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Carrier</label>
                                <input type="text" class="form-control" name="carrier">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Reff</label>
                                <input type="text" class="form-control" name="reff">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Truck No</label>
                                <input type="text" class="form-control" name="truck_no">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Delivered By</label>
                                <input type="text" class="form-control" name="delivered_by">
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
