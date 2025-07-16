<header id="header" class="header d-flex align-items-center fixed-top">
  <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <div class="d-flex align-items-center me-auto" style="gap: 0;">
        <img src="{{ asset('assets/frontend/img/TestHive_logo.png') }}" alt="TestHive Logo" style="height: 120px;">
        <h1 class="sitename m-0" style="font-size: 2rem; font-weight: 600; color: #0c2e8a; line-height: 1;">TestHive</h1>
      </div>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home<br></a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#services">Services</a></li>
          <li><a href="#team">Team</a></li>
        @guest
            @if (Route::has('login'))
                <li class="scroll-to-section">
                    <a class="btn-getstarted flex-md-shrink-0" href="{{ route('login') }}">Mulai Sekarang</a>
                </li>
            @endif
        @else
      <a class="btn-getstarted flex-md-shrink-0" href="{{ route('dashboard') }}">Dashboard</a>
      @endguest
    </nav>
  </div>
</header>