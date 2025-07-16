<aside class="left-sidebar with-vertical">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('admin.quiz-terbaru') }}" class="text-nowrap logo-img">
                <img src="{{ asset('/assets/backend/images/logos/logo-TestHivee.png') }}" class="dark-logo m-1" alt="Logo-Dark" style="width: 200px;"/>
                <img src="{{ asset('/assets/backend/images/logos/logo-TestHivee.png') }}" class="light-logo m-1" alt="Logo-light" style="width: 200px;" />
            </a>
            <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
                <i class="ti ti-x"></i>
            </a>
        </div>

        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
            @if (Auth::user()->isAdmin == '1' || Auth::user()->isAdmin == '2' )
                @php
                    // Hitung jumlah esai yang belum dinilai untuk admin yang login
                    $pendingEssayCount = 0;
                    try {
                        $pendingEssayCount = App\Models\HasilUjianDetail::whereHas('soal', function($query) {
                            $query->where('tipe', 'essay');
                        })
                        ->whereHas('hasilUjian.quiz', function($query) {
                            $query->where('user_id', Auth::id());
                        })
                        ->where('status_jawaban', 'pending')
                        ->count();
                    } catch (\Exception $e) {
                        // Jika ada error, set ke 0
                        $pendingEssayCount = 0;
                    }
                @endphp

                <ul id="sidebarnav">
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Dashboard</span>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('admin.quiz-terbaru') ? 'active' : '' }}">
                        <a class="sidebar-link justify-content-between" href="{{ route('admin.quiz-terbaru') }}">
                            <div class="d-flex align-items-center gap-3">
                                <span class="d-flex"><i class="ti ti-home"></i></span>
                                <span class="hide-menu">Beranda</span>
                            </div>
                            <span class="hide-menu badge rounded-pill border border-primary text-primary fs-2 py-1 px-2">★</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('quiz.hasil.*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('quiz.hasil.keseluruhan') }}">
                            <div class="d-flex align-items-center gap-3">
                                <span class="d-flex"><i class="ti ti-chart-bar"></i></span>
                                <span class="hide-menu">Hasil Quiz</span>
                            </div>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('quiz.essay.*') ? 'active' : '' }}">
                        <a class="sidebar-link justify-content-between" href="{{ route('quiz.essay.grading') }}">
                            <div class="d-flex align-items-center gap-3">
                                <span class="d-flex position-relative">
                                    <i class="ti ti-edit"></i>
                                    @if($pendingEssayCount > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                            {{ $pendingEssayCount > 9 ? '9+' : $pendingEssayCount }}
                                        </span>
                                    @endif
                                </span>
                                <span class="hide-menu">Penilaian Esai</span>
                            </div>
                            @if($pendingEssayCount > 0)
                                <span class="badge bg-warning text-dark rounded-pill">{{ $pendingEssayCount }}</span>
                            @else
                                <span class="badge bg-success text-white rounded-pill">0</span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Kelola Data</span>
                    </li>
                    @if (Auth::user()->isAdmin == '2')
                        <li class="sidebar-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('users.index') }}">
                                <span class="d-flex"><i class="ti ti-users"></i></span>
                                <span class="hide-menu">User</span>
                            </a>
                        </li>
                    @endif
                    <li class="sidebar-item {{ request()->routeIs('kelas.index') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('kelas.index') }}">
                            <span class="d-flex"><i class="ti ti-school"></i></span>
                            <span class="hide-menu">Kelas</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('kategori.index') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('kategori.index') }}">
                            <span class="d-flex"><i class="ti ti-tags"></i></span>
                            <span class="hide-menu">Kategori</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('matapelajaran.index') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('matapelajaran.index') }}">
                            <span class="d-flex"><i class="ti ti-book"></i></span>
                            <span class="hide-menu">Mata Pelajaran</span>
                        </a>
                    </li>

                    {{-- *** KELOLAH QUIZ - TANPA SUBMENU PENILAIAN ESAI *** --}}
                    <li class="sidebar-item has-arrow {{ request()->is('admin/quiz*') && !request()->routeIs('quiz.essay.*') ? 'active' : '' }}">
                        <a class="sidebar-link has-arrow" href="#quizSubmenu" data-bs-toggle="collapse" data-bs-target="#quizSubmenu" aria-expanded="{{ request()->is('admin/quiz*') && !request()->routeIs('quiz.essay.*') ? 'true' : 'false' }}" aria-controls="quizSubmenu">
                            <span class="d-flex"><i class="ti ti-chart-donut-3"></i></span>
                            <span class="hide-menu">Kelolah Quiz</span>
                        </a>
                        <ul id="quizSubmenu" class="collapse first-level {{ request()->is('admin/quiz*') && !request()->routeIs('quiz.essay.*') ? 'show' : '' }}">
                            <li class="sidebar-item {{ request()->routeIs('quiz.index') ? 'active' : '' }}">
                                <a href="{{ route('quiz.index') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Lihat Quiz</span>
                                </a>
                            </li>
                            <li class="sidebar-item {{ request()->routeIs('quiz.create') ? 'active' : '' }}">
                                <a href="{{ route('quiz.create') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Buat Quiz</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            @else
                <ul id="sidebarnav">
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Beranda Quiz</span>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a class="sidebar-link justify-content-between" href="{{ route('dashboard') }}">
                            <div class="d-flex align-items-center gap-3">
                                <span class="d-flex"><i class="ti ti-home"></i></span>
                                <span class="hide-menu">Quiz Terbaru</span>
                            </div>
                            <span class="hide-menu badge rounded-pill border border-primary text-primary fs-2 py-1 px-2">★</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('histori-pengerjaan') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('histori-pengerjaan') }}">
                            <span class="d-flex"><i class="ti ti-user"></i></span>
                            <span class="hide-menu">Riwayat Pengerjaan</span>
                        </a>
                    </li>
                </ul>
            @endif
        </nav>
    </div>
</aside>

<style>
    .sidebar-item.active > .sidebar-link {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #0d6efd;
        border-radius: 0.375rem;
    }

    .sidebar-item.active i {
        color: #0d6efd;
    }

    /* *** STYLING untuk notification badge *** */
    .sidebar-link .badge {
        font-size: 0.75rem;
        min-width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .position-relative .badge {
        z-index: 10;
    }

    /* Animasi untuk badge notification */
    .badge.bg-danger {
        animation: pulse 2s infinite;
    }

    .badge.bg-warning {
        animation: glow 2s infinite alternate;
    }

    /* Badge hijau untuk status "no pending" */
    .badge.bg-success {
        opacity: 0.8;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    @keyframes glow {
        from { box-shadow: 0 0 5px rgba(255, 193, 7, 0.5); }
        to { box-shadow: 0 0 10px rgba(255, 193, 7, 0.8); }
    }

    /* Responsive badge pada mobile */
    @media (max-width: 768px) {
        .sidebar-link .badge {
            font-size: 0.65rem;
            min-width: 16px;
            height: 16px;
        }
    }
</style>