<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <link rel="icon" href="favicon.ico">
    <title>@yield('title')</title>

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
