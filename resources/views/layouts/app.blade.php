<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <title>NPE</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" >
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('logo.jpeg')}}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/app.css">
    <!-- Styles -->
</head>

<body>
    <div id="page-loader" style="background-image: url('/images/pageload-spinner.gif');display:none;">
            
    </div>
    <div id="app">
        
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm color-principal">
            <div class="container justify-content-center">

                <img src="{{url('/images/banner.svg')}}" alt="Image" style="max-height:117px;" />

            </div>
        </nav>

        <main class="py-4 container">
            <a style="float: right;" class="btn btn-secondary" href="{{url('/') }}/logout">Cerrar Sesion</a>
            <a style="float: left;display:none;" class="btn btn-secondary" id="btn-back-home" href="{{url('/creacion_npe') }}">
                <i class="fa fa-arrow-circle-left" style="margin-right: 10px;"></i>Regresar
            </a>
            @yield('content')

        </main>
        <footer class="footer">
            <div class="container text-white">
                <br>
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-4">
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 d-flex justify-content-center">
                        <img src="{{url('/images/banner.svg')}}" alt="Image" style="max-height:117px;" />
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">

                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/6.0.5/imask.min.js" integrity="sha512-0ctiD2feH7vdHZ5jjAKNYts4h+IBRq7Nm5wACMJG1Pj5AQyprSHzX/ijMm77AcLLW5cemQptH+9EcviiKCC0cQ==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('script')
</body>

</html>