@extends('layouts.template.app')
@section('content')
    <div class="pagetitle">
        <h1>Form Barang</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('barang.index') }}">Data Barang</a></li>
                <li class="breadcrumb-item active">{{ $data != null ? 'Ubah Data Barang' : 'Tambah Data Barang' }}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $data != null ? 'Ubah Data Barang' : 'Tambah Data Barang' }}</h5>

                <!-- Form -->
                <form class="row g-3" action="{{ $data ? route('barang.update', $data->id) : route('barang.add') }}"
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
                        <label class="form-label">Stok</label>
                        <input type="number" class="form-control" name="stock" value="{{ $data->stock ?? '' }}"
                            {{ $data ? 'disabled' : 'required' }}>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Satuan</label>
                        <select name="unit_id" class="form-control" required>
                            @if ($data)
                                <option value="{{ $data->unit_id }}" selected>{{ $data->unit->name }}</option>
                            @else
                                <option value="" disabled selected>Pilih</option>
                            @endif
                            @foreach ($unit as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Stok Minimal</label>
                        <input type="number" class="form-control" name="minimal_stock"
                            value="{{ $data->minimal_stock ?? 1 }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Proyek</label>
                        <select name="project_id" class="form-control" required>
                            @if ($data)
                                <option value="{{ $data->project_id }}" selected>{{ $data->project->name }}</option>
                            @else
                                <option value="" disabled selected>Pilih</option>
                            @endif
                            @foreach ($project as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Merek</label>
                        <select name="brand_id" class="form-control" required>
                            @if ($data)
                                <option value="{{ $data->brand_id }}" selected>{{ $data->brand->name }}</option>
                            @else
                                <option value="" disabled selected>Pilih</option>
                            @endif
                            @foreach ($brand as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <h5 class="card-title">Form Tambahan</h5>

                    <!-- Additional Form Accordion -->
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Form Tambahan
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="col-md-12">
                                        <label class="form-label">Nomor PO</label>
                                        <input type="text" class="form-control" name="po_number"
                                            value="{{ $data->po_number ?? '' }}">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Lokasi</label>
                                        <input type="text" class="form-control" name="location"
                                            value="{{ $data->location ?? '' }}">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Tanggal Kadaluarsa</label>
                                        <input type="date" class="form-control" name="exp_date"
                                            value="{{ $data->exp_date ?? '' }}">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Keterangan</label>
                                        <input type="text" class="form-control" name="remark"
                                            value="{{ $data->remark ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Additional Form Accordion -->

                    <div class="text-center">
                        <button type="submit" class="btn btn-outline-primary">Simpan</button>
                        <button type="reset" class="btn btn-outline-secondary">Reset</button>
                        <a href="{{ route('barang.index') }}" class="btn btn-outline-danger">Batal</a>
                    </div>
                </form>
                <!-- End Form -->
            </div>
        </div>
    </section>
@endsection
