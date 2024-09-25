<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
        @if (Auth::user()->roles_label[0])
            <li class="nav-heading">Super Admin Menu</li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('user.index') }}">
                    <i class="bi bi-person"></i>
                    <span>Pengguna</span>
                </a>
                <a class="nav-link collapsed" href="{{ route('logs') }}" target="_blank">
                    <i class="bi bi-code"></i>
                    <span>Logs</span>
                </a>
            </li>
        @endif

        <li class="nav-heading">Master Data</li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#atributBarang-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-bag"></i><span>Atribut Barang</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="atributBarang-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('proyek.index') }}">
                        <i class="bi bi-circle"></i><span>Project</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('merek.index') }}">
                        <i class="bi bi-circle"></i><span>Merek</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('satuan.index') }}">
                        <i class="bi bi-circle"></i><span>Satuan</span>
                    </a>
                </li>
            </ul>
        </li><!-- End atribut Barang Nav -->

        <a class="nav-link collapsed" href="{{ route('barang.index') }}">
            <i class="bi bi-menu-button-wide"></i>
            <span>Barang</span>
        </a><!-- End Barang Nav -->

        <a class="nav-link collapsed" href="{{ route('supplier.index') }}">
            <i class="bi bi-bank"></i>
            <span>Supplier</span>
        </a><!-- End Supploer Nav -->

        <a class="nav-link collapsed" href="{{ route('pelanggan.index') }}">
            <i class="bi bi-people"></i>
            <span>Pelanggan</span>
        </a><!-- End Barang Nav -->

        <li class="nav-heading">Stok Barang</li>

        <a class="nav-link collapsed" href="{{ route('masuk.index') }}">
            <i class="bi bi-arrow-return-right"></i>
            <span>Barang Masuk</span>
        </a><!-- End Barang Masuk Nav -->

        <a class="nav-link collapsed" href="{{ route('keluar.index') }}">
            <i class="bi bi-arrow-return-left"></i>
            <span>Barang Keluar</span>
        </a><!-- End Barang Keluar Nav -->

        <a class="nav-link collapsed" href="{{ route('penyesuaian.stok.index') }}">
            <i class="bi bi-arrow-left-right"></i>
            <span>Penyesuaian Stok</span>
        </a><!-- End Barang Keluar Nav -->

        <li class="nav-heading">Laporan</li>

        <a class="nav-link collapsed" href="{{ route('report.index') }}">
            <i class="bi bi-bar-chart"></i>
            <span>Laporan Stok</span>
        </a><!-- End Laporan Stok Nav -->
        @php
            $datas = App\Models\Barang::whereColumn('stock', '=', 'minimal_stock')->get();
        @endphp
        <a class="nav-link collapsed" href="{{ route('stock.kritis.index') }}">
            <i class="bi bi-exclamation-triangle"></i>
            <span>Laporan Stok Kritis</span>
            @if ($datas)
                <span class="badge bg-danger badge-number m-2 text-white">{{ $datas->count() }}</span>
            @endif
        </a><!-- End Laporan Stok Kritis Nav -->

    </ul>

</aside>
