@extends('dashboard.layouts.main-layout')

@section('style')
	<link rel="stylesheet" href="{{ asset('dashboard/css/dataTables.bootstrap4.css') }}">
@endsection

@section('title', 'المستخدمين')

@section('content')
	@if (session('success'))
		<div class="alert alert-success" role="alert">{{ session('success') }}</div>
	@endif

	@if (session('error'))
		<div class="alert alert-danger" role="alert">{{ session('error') }}</div>
	@endif

	@error('name')
		<div class="alert alert-danger" role="alert">{{ $message }}</div>
	@enderror

	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-12">
				<div class="row align-items-center my-3">
					<div class="col">
						<h2 class="page-title">المستخدمين</h2>
					</div>
					<div class="col-auto">
						<a href="{{ route('dashboard.user.create') }}" class="btn btn-info"><span
								class="fe fe-plus fe-16 mr-3"></span>إضافة حساب</a>
					</div>
				</div>
				<div class="row my-4">
					<!-- Small table -->
					<div class="col-md-12">
						<div class="card shadow">
							<div class="card-body">
								<!-- table -->
								<table class="table datatables" id="dataTable-1">
									<thead>
										<tr>
											<th>الاسم</th>
											<th>البريد الالكترونى</th>
											<th>نوع الحساب</th>
											<th>حذف</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($users as $user)
											<tr>
												<td>{{ $user->name }}</td>
												<td>{{ $user->email }}</td>
												<td>{{ $user->role == 'admin' ? 'مدير' : 'مستخدم' }}</td>
												<td>
													<form method="post"
														action="{{ route('dashboard.user.destroy', ['user' => $user->id]) }}">
														@csrf
														@method('delete')
														<button type="submit"
															class="btn btn-sm btn-danger mb-2">حذف</button>
													</form>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div> <!-- simple table -->
				</div> <!-- end section -->
			</div> <!-- .col-12 -->
		</div> <!-- .row -->
	</div> <!-- .container-fluid -->
@endsection

@section('script')
	<script src='{{ asset('dashboard/js/jquery.dataTables.min.js') }}'></script>
	<script src='{{ asset('dashboard/js/dataTables.bootstrap4.min.js') }}'></script>

	<script>
		$('#dataTable-1').DataTable({
			autoWidth: true,
			order: []
		});
	</script>
@endsection
