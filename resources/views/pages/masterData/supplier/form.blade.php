@extends('layouts.template.app')
@section('content')
    <div class="pagetitle">
        <h1>Form Supplier</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Data Supplier</a></li>
                <li class="breadcrumb-item active">{{ $data != null ? 'Ubah Data Supplier' : 'Tambah Data Supplier' }}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $data != null ? 'Ubah Data Supplier' : 'Tambah Data Supplier' }}</h5>

                <!-- Form -->
                <form class="row g-3" action="{{ $data ? route('supplier.update', $data->id) : route('supplier.add') }}"
                    method="POST">
                    @csrf
                    <div class="col-md-6">
                        <label class="form-label">Kode</label>
                        <input type="text" class="form-control" name="code" value="{{ $data->code ?? '' }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="name" value="{{ $data->name ?? '' }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Daftar</label>
                        <input type="date" class="form-control" name="register_date"
                            value="{{ $data->register_date ?? '' }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="address" value="{{ $data->address ?? '' }}"
                            required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nomor HP/Telp</label>
                        <input type="text" class="form-control" name="telp" value="{{ $data->telp ?? '' }}" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-outline-primary">Simpan</button>
                        <button type="reset" class="btn btn-outline-secondary">Reset</button>
                        <a href="{{ route('supplier.index') }}" class="btn btn-outline-danger">Batal</a>
                    </div>
                </form>
                <!-- End Form -->
            </div>
        </div>
    </section>
@endsection
