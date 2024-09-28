<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon">
            <img style="width:50px; height:50px;" src="{{ asset('img/logo-dishub.png') }}" alt="">
        </div>
        <div class="sidebar-brand-text mx-3">DISHUB</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
        <a class="nav-link" href="{{route('admin.dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        MASTER DATA
    </div>
    <?php //ADMIN LOGIN

    ?>
    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item {{ (request()->is('admin/halte')) ? 'active' : '' }}{{ (request()->is('admin/halte/*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('admin.halte')}}">
            <i class="fas fa-fw fa-landmark"></i>
            <span>Data Halte</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('admin/koridor')) ? 'active' : '' }}{{ (request()->is('admin/koridor/*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('admin.koridor')}}">
            <i class="fas fa-fw fa-road"></i>
            <span>Data Koridor</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('admin/bus')) ? 'active' : '' }}{{ (request()->is('admin/bus/*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('admin.bus')}}">
            <i class="fas fa-fw fa-bus"></i>
            <span>Data Bus</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('admin/graf')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('admin.graf')}}">
            <i class="fas fa-fw fa-route"></i>
            <span>Data Graf</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('admin/rute')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('admin.rute')}}">
            <i class="fas fa-fw fa-map"></i>
            <span>Data Rute</span>
        </a>
    </li>
    <?php
    //END ADMIN LOGIN
    ?>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
    <!-- Sidebar Message ->
            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
                <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
                <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
            </div>
           <-- Sidebar Message -->

</ul>
<!-- End of Sidebar -->