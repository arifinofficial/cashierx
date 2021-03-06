<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ core()->getAllSettings() != null ? core()->getAllSettings()->store_name : 'CashierX' }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Master
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('order.transaksi') }}">
            <i class="fas fa-cash-register"></i>
            <span>Kasir</span></a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-utensils"></i>
            <span>Produk</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Produk</h6>
                <a class="collapse-item" href="{{ route('product.category.index') }}">Kategori</a>
                <a class="collapse-item" href="{{ route('product.main-product.index') }}">Produk</a>
                <h6 class="collapse-header">Atribut</h6>
                <a class="collapse-item" href="{{ route('product.variant.index') }}">Variant</a>
                <a class="collapse-item" href="{{ route('product.unit.index') }}">Unit</a>
            </div>
        </div>
    </li>

    @role('admin')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseActivity" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-database"></i>
            <span>Aktifitas</span>
        </a>
        <div id="collapseActivity" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Laporan</h6>
                <a class="collapse-item" href="{{ route('report.daily.index') }}">Laporan Harian</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('transaction-data.index') }}">
            <i class="fas fa-money-bill-wave"></i>
            <span>Data Transaksi</span></a>
    </li>
    @endrole

    <!-- Divider Mulai Disini -->
    <hr class="sidebar-divider">

    @role('admin')
    <!-- Heading -->
    <div class="sidebar-heading">
        General
    </div>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-users-cog"></i>
            <span>User Management</span>
        </a>
        <div id="collapseUser" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('user.index') }}">User</a>
                <a class="collapse-item" href="{{ route('role.index') }}">Role</a>
                <a class="collapse-item" href="{{ route('roles.permission.index') }}">Role Permission</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Setting</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">General</h6>
                <a class="collapse-item" href="{{ route('setting.index') }}">Store Setting</a>
                <a class="collapse-item" href="{{ route('setting-printer.index') }}">Printer Setting</a>
                <h6 class="collapse-header">Discount</h6>
                <a class="collapse-item" href="{{ route('discount.index') }}">Discount Member</a>
            </div>
        </div>
    </li>
    @endrole

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->