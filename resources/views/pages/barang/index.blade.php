@extends('layouts.template.app')
@section('content')
    <div class="pagetitle">
        <h1>Data Barang</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Data Barang</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    Daftar Barang
                    <a href="{{ route('barang.create') }}" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-pencil"></i> Tambah
                    </a>
                </h5>

                <!-- Table -->
                <div class="table-responsive">
                    <table id="table" class="table table-borderless display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col">Kode</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Proyek</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Satuan</th>
                                <th scope="col">Merek</th>
                                <th scope="col">Stok Minimal</th>
                                <th scope="col">Nomor PO</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col">Tanggal kadaluarsa</th>
                                <th scope="col">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $key => $item)
                                <tr>
                                    <td class="text-center">
                                        <form action="{{ route('barang.delete', $item->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <a href="{{ route('barang.edit', $item->id) }}"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="submit" onclick="return confirm('Are you sure?')"
                                                class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>{{ $item->code }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->project->name }}</td>
                                    <td>{{ $item->stock }}</td>
                                    <td>{{ $item->unit->name }}</td>
                                    <td>{{ $item->brand->name }}</td>
                                    <td>{{ $item->minimal_stock }}</td>
                                    <td>{{ $item->po_number }}</td>
                                    <td>{{ $item->location }}</td>
                                    <td>{{ $item->exp_date }}</td>
                                    <td>{{ $item->remark }}</td>
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
