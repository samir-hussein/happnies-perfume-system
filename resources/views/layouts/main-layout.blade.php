<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title',"Happniess Perfume System")</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/simplebar.css') }}">

    <!-- Icons CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/feather.css') }}">

    @yield('style')

    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/daterangepicker.css') }}">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/app-light.css') }}" id="lightTheme">

    <style>
        @font-face {
            font-family: arabic;
            src: url("{{ asset('fonts/Tajawal-Bold.ttf') }}");
        }

        @font-face {
            font-family: arabic-logo;
            src: url("{{ asset('fonts/BlakaInk-Regular.ttf') }}");
        }

        body,
        html {
            overflow-x: hidden;
        }

        * {
            font-family: arabic;
        }

        .a-hover:hover {
            background-color: #757575b6 !important;
            color: white !important;
        }

        .active {
            background-color: #1b1b1b !important;
            color: white !important;
        }

        .logo-word {
            font-family: arabic-logo;
            font-size: 50px;
            text-align: left;
        }
    </style>

</head>

<body class="vertical light rtl">
    <div class="wrapper">

        @include('includes.aside')


        <main role="main" class="main-content d-flex flex-column">
            <div class="row">
                <form id="form-search" action="{{ route('product.search') }}" class="col d-flex align-items-center">
                    <div class="input-group">
                        <input id="search" type="text" class="form-control" placeholder="بحث">
                        <div class="input-group-append">
                            <button class="btn btn-dark" type="submit" id="button-search"><span
                                    class="fe fe-search"></span></button>
                        </div>
                    </div>
                </form>

                <div class="d-flex flex-column justify-content-center">
                    <button class="btn btn-info d-flex align-items-center" id="refresh">
                        <span class="fe fe-16 fe-refresh-cw mr-2"></span>
                        تحديث الصفحة
                    </button>
                </div>

                <h1 class="logo-word col">عطور السعادة</h1>
            </div>

            @yield('content')

            <p class="mt-auto text-muted text-center" dir="ltr">2024 © <a
                    href="https://www.facebook.com/samirHussein011" target="_blank">Samir Hussein</a></p>
        </main> <!-- main -->
    </div> <!-- .wrapper -->
    <script src="{{ asset('dashboard/js/jquery.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/popper.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/moment.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('dashboard/js/jquery.stickOnScroll.js') }}"></script>
    <script src="{{ asset('dashboard/js/tinycolor-min.js') }}"></script>
    <script src="{{ asset('dashboard/js/config.js') }}"></script>

    @yield('script')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("button[type='submit']").click(function() {
            var parentForm = $(this).closest('form');

            // Disable the button
            $(this).prop('disabled', true);

            // change its text or perform other actions
            $(this).text("انتظر...");

            parentForm.submit();
        });

        $('#refresh').click(function() {
            location.reload();
        });
    </script>

    <script src="{{ asset('dashboard/js/apps.js') }}"></script>

</body>

</html>
