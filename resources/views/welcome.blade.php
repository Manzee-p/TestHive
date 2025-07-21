<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>TestHive Ujian Oline</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('assets/frontend/img/TestHive_logo.png')}}" rel="icon">
  <link href="{{ asset('assets/frontend/img/TestHive_logo.png')}}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/frontend/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/frontend/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/frontend/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/frontend/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/frontend/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets/frontend/css/main.css')}}" rel="stylesheet">

</head>

<body class="index-page">

  @include('layouts.components-frontend.header')

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
            <h1 data-aos="fade-up">Solusi Cerdas untuk Pengelolaan Ujian Online</h1>
            <p data-aos="fade-up" data-aos-delay="100">Platform inovatif untuk membuat, mengelola, dan menganalisis ujian online dengan efisien dan aman</p>
          </div>
          <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out">
            <img src="{{ asset('assets/frontend/img/hero-img.png')}}" class="img-fluid animated" alt="">
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container" data-aos="fade-up">
        <div class="row gx-0">

          <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <div class="content">
              <h3>Who We Are</h3>
              <h2>Kami membangun platform ujian online yang efisien, aman, dan mudah digunakan untuk semua kalangan pendidikan.</h2>
              <p>
                TestHive hadir sebagai solusi modern untuk pembuatan, pelaksanaan, dan evaluasi ujian berbasis digital. Dengan fitur lengkap dan antarmuka ramah pengguna, kami membantu institusi dan pendidik menyelenggarakan ujian dengan lancar dan terpercaya.
              </p>
            </div>
          </div>

          <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
            <img src="{{ asset('assets/frontend/img/about.jpg')}}" class="img-fluid" alt="">
          </div>

        </div>
      </div>

    </section><!-- /About Section -->

    <!-- Values Section -->
    <section id="values" class="values section">

  <!-- Judul Bagian -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Nilai-Nilai Kami</h2>
    <p>Prinsip utama yang kami pegang dalam membangun platform ujian online</p>
  </div><!-- End Section Title -->

  <div class="container">

    <div class="row gy-4">

      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card">
          <img src="{{ asset('assets/frontend/img/values-1.png')}}" class="img-fluid" alt="">
          <h3>Integritas & Keadilan</h3>
          <p>Kami memastikan setiap ujian berjalan secara adil dan transparan, menjaga kejujuran dan kredibilitas hasil ujian.</p>
        </div>
      </div><!-- End Card Item -->

      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
        <div class="card">
          <img src="{{ asset('assets/frontend/img/values-2.png')}}" class="img-fluid" alt="">
          <h3>Inovasi & Kemudahan</h3>
          <p>Kami menggabungkan teknologi terbaru dengan tampilan antarmuka yang mudah digunakan bagi guru maupun siswa.</p>
        </div>
      </div><!-- End Card Item -->

      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
        <div class="card">
          <img src="{{ asset('assets/frontend/img/values-3.png')}}" class="img-fluid" alt="">
          <h3>Keamanan & Keandalan</h3>
          <p>Platform kami dirancang dengan sistem keamanan tinggi dan performa yang stabil untuk mendukung setiap sesi ujian.</p>
        </div>
      </div><!-- End Card Item -->

    </div>

  </div>

</section><!-- /Values Section -->

    <!-- Bagian Fitur -->
    <section id="features" class="features section">

      <!-- Judul Seksi -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Fitur</h2>
        <p>Fitur Unggulan dari TestHive<br></p>
      </div><!-- Akhir Judul Seksi -->

      <div class="container">

        <div class="row gy-5">

          <div class="col-xl-6" data-aos="zoom-out" data-aos-delay="100">
            <img src="{{ asset('assets/frontend/img/features.png')}}" class="img-fluid" alt="Fitur TestHive">
          </div>

          <div class="col-xl-6 d-flex">
            <div class="row align-self-center gy-4">

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Ujian Online Interaktif</h3>
                </div>
              </div><!-- Akhir Item Fitur -->

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Soal Acak & Jawaban Dinamis</h3>
                </div>
              </div><!-- Akhir Item Fitur -->

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Penilaian Otomatis & Real-time</h3>
                </div>
              </div><!-- Akhir Item Fitur -->

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Laporan Hasil Lengkap</h3>
                </div>
              </div><!-- Akhir Item Fitur -->

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Manajemen Kelas & Kategori</h3>
                </div>
              </div><!-- Akhir Item Fitur -->

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="700">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Tampilan Modern & Responsif</h3>
                </div>
              </div><!-- Akhir Item Fitur -->

            </div>
          </div>

        </div>

      </div>

    </section><!-- /Bagian Fitur -->


    <!-- Bagian Fitur Tambahan -->
    <section id="alt-features" class="alt-features section">

      <div class="container">

        <div class="row gy-5">

          <div class="col-xl-7 d-flex order-2 order-xl-1" data-aos="fade-up" data-aos-delay="200">

            <div class="row align-self-center gy-5">

              <div class="col-md-6 icon-box">
                <i class="bi bi-award"></i>
                <div>
                  <h4>Sertifikat Otomatis</h4>
                  <p>TestHive menyediakan fitur cetak sertifikat otomatis setelah menyelesaikan ujian dengan skor tertentu.</p>
                </div>
              </div><!-- Akhir Item Fitur -->

              <div class="col-md-6 icon-box">
                <i class="bi bi-card-checklist"></i>
                <div>
                  <h4>Bank Soal Terkelola</h4>
                  <p>Kelola ribuan soal berdasarkan kategori, tingkat kesulitan, dan tipe ujian secara efisien.</p>
                </div>
              </div><!-- Akhir Item Fitur -->

              <div class="col-md-6 icon-box">
                <i class="bi bi-dribbble"></i>
                <div>
                  <h4>Mode Ujian Fleksibel</h4>
                  <p>Dukung berbagai format: latihan, tryout, ujian resmi, atau simulasi dengan waktu yang bisa diatur.</p>
                </div>
              </div><!-- Akhir Item Fitur -->

              <div class="col-md-6 icon-box">
                <i class="bi bi-filter-circle"></i>
                <div>
                  <h4>Anti-Kecurangan</h4>
                  <p>Dilengkapi fitur acak soal & jawaban, timer, serta pelacakan aktivitas peserta selama ujian.</p>
                </div>
              </div><!-- Akhir Item Fitur -->

              <div class="col-md-6 icon-box">
                <i class="bi bi-lightning-charge"></i>
                <div>
                  <h4>Kinerja Cepat & Stabil</h4>
                  <p>Didukung oleh teknologi Laravel & optimasi performa, TestHive tetap responsif meskipun banyak peserta aktif.</p>
                </div>
              </div><!-- Akhir Item Fitur -->

              <div class="col-md-6 icon-box">
                <i class="bi bi-patch-check"></i>
                <div>
                  <h4>Validasi Nilai Otomatis</h4>
                  <p>Setiap nilai langsung terakumulasi, tervalidasi, dan dapat diekspor dalam format laporan yang rapi.</p>
                </div>
              </div><!-- Akhir Item Fitur -->

            </div>

          </div>

          <div class="col-xl-5 d-flex align-items-center order-1 order-xl-2" data-aos="fade-up" data-aos-delay="100">
            <img src="{{ asset('assets/frontend/img/alt-features.png')}}" class="img-fluid" alt="Fitur Tambahan TestHive">
          </div>

        </div>

      </div>

    </section><!-- /Bagian Fitur Tambahan -->


    <!-- Bagian Layanan -->
    <section id="services" class="services section">

      <!-- Judul Seksi -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Layanan</h2>
        <p>Lihat Layanan dari TestHive<br></p>
      </div><!-- Akhir Judul Seksi -->

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item item-cyan position-relative">
              <i class="bi bi-activity icon"></i>
              <h3>Manajemen Ujian</h3>
              <p>Atur jadwal, durasi, dan jenis ujian dengan mudah. Mendukung berbagai tipe soal seperti pilihan ganda, benar/salah, dan esai.</p>
              <a href="#" class="read-more stretched-link"><span>Selengkapnya</span> <i class="bi bi-arrow-right"></i></a>
            </div>
          </div><!-- Akhir Item Layanan -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item item-orange position-relative">
              <i class="bi bi-broadcast icon"></i>
              <h3>Ujian Online Real-time</h3>
              <p>Peserta dapat mengikuti ujian secara daring dengan waktu nyata dan sistem otomatis yang memantau setiap aktivitas.</p>
              <a href="#" class="read-more stretched-link"><span>Selengkapnya</span> <i class="bi bi-arrow-right"></i></a>
            </div>
          </div><!-- Akhir Item Layanan -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item item-teal position-relative">
              <i class="bi bi-easel icon"></i>
              <h3>Dashboard & Statistik</h3>
              <p>Lihat grafik performa siswa, jumlah ujian, dan rata-rata nilai melalui dashboard yang informatif dan interaktif.</p>
              <a href="#" class="read-more stretched-link"><span>Selengkapnya</span> <i class="bi bi-arrow-right"></i></a>
            </div>
          </div><!-- Akhir Item Layanan -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
            <div class="service-item item-red position-relative">
              <i class="bi bi-bounding-box-circles icon"></i>
              <h3>Manajemen Siswa & Kelas</h3>
              <p>Kelola data siswa, kelas, dan pembagian peserta ujian sesuai kategori atau jenjang pendidikan dengan praktis.</p>
              <a href="#" class="read-more stretched-link"><span>Selengkapnya</span> <i class="bi bi-arrow-right"></i></a>
            </div>
          </div><!-- Akhir Item Layanan -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
            <div class="service-item item-indigo position-relative">
              <i class="bi bi-calendar4-week icon"></i>
              <h3>Penjadwalan Otomatis</h3>
              <p>Ujian dapat dijadwalkan dan dibuka otomatis sesuai waktu yang ditentukan, termasuk batas waktu pengerjaan.</p>
              <a href="#" class="read-more stretched-link"><span>Selengkapnya</span> <i class="bi bi-arrow-right"></i></a>
            </div>
          </div><!-- Akhir Item Layanan -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
            <div class="service-item item-pink position-relative">
              <i class="bi bi-chat-square-text icon"></i>
              <h3>Laporan & Analisis Hasil</h3>
              <p>Hasil ujian langsung dirangkum dalam laporan lengkap per siswa, lengkap dengan analisis nilai dan grafik performa.</p>
              <a href="#" class="read-more stretched-link"><span>Selengkapnya</span> <i class="bi bi-arrow-right"></i></a>
            </div>
          </div><!-- Akhir Item Layanan -->

        </div>

      </div>

    </section><!-- /Bagian Layanan -->

    <!-- Clients Section -->

    <!-- Contact Section -->
  </main>

  <footer id="footer" class="footer">
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="d-flex align-items-center">
            <span class="sitename">TestHive</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Jl. Pendidikan No. 108</p>
            <p>Bandung, Jawa Barat 40123</p>
            <p class="mt-3"><strong>Telepon:</strong> <span>+62 812 3456 7890</span></p>
            <p><strong>Email:</strong> <span>support@testhive.id</span></p>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Link Berguna</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Beranda</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Tentang Kami</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Layanan</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Syarat & Ketentuan</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Layanan Kami</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Ujian Online</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Bank Soal</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Penilaian Otomatis</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Laporan Hasil</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12">
          <h4>Ikuti Kami</h4>
          <p>Dapatkan informasi terbaru seputar fitur dan pembaruan TestHive melalui media sosial kami.</p>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Hak Cipta</span> <strong class="px-1 sitename">TestHive</strong> <span>Seluruh Hak Dilindungi</span></p>
    </div>
  </footer>


  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/frontend/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('assets/frontend/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{ asset('assets/frontend/vendor/aos/aos.js')}}"></script>
  <script src="{{ asset('assets/frontend/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{ asset('assets/frontend/vendor/purecounter/purecounter_vanilla.js')}}"></script>
  <script src="{{ asset('assets/frontend/vendor/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
  <script src="{{ asset('assets/frontend/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{ asset('assets/frontend/vendor/swiper/swiper-bundle.min.js')}}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assets/frontend/js/main.js')}}"></script>

</body>

</html>