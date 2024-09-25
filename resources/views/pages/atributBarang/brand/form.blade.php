@extends('layouts.template.app')
@section('content')
    <div class="pagetitle">
        <h1>Form Merek</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('merek.index') }}">Data Merek</a></li>
                <li class="breadcrumb-item active">{{ $data != null ? 'Ubah Data Merek' : 'Tambah Data Merek' }}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $data != null ? 'Ubah Data Merek' : 'Tambah Data Merek' }}</h5>

                <!-- Form -->
                <form class="row g-3" action="{{ $data ? route('merek.update', $data->id) : route('merek.add') }}"
                    method="POST">
                    @csrf
                    <div class="col-md-12">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="name" value="{{ $data->name ?? '' }}" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-outline-primary">Simpan</button>
                        <button type="reset" class="btn btn-outline-secondary">Reset</button>
                        <a href="{{ route('merek.index') }}" class="btn btn-outline-danger">Batal</a>
                    </div>
                </form>
                <!-- End Form -->
            </div>
        </div>
    </section>
@endsection
