<!DOCTYPE html>
<html lang="en">

<head>
    @trixassets
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
  <script src="{{asset('assets/vendor/chart.js/chart.js')}}"></script>
  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Jan 09 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="/dashboard" class="logo d-flex align-items-center">
        <img src="{{asset('assets/img/logo.png')}}" alt="" >
        <span style="font-family: " class="d-none d-lg-block">E-high</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">

                @auth
                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person"></i>
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                      <li class="dropdown-header">
                        <h6>{{ Auth::user()->name }}</h6>
                        <span>{{ Auth::user()->email }}</span>
                      </li>
                      <li>
                        <hr class="dropdown-divider">
                      </li>
                      <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                          <i class="bi bi-box-arrow-right"></i>
                          <span>Sign Out</span>
                        </a>
                      </li>

                    </ul><!-- End Profile Dropdown Items -->
                  </li><!-- End Profile Nav -->
                    @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endif
                @endauth
            </div>

        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <!-- Stats -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="/stats">
          <i class="bi bi-graph-up"></i>
          <span>Stats</span>
        </a>
      </li>

      <!-- Classement examen -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="/form_classement_examen">
          <i class="bi bi-trophy"></i>
          <span>Classement d'examen</span>
        </a>
      </li>

      <!-- Formulaire note -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="/formNote">
          <i class="bi bi-pencil-square"></i>
          <span>Formulaire note</span>
        </a>
      </li>

      <!-- Eleves -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="/eleve">
          <i class="bi bi-people"></i>
          <span>Élèves</span>
        </a>
      </li>

      <!-- Classes -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="/niveau">
          <i class="bi bi-building"></i>
          <span>Classes</span>
        </a>
      </li>

      <!-- Professeurs -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="/prof">
          <i class="bi bi-person-badge"></i>
          <span>Professeurs</span>
        </a>
      </li>

      <!-- Examens (déplacé ici) -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="/exam">
          <i class="bi bi-journal-text"></i>
          <span>Examens</span>
        </a>
      </li>

      <!-- Matières -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="/Matiere">
          <i class="bi bi-book"></i>
          <span>Matières</span>
        </a>
      </li>

      <!-- Périodes -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="/periode">
          <i class="bi bi-clock-history"></i>
          <span>Périodes</span>
        </a>
      </li>

      <!-- Années scolaires -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="/annesco">
          <i class="bi bi-calendar3"></i>
          <span>Années scolaires</span>
        </a>
      </li>

      <!-- Utilisateurs -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="/user">
          <i class="bi bi-person-gear"></i>
          <span>Utilisateurs</span>
        </a>
      </li>

    </ul>

  </aside>
  <!-- End Sidebar -->

  <main id="main" class="main">

    @if ($errors->any())
    huhu
    gyugyug
    gyfyfy
    vhchcg
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    @yield('content')

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>E-high</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{asset('assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('assets/js/main.js')}}"></script>
  <script src="{{asset('assets/vendor/chart.js/chart.js')}}"></script>
  <script>
    function confirmer() {
        if (confirm('Delete selected item?')){return true;}else{event.stopPropagation(); event.preventDefault();};
        }
    </script>
</body>

</html>
