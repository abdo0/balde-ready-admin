<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-network-wired"></i>
        </div>
        <div class="sidebar-brand-text mx-3">laravel <sup>ready admin</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    @include('partials/menu')


<!-- Divider -->
    {{--<hr class="sidebar-divider d-none d-md-block">--}}

    <!-- Sidebar Toggler (Sidebar) -->
    {{--<div class="text-center d-none d-md-inline">--}}
        {{--<button class="rounded-circle border-0" id="sidebarToggle"></button>--}}
    {{--</div>--}}

</ul>
