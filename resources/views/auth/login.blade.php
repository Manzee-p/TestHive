<!doctype html>

<html
  lang="en"
  class="layout-wide customizer-hide"
  data-assets-path="/assets/"
  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>TestHive</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/backend/login/img/favicon/favicon.icons')}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/backend/login/vendor/fonts/iconify-icons.css')}}" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="{{ asset('assets/backend/login/vendor/css/core.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/backend/login/css/demo.css')}}" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="{{ asset('assets/backend/login/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

    <!-- endbuild -->

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/backend/login/vendor/css/pages/page-auth.css')}}" />

    <!-- Helpers -->
    <script src="{{ asset('assets/backend/login/vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="{{ asset('assets/backend/login/js/config.js')}}"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card px-sm-6 px-0">
            <div class="card-body"> 
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link d-flex align-items-center" style="gap: 2px;">
                  <img src="{{ asset('assets/frontend/img/TestHive_logo4.png') }}" alt="TestHive Logo" style="height: 50px; margin-right: 4px;">
                  <span class="app-brand-text demo text-heading">TestHive</span>
                </a>
              </div>
                <!-- /Logo -->
              <h4 class="mb-1">Selamat Datang di TestHive! 👋</h4>

              <form id="formAuthentication" class="mb-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-6">
                  <label for="email" class="form-label">Masukan Email atau Username</label>
                  <input
                    type="text"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required autocomplete="email"
                    placeholder="Enter your email or username"
                    autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-6 form-password-toggle">
                  <label class="form-label" for="password">Password</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control form-control @error('password') is-invalid @enderror"
                      name="password"
                      required autocomplete="current-password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password" />
                    @error('password')
                        <span class="input-group-text cursor-pointer invalid-feedback" role="alert"><i class="icon-base bx bx-hide"></i></span>
                    @enderror
                  </div>
                </div>
                <div class="mb-8">
                  <div class="d-flex justify-content-between">
                    <div class="form-check mb-0">
                      <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                      <label class="form-check-label" for="remember-me"> Remember Me </label>
                    </div>
                      @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            <span>Forgot Password?</span>
                        </a>
                    @endif
                  </div>
                </div>
                <div class="mb-6">
                  <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                </div>
              </form>
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->

    <script src="{{ asset('assets/backend/login/vendor/libs/jquery/jquery.js')}}"></script>

    <script src="{{ asset('assets/backend/login/vendor/libs/popper/popper.j')}}s"></script>
    <script src="{{ asset('assets/backend/login/vendor/js/bootstrap.js')}}"></script>

    <script src="{{ asset('assets/backend/login/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

    <script src="{{ asset('assets/backend/login/vendor/js/menu.js')}}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->

    <script src="{{ asset('assets/js/main/login.js')}}"></script>

    <!-- Page JS -->

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>