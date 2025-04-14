<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
	<a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
		<i class="fe fe-x"><span class="sr-only"></span></i>
	</a>
	<nav class="vertnav navbar navbar-light">
		<!-- nav bar -->
		<div class="w-100 mb-4 d-flex">
			<a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="/">
				<img src="{{ asset('images/logo.png') }}" alt="logo" width="150">
			</a>
		</div>
		<ul class="navbar-nav flex-fill w-100 mb-2">
			<li class="nav-item w-100">
				<a class="nav-link a-hover {{ request()->path() == '/' ? 'active' : '' }}" href="/">
					<i class="fe fe-home fe-16"></i>
					<span class="ml-3 item-text">بيع مباشر</span>
				</a>
			</li>

			<li class="nav-item w-100">
				<a class="nav-link a-hover {{ request()->path() == 'online' ? 'active' : '' }}"
					href="{{ route('online') }}">
					<i class="fe fe-wifi fe-16"></i>
					<span class="ml-3 item-text">طلبات اون لاين</span>
				</a>
			</li>

			<li class="nav-item w-100">
				<a class="nav-link a-hover {{ request()->path() == 'online/order' ? 'active' : '' }}"
					href="{{ route('order.online') }}">
					<i class="fe fe-list fe-16"></i>
					<span class="ml-3 item-text">قائمة الطلبات</span>
				</a>
			</li>

			@if (auth()->user()->role == "admin")
				<li class="nav-item w-100">
					<a class="nav-link a-hover" href="{{ route('dashboard.home') }}">
						<i class="fe fe-settings fe-16"></i>
					<span class="ml-3 item-text">لوحة التحكم</span>
				</a>
			</li>
			@endif

			<li class="nav-item w-100">
				<a class="nav-link a-hover"
					href="{{ route('logout') }}">
					<i class="fe fe-list fe-16"></i>
					<span class="ml-3 item-text">خروج</span>
				</a>
			</li>
		</ul>

	</nav>
</aside>
