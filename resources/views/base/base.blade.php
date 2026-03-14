<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>E-high</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

        <!-- Favicons -->
        <link href="{{asset('assets/img/favicon.png')}}" rel="icon">
        <link href="{{asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

        <!-- Google Fonts -->
        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
        <link href="{{asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
        <link href="{{asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
        <link href="{{asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
        <link href="{{asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
        <script src="{{asset('assets/js/Chart.js')}}"></script>
        <!-- =======================================================
        * Template Name: NiceAdmin
        * Updated: Jan 09 2024 with Bootstrap v5.3.2
        * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
        * Author: BootstrapMade.com
        * License: https://bootstrapmade.com/license/
        ======================================================== -->
    </head>
    <body class="">
    <!-- ======= Header ======= -->
    <header class=" p-3 bg-white text-light">
            <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="/" class="nav-link px-2 text-secondary"><img src="{{asset('assets/img/logo.png')}}" width="26" alt="" >
                    Pubbee</a></li>
                    <li><a href="/About" class="nav-link px-2 text-secondary">About us</a></li>
                    <li><a href="/Packages" class="nav-link px-2 text-secondary">Packages</a></li>
                    <li><a href="/Contacts" class="nav-link px-2 text-secondary">Contact</a></li>
                    @foreach ($currency as $c)
                    @if ($c->afficher==1)
                        <li><a href="/cms/{{ $c->slug }}" class="nav-link px-2 text-secondary">{{ $c->title }}</a></li>
                    @endif
                    @endforeach
                </ul>
                <div class="text-end">
                        @auth


                        <a class="nav-link nav-profile d-flex align-items-center pe-0 text-black" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person"></i>
                            <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->email }}</span>
                        </a><!-- End Profile Iamge Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                          <li class="dropdown-header">
                            <h6>{{ Auth::user()->name }}</h6>
                          </li>
                          @auth()
                              @if (Auth::user()->type==1)
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="/dashboard">
                                    <span>Dashboard</span>
                                    </a>
                                </li>
                              @endif
                          @endauth
                          <li>
                            <hr class="dropdown-divider">
                          </li>
                          <li>
                            <a class="dropdown-item d-flex align-items-center" href="/mesCommande">
                              <span>Mes commandes</span>
                            </a>
                          </li>
                         <li>
                            <hr class="dropdown-divider">
                          </li>
                          <li>
                            <a class="dropdown-item d-flex align-items-center" href="/mesCompaign">
                              <span>Mes campaignes</span>
                            </a>
                          </li>
                         <li>
                            <hr class="dropdown-divider">
                          </li>
                          <li>
                            <a class="dropdown-item d-flex align-items-center" href="/Param?id={{ Auth::id() }}">
                              <span>Modifier mes informations</span>
                            </a>
                          </li>
                         <li>
                            <hr class="dropdown-divider">
                          </li>
                          <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                              <span>Déconnection</span>
                            </a>
                          </li>
                        </ul><!-- End Profile Dropdown Items -->
                    @else
                    <a href="{{ route('login') }}"> <button type="button" class="btn btn-outline-black me-2">Log in</button></a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" ><button type="button" class="btn btn-primary">Register</button></a>
                    @endif
                    @endauth
                </div>
            </div>
            </div>
        </header>
    <!-- ======= Sidebar ======= -->

    <div class="container" style="margin-top:50px">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        @yield('content')
    </div>



    <!-- ======= Footer ======= -->
    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <p class="col-md-4 mb-0 text-muted">© 2024 Pubbee, Inc</p>

        <a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-light text-decoration-none ">
            <img src="{{asset('assets/img/logo.png')}}" width="26" alt="" >
        </a>

        <ul class="nav col-md-4 justify-content-end">
            <li class="nav-item"><a href="/" class="nav-link px-2 text-muted">Home</a></li>
            <li class="nav-item"><a href="/About" class="nav-link px-2 text-muted">About us</a></li>
            <li class="nav-item"><a href="/Packages" class="nav-link px-2 text-muted">Package</a></li>
            <li class="nav-item"><a href="/formContact" class="nav-link px-2 text-muted">Contact</a></li>
        </ul>
        </footer>
    </div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/vendor/chart.js/chart.umd.js')}}"></script>
    <script src="{{asset('assets/vendor/echarts/echarts.min.js')}}"></script>
    <script src="{{asset('assets/vendor/quill/quill.min.js')}}"></script>
    <script src="{{asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
    <script src="{{asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>

    <!-- Template Main JS File -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="{{asset('assets/vendor/chart.js/chart.js')}}"></script>
    </body>
</html>
