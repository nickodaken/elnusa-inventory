@extends('layouts.template.app')
@section('content')
    <div class="pagetitle">
        <h1>Data Stok Keluar</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Data Stok Keluar</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    Daftar Stok Keluar
                    <a href="{{ route('keluar.create') }}" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-pencil"></i> Tambah
                    </a>
                </h5>

                <form class="row g-3 mb-4" action="{{ route('keluar.index') }}" method="GET">
                    <div class="col-6">
                        <label class="form-label">Tanggal Awal</label>
                        <input type="date" class="form-control" name="startDate"
                            value="{{ app('request')->input('startDate') }}" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" name="endDate"
                            value="{{ app('request')->input('endDate') }}" required>
                    </div>
                    <div class="text-left">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('keluar.index') }}" class="btn btn-secondary">Reset Filter</a>
                    </div>
                </form>

                @if (is_null(app('request')->input('startDate')))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-collection me-1"></i>
                        Data yang ditampilkan tanpa filter, adalah data yang di tambahkan dari tanggal
                        {{ Carbon\Carbon::now()->startOfMonth()->format('d-M-Y') }} s/d
                        {{ Carbon\Carbon::now()->format('d-M-Y') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Table -->
                <div class="table-responsive">
                    <table id="table" class="table table-borderless display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col">Nomor Nota</th>
                                <th scope="col">Nomor DO</th>
                                <th scope="col">Pelanggan</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Dibuat Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $key => $item)
                                <tr>
                                    <td class="text-center">
                                        <form action="{{ route('keluar.delete', $item->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <a href="{{ route('keluar.detail', $item->id) }}" onclick="window.print();"
                                                class="btn
                                                btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('keluar.getPdf', $item->id) }}"
                                                class="btn btn-sm btn-outline-info" target="_balnk">
                                                <i class="bi bi-download"></i>
                                            </a>
                                            <button type="submit" onclick="return confirm('Are you sure?')"
                                                class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>{{ $item->bill_no }}</td>
                                    <td>{{ $item->do_number }}</td>
                                    <td>{{ $item->customer->name }}</td>
                                    <td>{{ carbon\Carbon::parse($item->date)->format('d-M-Y') ?? '' }}</td>
                                    <td>{{ $item->user->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End Table -->
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{ asset('datatables/js/dataTables.fixedHeader.min.js') }}"></script>

    <script>
        $('#table thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#table thead');

        $(document).ready(function() {
            var table = $('#table').DataTable({
                scrollX: false,
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ],
                pageLength: 20,
                paging: true,
                orderCellsTop: true,
                initComplete: function() {
                    var api = this.api();

                    // For each column
                    api
                        .columns()
                        .eq(0)
                        .each(function(colIdx) {
                            // Set the header cell to contain the input element
                            var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                            );
                            var title = $(cell).text();
                            $(cell).html('<input type="text" placeholder="' + title + '" />');

                            // On every keypress in this input
                            $(
                                    'input',
                                    $('.filters th').eq($(api.column(colIdx).header()).index())
                                )
                                .off('keyup change')
                                .on('change', function(e) {
                                    // Get the search value
                                    $(this).attr('title', $(this).val());
                                    var regexr =
                                        '({search})'; //$(this).parents('th').find('select').val();

                                    var cursorPosition = this.selectionStart;
                                    // Search the column for that value
                                    api
                                        .column(colIdx)
                                        .search(
                                            this.value != '' ?
                                            regexr.replace('{search}', '(((' + this.value +
                                                ')))') :
                                            '',
                                            this.value != '',
                                            this.value == ''
                                        )
                                        .draw();
                                })
                                .on('keyup', function(e) {
                                    e.stopPropagation();

                                    $(this).trigger('change');
                                    $(this)
                                        .focus()[0]
                                        .setSelectionRange(cursorPosition, cursorPosition);
                                });
                        });
                },
            });
        });
    </script>
@endsection
