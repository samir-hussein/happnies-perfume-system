<nav class="topnav navbar navbar-light">
    <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
        <i class="fe fe-menu navbar-toggler-icon"></i>
    </button>

    <div class="d-flex flex-column justify-content-center">
        <button class="btn btn-info d-flex align-items-center" id="refresh">
            <span class="fe fe-16 fe-refresh-cw mr-2"></span>
            تحديث الصفحة
        </button>
    </div>

    <ul class="nav">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink"
                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span>{{ auth()->user()->name }}</span>
                <span class="avatar avatar-sm mt-2">
                    <img src="{{ asset('images/teacher.png') }}" alt="..." class="avatar-img rounded-circle">
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="{{ route('dashboard.profile') }}">البيانات الشخصية</a>
                <a class="dropdown-item" href="{{ route('logout') }}">تسجيل الخروج</a>
            </div>
        </li>
    </ul>
</nav>
