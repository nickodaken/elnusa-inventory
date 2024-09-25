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

        {{-- <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>Forms</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="forms-elements.html">
                        <i class="bi bi-circle"></i><span>Form Elements</span>
                    </a>
                </li>
                <li>
                    <a href="forms-layouts.html">
                        <i class="bi bi-circle"></i><span>Form Layouts</span>
                    </a>
                </li>
                <li>
                    <a href="forms-editors.html">
                        <i class="bi bi-circle"></i><span>Form Editors</span>
                    </a>
                </li>
                <li>
                    <a href="forms-validation.html">
                        <i class="bi bi-circle"></i><span>Form Validation</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Forms Nav --> --}}

        {{-- <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Tables</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="tables-general.html">
                        <i class="bi bi-circle"></i><span>General Tables</span>
                    </a>
                </li>
                <li>
                    <a href="tables-data.html">
                        <i class="bi bi-circle"></i><span>Data Tables</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Tables Nav --> --}}

        {{-- <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-bar-chart"></i><span>Charts</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="charts-chartjs.html">
                        <i class="bi bi-circle"></i><span>Chart.js</span>
                    </a>
                </li>
                <li>
                    <a href="charts-apexcharts.html">
                        <i class="bi bi-circle"></i><span>ApexCharts</span>
                    </a>
                </li>
                <li>
                    <a href="charts-echarts.html">
                        <i class="bi bi-circle"></i><span>ECharts</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Charts Nav --> --}}

        {{-- <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-gem"></i><span>Icons</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="icons-bootstrap.html">
                        <i class="bi bi-circle"></i><span>Bootstrap Icons</span>
                    </a>
                </li>
                <li>
                    <a href="icons-remix.html">
                        <i class="bi bi-circle"></i><span>Remix Icons</span>
                    </a>
                </li>
                <li>
                    <a href="icons-boxicons.html">
                        <i class="bi bi-circle"></i><span>Boxicons</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Icons Nav --> --}}

        {{-- <li class="nav-heading">Pages</li> --}}

        {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li><!-- End Profile Page Nav --> --}}

        {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>F.A.Q</span>
            </a>
        </li><!-- End F.A.Q Page Nav --> --}}

        {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="pages-contact.html">
                <i class="bi bi-envelope"></i>
                <span>Contact</span>
            </a>
        </li><!-- End Contact Page Nav --> --}}

        {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="pages-register.html">
                <i class="bi bi-card-list"></i>
                <span>Register</span>
            </a>
        </li><!-- End Register Page Nav --> --}}

        {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="pages-login.html">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Login</span>
            </a>
        </li><!-- End Login Page Nav --> --}}

        {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="pages-error-404.html">
                <i class="bi bi-dash-circle"></i>
                <span>Error 404</span>
            </a>
        </li><!-- End Error 404 Page Nav --> --}}

        {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="pages-blank.html">
                <i class="bi bi-file-earmark"></i>
                <span>Blank</span>
            </a>
        </li><!-- End Blank Page Nav --> --}}

    </ul>

</aside>
