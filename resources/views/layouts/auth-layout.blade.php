<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<title>@yield('title')</title>

	<link rel="icon" type="image/png" href="{{ asset("favicon-96x96.png") }}" sizes="96x96" />
	<link rel="icon" type="image/svg+xml" href="{{ asset("favicon.svg") }}" />
	<link rel="shortcut icon" href="{{ asset("favicon.ico") }}" />
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset("apple-touch-icon.png") }}" />
	<meta name="apple-mobile-web-app-title" content="Happniess Perfume" />
	<link rel="manifest" href="{{ asset("site.webmanifest") }}" />

	<!-- App CSS -->
	<link rel="stylesheet" href="{{ asset('dashboard/css/app-light.css') }}" id="lightTheme">

	<style>
		@font-face {
			font-family: arabic;
			src: url("{{ asset('fonts/Tajawal-Bold.ttf') }}");
		}

		body,
		html {
			overflow-x: hidden;
		}

		* {
			font-family: arabic;
		}

		input:-moz-placeholder {
			text-align: right;
		}

		input:-ms-input-placeholder {
			text-align: right;
		}

		input::-webkit-input-placeholder {
			text-align: right;
		}
	</style>
</head>

<body class="light rtl">
	<div class="wrapper vh-100">
		<div class="row align-items-center h-100">
			@yield('content')
		</div>
	</div>
</body>

</html>
