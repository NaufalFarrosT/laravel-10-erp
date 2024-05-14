<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">ERP KU</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                <li class="nav-item" style="border-bottom: 1px solid #4f5962">
                    <a href="#" class="nav-link">
                        <i class="far fa fa-database nav-icon"></i>

                        <p>
                            Master
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/account" class="nav-link">
                                <i class="far fa fa-database nav-icon"></i>
                                <p>Akun</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/warehouse" class="nav-link">
                                <i class="far fa fa-database nav-icon"></i>
                                <p>Gudang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/item" class="nav-link">
                                <i class="far fa fa-database nav-icon"></i>
                                <p>Item</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/role" class="nav-link">
                                <i class="far fa fa-database nav-icon"></i>
                                <p>Jabatan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/category" class="nav-link">
                                <i class="far fa fa-database nav-icon"></i>
                                <p>Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/supplier" class="nav-link">
                                <i class="far fa fa-database nav-icon"></i>
                                <p>Pemasok</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/user" class="nav-link">
                                <i class="far fa fa-database nav-icon"></i>
                                <p>Pengguna</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/unit" class="nav-link">
                                <i class="far fa fa-database nav-icon"></i>
                                <p>Satuan</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item" style="border-bottom: 1px solid #4f5962">
                    <a href="#" class="nav-link">
                        <i class="fas fa-folder nav-icon"></i>
                        <p>
                            Laporan
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Transaksi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Buku Besar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jurnal Umum</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">Transaksi</li>
                <li class="nav-item">
                    <a href="{{ route('purchase.index') }}" class="nav-link">
                        <i class="fas fa-folder-plus nav-icon"></i>
                        <p>Pembelian</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('sale.index') }}" class="nav-link">
                        <i class="fas fa-cart-plus nav-icon"></i>
                        <p>Penjualan</p>
                    </a>
                </li>
                <li class="nav-item" style="border-bottom: 1px solid #4f5962">
                    <a href="#" class="nav-link">
                        <i class="fas fa-clipboard nav-icon"></i>
                        <p>Pendapatan/Pengeluaran</p>
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <form id="logout" action="{{ route('logout') }}" method="POST" class="nav-link">
                        @csrf
                        <a href="javascript:;" onclick="document.getElementById('logout').submit();">
                            <i class="nav-icon far fas fa-sign-out-alt"></i>
                            <p>
                                Logout
                            </p>
                        </a>
                    </form>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
