@extends('layouts.template.app')
@section('content')
    <div class="pagetitle">
        <h1>Laporan Stok Keluar</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Laporan Stok Keluar</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    Daftar Stok Keluar
                </h5>

                <form class="row g-3 mb-4" action="{{ route('report.stockOut') }}" method="GET">
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
                        <a href="{{ route('report.stockOut') }}" class="btn btn-secondary">Reset Filter</a>
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
                                <th scope="col">Nomor Nota</th>
                                <th scope="col">No DO</th>
                                <th scope="col">Kode Barang</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col" class="text-center">Jumlah</th>
                                <th scope="col">Supplier</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Dibuat Oleh</th>
                                <th scope="col">ATTN</th>
                                <th scope="col">Via</th>
                                <th scope="col">Carrier</th>
                                <th scope="col">Reff</th>
                                <th scope="col">Truck No</th>
                                <th scope="col">Delivered By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $key => $item)
                                <tr>
                                    <td>{{ $item->stock->bill_no }}</td>
                                    <td>{{ $item->stock->do_number }}</td>
                                    <td>{{ $item->barang->code }}</td>
                                    <td>{{ $item->barang->name }}</td>
                                    <td class="text-center">{{ $item->qty }}</td>
                                    <td>{{ $item->stock->customer->name }}</td>
                                    <td>{{ $item->remarks }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->stock->attn }}</td>
                                    <td>{{ $item->stock->via }}</td>
                                    <td>{{ $item->stock->carrier }}</td>
                                    <td>{{ $item->stock->reff }}</td>
                                    <td>{{ $item->stock->truck_no }}</td>
                                    <td>{{ $item->stock->delivered_by }}</td>
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
