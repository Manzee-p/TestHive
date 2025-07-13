<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="{{ asset('assets/frontend/img/logo.png')}}" alt="">
        <h1 class="sitename">FlexStart</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home<br></a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#services">Services</a></li>
          <li><a href="#portfolio">Portfolio</a></li>
          <li><a href="#team">Team</a></li>
          <li><a href="blog.html">Blog</a></li>
      </nav>
        @guest
            @if (Route::has('login'))
                <li class="scroll-to-section">
                    <a class="btn-getstarted flex-md-shrink-0" href="{{ route('login') }}">Mulai Sekarang</a>
                </li>
            @endif
        @else
      <a class="btn-getstarted flex-md-shrink-0" href="{{ route('dashboard') }}">Dashboard</a>
      @endguest
    </div>
  </header>