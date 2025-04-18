@extends('dashboard.layouts.main-layout')

@section('style')
	<link rel="stylesheet" href="{{ asset('dashboard/css/dataTables.bootstrap4.css') }}">
	<link rel="stylesheet" href="{{ asset('dashboard/css/select2.css') }}">
@endsection

@section('title', 'المنتجات')

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
				<div class="card shadow mb-4" data-select2-id="9">
					<div class="card-body" data-select2-id="8">
						<form id="select-form" action="{{ route('dashboard.product.index') }}">
							<div class="form-group col-md-6">
								<label for="multi-select2">اختيار قسم لتصفية المنتجات</label>
								<select multiple name="categories[]" class="form-control select2-multi" id="multi-select2">
									@foreach ($categories as $category)
										<option
											{{ request('categories') ? (in_array($category->id, request('categories')) ? 'selected' : '') : 'selected' }}
											value="{{ $category->id }}">{{ $category->name }}</option>
									@endforeach
								</select>
								<div class="row mb-2 mt-2">
									<label for="">تصفية احصائيات البيع بالتاريخ</label>
									<div class="col">
										<label for="">من تاريخ</label>
										<input type="date" class="form-control" name="from"
											value="{{ request('from') ?? date('Y-m-01') }}">
									</div>
									<div class="col">
										<label for="">إلى تاريخ</label>
										<input type="date" class="form-control"
											value="{{ request('to') ?? date('Y-m-t') }}" name="to">
									</div>
								</div>
								<button class="mt-2 btn btn-dark">تصفية</button>
								<button id="select-all" type="button" class="mt-2 btn btn-success">اختيار الكل</button>
							</div> <!-- form-group -->
						</form>
					</div> <!-- /.card-body -->
				</div>
			</div>
			<div class="row col-12">
				<div class="col-md-6 col-xl-4 mb-4">
					<div class="card shadow mb-4">
						<div class="card-header">
							<span class="card-title">عدد المنتجات</span>
						</div>
						<div class="card-body my-n1">
							<div class="d-flex">
								<div class="flex-fill">
									<h4 class="mb-0">{{ count($products) }}</h4>
								</div>
								<div class="flex-fill text-right">
									<span class="sparkline inlinebar"><canvas width="40" height="32"
											style="display: inline-block; width: 40px; height: 32px; vertical-align: top;"></canvas></span>
								</div>
							</div>
						</div> <!-- .card-body -->
					</div> <!-- .card -->
				</div>
				<div class="col-md-6 col-xl-4 mb-4">
					<div class="card shadow mb-4">
						<div class="card-header">
							<span class="card-title">تكلفة المنتجات</span>
						</div>
						<div class="card-body my-n1">
							<div class="d-flex">
								<div class="flex-fill">
									<h4 class="mb-0">
										{{ number_format($total_cost, 2) }}
										جنية</h4>
								</div>
								<div class="flex-fill text-right">
									<span class="sparkline inlinebar"><canvas width="40" height="32"
											style="display: inline-block; width: 40px; height: 32px; vertical-align: top;"></canvas></span>
								</div>
							</div>
						</div> <!-- .card-body -->
					</div> <!-- .card -->
				</div>
				<div class="col-md-6 col-xl-4 mb-4">
					<div class="card shadow mb-4">
						<div class="card-header">
							<span class="card-title">الارباح المتوقعة</span>
						</div>
						<div class="card-body my-n1">
							<div class="d-flex">
								<div class="flex-fill">
									<h4 class="mb-0">{{ number_format($profits, 2) }} جنية</h4>
								</div>
								<div class="flex-fill text-right">
									<span class="sparkline inlinebar"><canvas width="40" height="32"
											style="display: inline-block; width: 40px; height: 32px; vertical-align: top;"></canvas></span>
								</div>
							</div>
						</div> <!-- .card-body -->
					</div> <!-- .card -->
				</div>
				<div class="col-md-6 col-xl-4 mb-4">
					<div class="card shadow mb-4">
						<div class="card-header">
							<span class="card-title">مخزون الزيوت</span>
						</div>
						<div class="card-body my-n1">
							<div class="d-flex">
								<div class="flex-fill">
									<h4 class="mb-0">{{ $oil }} جرام</h4>
								</div>
								<div class="flex-fill text-right">
									<span class="sparkline inlinebar"><canvas width="40" height="32"
											style="display: inline-block; width: 40px; height: 32px; vertical-align: top;"></canvas></span>
								</div>
							</div>
						</div> <!-- .card-body -->
					</div> <!-- .card -->
				</div>
				<div class="col-md-6 col-xl-4 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <span class="card-title">الزيوت المباعة</span>
                        </div>
                        <div class="card-body my-n1">
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <h4 class="mb-0">{{ $oil_sold }} جرام</h4>
                                </div>
                                <div class="flex-fill text-right">
                                    <span class="sparkline inlinebar"><canvas width="40" height="32"
                                            style="display: inline-block; width: 40px; height: 32px; vertical-align: top;"></canvas></span>
                                </div>
                            </div>
                        </div> <!-- .card-body -->
                    </div> <!-- .card -->
                </div>
			</div>
			<div class="col-12">
				<div class="row align-items-center my-3">
					<div class="col">
						<h2 class="page-title">المنتجات</h2>
					</div>
					<div class="col-auto">
						<a href="{{ route('dashboard.product.create') }}"
							class="btn btn-info d-flex align-items-center"><span class="fe fe-plus fe-16 mr-3"></span>إضافة
							منتج</a>
					</div>
					<div class="col-auto">
						<a href="{{ route('dashboard.product.index', ['excel' => true, 'categories' => request('categories'), 'from' => request('from'), 'to' => request('to')]) }}"
							class="btn btn-success d-flex align-items-center"><span
								class="fe fe-arrow-down-circle fe-16 mr-3"></span>تحميل اكسيل</a>
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
											<th>كود المنتج</th>
											<th>الاسم</th>
											<th>القسم</th>
											<th>سعر البيع</th>
											<th>الخصم</th>
											<th>السعر بعد الخصم</th>
											<th>الكمية</th>
											<th>الربح المتوقع</th>
											<th>عدد مرات البيع</th>
											<th>الكمية المباعة</th>
											<th>عمليات</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($products as $product)
											<tr>
												<td>{{ $product->code }}</td>
												<td>{{ $product->name }}</td>
												<td>{{ $product->category->name }}</td>
												<td>{{ $product->price }} جنية</td>
												<td>{{ $product->discount }}
													{{ $product->discount_type == 'ratio' ? '%' : 'جنية' }}</td>
												<td>{{ $product->priceAfterDiscount() }} جنية</td>
												<td>{{ $product->qty->sum('qty') }} {{ $product->unit }}</td>
												<td>{{ number_format($product->profit(), 2) }} جنية</td>
												<td>{{ $product->times_sold }}</td>
												<td>{{ $product->qty_sold }} {{ $product->unit }}</td>
												<td class="row">
													<form class="col" method="post"
														action="{{ route('dashboard.product.destroy', ['product' => $product->id]) }}">
														@csrf
														@method('delete')
														<button type="submit"
															class="btn btn-danger btn-sm mb-2">حذف</button>
													</form>
													<a class="col"
														href="{{ route('dashboard.product.show', ['product' => $product->id]) }}"><button
															class="btn btn-warning btn-sm">تفاصيل</button></a>
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
	<script src='{{ asset('dashboard/js/select2.min.js') }}'></script>

	<script>
		$(document).ready(function() {
			$('.select2').select2({
				theme: 'bootstrap4',
			});
			$('.select2-multi').select2({
				multiple: true,
				theme: 'bootstrap4',
			});

			var dataTable = $('#dataTable-1').DataTable({
				autoWidth: true,
				order: []
			});

			$('.dataTables_filter label').replaceWith(
				`
			<div class="input-group">
				<div class="input-group-prepend">
					<select class="form-control" id="searchColumn">
						<option value="0">كود المنتج</option>
						<option value="1">الاسم</option>
						<option value="2">القسم</option>
						<option value="3">سعر البيع</option>
						<option value="4">الخصم</option>
						<option value="5">السعر بعد الخصم</option>
						<option value="6">الكمية</option>
						<option value="7">الربح المتوقع</option>
						<option value="8">عدد مرات البيع</option>
						<option value="9">الكمية المباعة</option>
					</select>
				</div>
				<input type="search" class="form-control" placeholder="بحث">
			</div>
			`
			);
			var lastSelectedColumn = 0; // Variable to store the last selected column index

			// Add event listener for column select change
			$('#searchColumn').on('change', function() {
				dataTable.column(lastSelectedColumn).search("").draw();
				lastSelectedColumn = parseInt($(this).val());
				performSearch();
			});

			// Handle keyup event for the search input
			$('.dataTables_filter input[type="search"]').on('keyup', function() {
				performSearch();
			});

			// Function to perform search
			function performSearch() {
				var searchText = $('.dataTables_filter input[type="search"]').val();
				dataTable.column(lastSelectedColumn).search(searchText).draw();
			}

			$("#select-all").click(function() {
				$('#multi-select2 option').prop('selected', true);
				$('#multi-select2').trigger('change');
				$("#select-form").submit();
			});
		});
	</script>
@endsection
