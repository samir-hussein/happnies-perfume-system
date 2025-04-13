<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="logo" width="130">
            </a>
        </div>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link a-hover {{ request()->path() == 'dashboard/home' ? 'active' : '' }}"
                    href="{{ route('dashboard.home') }}">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">الرئيسية</span>
                </a>
            </li>

            <li class="nav-item w-100">
                <a class="nav-link a-hover {{ str_starts_with(request()->path(), 'dashboard/user') ? 'active' : '' }}"
                    href="{{ route('dashboard.user.index') }}">
                    <i class="fe fe-user fe-16"></i>
                    <span class="ml-3 item-text">المستخدمين</span>
                </a>
            </li>

            <li class="nav-item w-100">
                <a class="nav-link a-hover {{ str_starts_with(request()->path(), 'dashboard/partner') ? 'active' : '' }}"
                    href="{{ route('dashboard.partner.index') }}">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">الشركاء</span>
                </a>
            </li>

            <li class="nav-item w-100">
                <a class="nav-link a-hover {{ str_starts_with(request()->path(), 'dashboard/employee') ? 'active' : '' }}"
                    href="{{ route('dashboard.employee.index') }}">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">الموظفيين</span>
                </a>
            </li>

            <li class="nav-item w-100">
                <a class="nav-link a-hover {{ str_starts_with(request()->path(), 'dashboard/client') ? 'active' : '' }}"
                    href="{{ route('dashboard.client.index') }}">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">العملاء</span>
                </a>
            </li>

            <li class="nav-item w-100">
                <a class="nav-link a-hover {{ str_starts_with(request()->path(), 'dashboard/category') ? 'active' : '' }}"
                    href="{{ route('dashboard.category.index') }}">
                    <i class="fe fe-server fe-16"></i>
                    <span class="ml-3 item-text">الاقسام</span>
                </a>
            </li>

            <li class="nav-item w-100">
                <a class="nav-link a-hover {{ str_starts_with(request()->path(), 'dashboard/product') ? 'active' : '' }}"
                    href="{{ route('dashboard.product.index') }}">
                    <i class="fe fe-shopping-bag fe-16"></i>
                    <span class="ml-3 item-text">المنتجات</span>
                </a>
            </li>

            <li class="nav-item w-100">
                <a id="notification-nav"
                    class="nav-link a-hover {{ str_starts_with(request()->path(), 'dashboard/notification') ? 'active' : '' }}"
                    href="{{ route('dashboard.notification.index') }}">
                    <i class="fe fe-bell fe-16"></i>
                    <span class="ml-3 item-text">التنبيهات</span>
                </a>
            </li>

            <li class="nav-item w-100">
                <a class="nav-link a-hover {{ str_starts_with(request()->path(), 'dashboard/safe') ? 'active' : '' }}"
                    href="{{ route('dashboard.safe.index') }}">
                    <i class="fe fe-cpu fe-16"></i>
                    <span class="ml-3 item-text">الخزنة</span>
                </a>
            </li>

            <li class="nav-item w-100">
                <a class="nav-link a-hover {{ str_starts_with(request()->path(), 'dashboard/expenses') ? 'active' : '' }}"
                    href="{{ route('dashboard.expenses.index') }}">
                    <i class="fe fe-dollar-sign fe-16"></i>
                    <span class="ml-3 item-text">المصروفات</span>
                </a>
            </li>

            <li class="nav-item w-100">
                <a class="nav-link a-hover {{ str_starts_with(request()->path(), 'dashboard/order') ? 'active' : '' }}"
                    href="{{ route('dashboard.order.index') }}">
                    <i class="fe fe-file-text fe-16"></i>
                    <span class="ml-3 item-text">فواتير</span>
                </a>
            </li>

            <li class="nav-item w-100">
                <a class="nav-link a-hover {{ str_starts_with(request()->path(), 'dashboard/online/order') ? 'active' : '' }}"
                    href="{{ route('dashboard.order.online') }}">
                    <i class="fe fe-wifi fe-16"></i>
                    <span class="ml-3 item-text">طلبات اون لاين</span>
                </a>
            </li>

            <li class="nav-item w-100">
                <a class="nav-link a-hover {{ str_starts_with(request()->path(), 'dashboard/wholesale') ? 'active' : '' }}"
                    href="{{ route('dashboard.wholesale.index') }}">
                    <i class="fe fe-codepen fe-16"></i>
                    <span class="ml-3 item-text">بيع جملة</span>
                </a>
            </li>
        </ul>

    </nav>
</aside>
