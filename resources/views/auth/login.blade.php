<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E-high</title>

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Nunito|Poppins" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="row justify-content-center">
          <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

            <!-- Logo -->
            <div class="d-flex justify-content-center py-4">
              <a href="#" class="logo d-flex align-items-center w-auto">
                <img src="assets/img/logo.png" alt="Logo">
                <span class="d-none d-lg-block ">E-high</span>
              </a>
            </div>

            <!-- Login Card -->
            <div class="card mb-3 border border">
              <div class="card-body">

                <!-- Login Form Title -->
                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">Connexion à votre compte</h5>
                  <p class="text-center small">Entrez votre identifiant et mot de passe pour vous connecter</p>
                </div>

                <!-- Formulaire de connexion avec Blade et gestion des erreurs -->
                <form class="row g-3 needs-validation" method="POST" action="{{ route('login') }}" novalidate>
                  @csrf

                  <!-- Email Address -->
                  <div class="col-12">
                    <label for="email" class="form-label ">Email</label>
                    <div class="input-group has-validation">
                      <span class="input-group-text" id="inputGroupPrepend">@</span>
                      <input type="email" name="email" class="form-control @error('email') is-invalid @enderror " id="email" value="{{ old('email') }}" required autofocus>
                      @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  <!-- Password -->
                  <div class="col-12">
                    <label for="password" class="form-label ">Mot de passe</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required>
                    @error('password')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <!-- Remember Me -->
                  <div class="col-12">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" @checked(old('remember'))>
                      <label class="form-check-label " for="rememberMe">Se souvenir de moi</label>
                    </div>
                  </div>

                  <!-- Submit Button -->
                  <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit">Se connecter</button>
                  </div>

                  <!-- Forgot Password Link -->
                  <div class="col-12 text-center">
                    @if (Route::has('password.request'))
                      <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                        {{ __('Mot de passe oublié ?') }}
                      </a>
                    @endif
                  </div>

                  <!-- Register Link -->
                  <div class="col-12 text-center">
                    <p class="small mb-0">Vous n'avez pas de compte ? <a href="{{ route('register') }}">Créer un compte</a></p>
                  </div>
                </form>

              </div>
            </div>

            <!-- Footer -->
            <div class="credits">
            </div>

          </div>
        </div>
      </section>
    </div>
  </main>

  <!-- Back to Top Button -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="fa fa-arrow-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
