@extends('layouts.backend')
@section('content')
    @include('layouts.components-backend.css')
    <div class="container-fluid">
        <!-- Enhanced Header Section -->
        <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5">
            <div class="card-body px-4 py-4">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h3 class="fw-bold mb-3 text-white">Penilaian Jawaban Esai</h3>
                        <p class="text-white-75 mb-3">Pilih peserta untuk menilai jawaban esai mereka.</p>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light">
                                <li class="breadcrumb-item">
                                    <a class="text-white text-decoration-none" href="{{ route('admin.quiz-terbaru') }}">
                                        <i class="ti ti-home me-1"></i>Dashboard
                                    </a>
                                </li>
                                <li class="breadcrumb-item active text-white-75" aria-current="page">
                                    Penilaian Esai
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Modal for User Details -->
                    <div class="modal fade" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-gradient-primary text-white">
                                    <h5 class="modal-title" id="userDetailsModalLabel">
                                        <i class="ti ti-user me-2"></i>Detail Penilaian Peserta
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4 text-center mb-4">
                                            <div class="user-avatar-large mx-auto mb-3" id="modalUserAvatar">
                                                <!-- Avatar will be inserted here -->
                                            </div>
                                            <h4 id="modalUserName" class="mb-1"></h4>
                                            <p class="text-muted" id="modalUserEmail"></p>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <div class="stat-card">
                                                        <div class="stat-icon-small bg-success-subtle">
                                                            <i class="ti ti-file-check text-success"></i>
                                                        </div>
                                                        <div class="stat-info">
                                                            <h3 id="modalTotalEssays" class="mb-0"></h3>
                                                            <small class="text-muted">Total Essays Graded</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <div class="stat-card">
                                                        <div class="stat-icon-small bg-warning-subtle">
                                                            <i class="ti ti-trophy text-warning"></i>
                                                        </div>
                                                        <div class="stat-info">
                                                            <h3 id="modalAvgScore" class="mb-0"></h3>
                                                            <small class="text-muted">Average Score</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="performance-breakdown mt-4">
                                                <h6 class="mb-3">Performance Breakdown</h6>
                                                <div class="progress-item mb-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <span class="text-success">
                                                            <i class="ti ti-check-circle me-1"></i>Jawaban Benar
                                                        </span>
                                                        <span id="modalCorrectCount" class="fw-bold"></span>
                                                    </div>
                                                    <div class="progress" style="height: 8px;">
                                                        <div id="modalCorrectBar" class="progress-bar bg-success" role="progressbar"></div>
                                                    </div>
                                                </div>
                                                
                                                <div class="progress-item mb-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <span class="text-warning">
                                                            <i class="ti ti-clock me-1"></i>Jawaban Sebagian
                                                        </span>
                                                        <span id="modalPartialCount" class="fw-bold"></span>
                                                    </div>
                                                    <div class="progress" style="height: 8px;">
                                                        <div id="modalPartialBar" class="progress-bar bg-warning" role="progressbar"></div>
                                                    </div>
                                                </div>
                                                
                                                <div class="progress-item mb-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <span class="text-danger">
                                                            <i class="ti ti-x-circle me-1"></i>Jawaban Salah
                                                        </span>
                                                        <span id="modalIncorrectCount" class="fw-bold"></span>
                                                    </div>
                                                    <div class="progress" style="height: 8px;">
                                                        <div id="modalIncorrectBar" class="progress-bar bg-danger" role="progressbar"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="ti ti-x me-2"></i>Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="text-center">
                            <img src="{{ asset('assets/backend/images/breadcrumb/ChatBc.png') }}" alt="essay-grading"
                                class="img-fluid" style="max-height: 120px; filter: brightness(1.1);" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- Decorative elements -->
            <div class="position-absolute top-0 end-0 opacity-25">
                <div class="bg-white rounded-circle"
                    style="width: 200px; height: 200px; transform: translate(50px, -50px);"></div>
            </div>
            <div class="position-absolute bottom-0 start-0 opacity-25">
                <div class="bg-white rounded-circle"
                    style="width: 150px; height: 150px; transform: translate(-75px, 75px);"></div>
            </div>
        </div>
        
        <!-- Enhanced Stats Cards -->
        <div class="row">
        @php
            // Pastikan $essayAnswers ada, jika tidak buat collection kosong
            $essayAnswers = $essayAnswers ?? collect();
            $groupedByUser = $essayAnswers->groupBy('hasilUjian.user_id');
            $totalUsers = $groupedByUser->count();
            $pendingCount = $essayAnswers->count();
            
            $gradedCount = App\Models\HasilUjianDetail::whereHas('soal', function($query) {
                    $query->where('tipe', 'essay');
                })
                ->whereHas('hasilUjian.quiz', function($query) {
                    $query->where('user_id', Auth::id());
                })
                ->whereIn('status_jawaban', ['benar', 'salah', 'sebagian'])
                ->count();
                
            $totalEssays = App\Models\HasilUjianDetail::whereHas('soal', function($query) {
                    $query->where('tipe', 'essay');
                })
                ->whereHas('hasilUjian.quiz', function($query) {
                    $query->where('user_id', Auth::id());
                })
                ->count();
            
            $progressPercent = $totalEssays > 0 ? round(($gradedCount / $totalEssays) * 100, 1) : 0;
            
            // Get graded users count
            $gradedUsers = App\Models\HasilUjianDetail::whereHas('soal', function($query) {
                    $query->where('tipe', 'essay');
                })
                ->whereHas('hasilUjian.quiz', function($query) {
                    $query->where('user_id', Auth::id());
                })
                ->whereIn('status_jawaban', ['benar', 'salah', 'sebagian'])
                ->with('hasilUjian.user')
                ->get()
                ->groupBy('hasilUjian.user_id')
                ->count();
        @endphp
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm stats-card">
                    <div class="card-body text-center py-4">
                        <div class="rounded-circle bg-warning-subtle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="ti ti-users text-warning" style="font-size: 24px;"></i>
                        </div>
                        <h4 class="fw-bold text-warning mb-1">{{ $totalUsers }}</h4>
                        <p class="text-muted mb-0">Peserta Perlu Dinilai</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm stats-card">
                    <div class="card-body text-center py-4">
                        <div class="rounded-circle bg-info-subtle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="ti ti-clock text-info" style="font-size: 24px;"></i>
                        </div>
                        <h4 class="fw-bold text-info mb-1">{{ $pendingCount }}</h4>
                        <p class="text-muted mb-0">Esai Menunggu</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm stats-card">
                    <div class="card-body text-center py-4">
                        <div class="rounded-circle bg-success-subtle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="ti ti-check text-success" style="font-size: 24px;"></i>
                        </div>
                        <h4 class="fw-bold text-success mb-1">{{ $gradedCount }}</h4>
                        <p class="text-muted mb-0">Esai Sudah Dinilai</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm stats-card">
                    <div class="card-body text-center py-4">
                        <div class="rounded-circle bg-primary-subtle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="ti ti-chart-pie text-primary" style="font-size: 24px;"></i>
                        </div>
                        <h4 class="fw-bold text-primary mb-1">{{ $progressPercent }}%</h4>
                        <p class="text-muted mb-0">Progress Penilaian</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <ul class="nav nav-pills" id="gradingTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pending-tab" data-bs-toggle="pill" data-bs-target="#pending-content" type="button" role="tab">
                                    <i class="ti ti-clock me-2"></i>Perlu Dinilai
                                    <span class="badge bg-warning ms-2">{{ $totalUsers }}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="graded-tab" data-bs-toggle="pill" data-bs-target="#graded-content" type="button" role="tab">
                                    <i class="ti ti-check me-2"></i>Sudah Dinilai
                                    <span class="badge bg-success ms-2">{{ $gradedUsers }}</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('quiz.essay.stats') }}" class="btn btn-info me-2">
                            <i class="ti ti-chart-bar me-2"></i>Statistik
                        </a>
                        <a href="{{ route('quiz.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ti ti-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="ti ti-alert-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Tab Content -->
        <div class="tab-content" id="gradingTabContent">
            <!-- Pending Essays Tab -->
            <div class="tab-pane fade show active" id="pending-content" role="tabpanel">
                @if(isset($essayAnswers) && $essayAnswers->count() > 0)
                    @php
                        $groupedByUser = $essayAnswers->groupBy('hasilUjian.user_id');
                    @endphp
                    
                    <div class="row">
                        @foreach($groupedByUser as $userId => $userEssays)
                            @php
                                $user = $userEssays->first()->hasilUjian->user;
                                $totalBobotUser = $userEssays->sum('bobot_soal');
                                $uniqueQuizzes = $userEssays->groupBy('hasilUjian.quiz_id');
                                $quizCount = $uniqueQuizzes->count();
                                $essayCount = $userEssays->count();
                                
                                // Determine priority
                                $priorityClass = $essayCount > 5 ? 'high' : ($essayCount > 2 ? 'medium' : 'low');
                                $priorityText = $essayCount > 5 ? 'HIGH' : ($essayCount > 2 ? 'MEDIUM' : 'LOW');
                                $priorityColor = $essayCount > 5 ? 'danger' : ($essayCount > 2 ? 'warning' : 'success');
                            @endphp
                            
                            <div class="col-lg-6 mb-4">
                                <div class="modern-user-card">
                                    <!-- Card Header -->
                                    <div class="card-header-section">
                                        <div class="user-profile">
                                            <div class="user-avatar">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                                <div class="status-dot"></div>
                                            </div>
                                            <div class="user-info">
                                                <h4 class="user-name">{{ $user->name }}</h4>
                                                <p class="user-email">{{ $user->email }}</p>
                                                <span class="member-since">
                                                    <i class="ti ti-calendar"></i>
                                                    Member sejak {{ \Carbon\Carbon::parse($user->created_at)->locale('id')->isoFormat('MMMM YYYY') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="priority-badge">
                                            <span class="badge bg-{{ $priorityColor }}">
                                                {{ $priorityText }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Stats Grid -->
                                    <div class="stats-wrapper">
                                        <div class="stats-grid">
                                            <div class="stat-item">
                                                <div class="stat-icon essays-icon">
                                                    <i class="ti ti-file-text"></i>
                                                </div>
                                                <div class="stat-number">{{ $essayCount }}</div>
                                                <div class="stat-label">ESSAYS</div>
                                            </div>

                                            <div class="stat-item">
                                                <div class="stat-icon quizzes-icon">
                                                    <i class="ti ti-clipboard-list"></i>
                                                </div>
                                                <div class="stat-number">{{ $quizCount }}</div>
                                                <div class="stat-label">QUIZZES</div>
                                            </div>

                                            <div class="stat-item">
                                                <div class="stat-icon points-icon">
                                                    <i class="ti ti-star"></i>
                                                </div>
                                                <div class="stat-number">{{ $totalBobotUser }}</div>
                                                <div class="stat-label">POINTS</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Timeline Section -->
                                    <div class="timeline-section">
                                        <div class="timeline-header">
                                            <span class="total-badge">{{ $quizCount }} total</span>
                                        </div>
                                        
                                        @foreach($uniqueQuizzes->take(1) as $quizId => $quizEssays)
                                            @php
                                                $quiz = $quizEssays->first()->hasilUjian->quiz;
                                                $quizEssayCount = $quizEssays->count();
                                                $quizBobot = $quizEssays->sum('bobot_soal');
                                                $tanggalUjian = $quizEssays->first()->hasilUjian->tanggal_ujian;
                                                $timeAgo = Carbon\Carbon::parse($tanggalUjian)->diffForHumans();
                                                $isRecent = Carbon\Carbon::parse($tanggalUjian)->isAfter(Carbon\Carbon::now()->subDays(7));
                                            @endphp
                                            
                                            <div class="timeline-item">
                                                <div class="timeline-line"></div>
                                                <div class="timeline-dot"></div>
                                                <div class="timeline-content">
                                                    <div class="quiz-badges">
                                                        <span class="quiz-badge essays-badge">{{ $quizEssayCount }} ESSAYS</span>
                                                        <span class="quiz-badge points-badge">{{ $quizBobot }}PT</span>
                                                        @if($isRecent)
                                                            <span class="quiz-badge new-badge">BARU</span>
                                                        @endif
                                                    </div>
                                                    <div class="quiz-meta">
                                                        <span class="quiz-code"># {{ $quiz->kode_quiz }}</span>
                                                        <span class="quiz-time">
                                                        <i class="ti ti-clock"></i>
                                                        {{ \Carbon\Carbon::parse($quiz->created_at)->locale('id')->diffForHumans() }}
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Footer -->
                                    <div class="card-footer-section">
                                        <div class="footer-info">
                                            <div class="pending-info">
                                                <i class="ti ti-clock"></i>
                                                <span>
                                                    @switch($essayCount)
                                                        @case(0)
                                                            Semua esai telah dinilai
                                                            @break
                                                        @case(1)
                                                            1 esai belum dinilai
                                                            @break
                                                        @default
                                                            {{ $essayCount }} esai belum dinilai
                                                    @endswitch
                                                </span>
                                            </div>
                                            <div class="priority-info">
                                                @if($essayCount > 10)
                                                    <span class="priority-text urgent">
                                                        <i class="ti ti-alert-triangle"></i>
                                                        Sangat mendesak - Butuh tim tambahan
                                                    </span>
                                                @elseif($essayCount > 5)
                                                    <span class="priority-text urgent">
                                                        <i class="ti ti-alert-circle"></i>
                                                        Mendesak - Segera tindak lanjuti
                                                    </span>
                                                @elseif($essayCount > 2)
                                                    <span class="priority-text medium">
                                                        <i class="ti ti-clock"></i>
                                                        Sedang - Perlu perhatian hari ini
                                                    </span>
                                                @elseif($essayCount > 0)
                                                    <span class="priority-text normal">
                                                        <i class="ti ti-info-circle"></i>
                                                        Rendah - Dapat dikerjakan besok
                                                    </span>
                                                @else
                                                    <span class="priority-text success">
                                                        <i class="ti ti-check-circle"></i>
                                                        Selesai - Semua esai telah dinilai
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        @if($essayCount > 0)
                                            <div class="action-button">
                                                @if($essayCount == 1)
                                                    <a href="{{ route('quiz.essay.grade', $userEssays->first()->id) }}" class="grade-btn">
                                                        <div class="btn-icon">
                                                            <i class="ti ti-edit"></i>
                                                        </div>
                                                        <div class="btn-content">
                                                            <span class="btn-title">Beri Nilai</span>
                                                            <span class="btn-subtitle">Tinjau jawaban esai</span>
                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="{{ route('quiz.essay.grade-user', $userId) }}" class="grade-btn">
                                                        <div class="btn-icon">
                                                            <i class="ti ti-list-check"></i>
                                                            {{-- BADGE MERAH DIHAPUS DARI SINI --}}
                                                        </div>
                                                        <div class="btn-content">
                                                            <span class="btn-title">Mulai Penilaian</span>
                                                            <span class="btn-subtitle">{{ $essayCount }} esai menunggu</span>
                                                        </div>
                                                    </a>
                                                @endif
                                            </div>
                                        @else
                                            <div class="action-button">
                                                <a href="{{ route('quiz.essay.grading') }}" class="grade-btn grade-btn-completed">
                                                    <div class="btn-icon">
                                                        <i class="ti ti-check-circle"></i>
                                                    </div>
                                                    <div class="btn-content">
                                                        <span class="btn-title">Lihat Hasil</span>
                                                        <span class="btn-subtitle">Semua penilaian selesai</span>
                                                    </div>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if(isset($essayAnswers) && $essayAnswers->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $essayAnswers->links() }}
                        </div>
                    @endif
                    
                @else
                    <!-- Empty State -->
                    <div class="card text-center py-5">
                        <div class="card-body">
                            <div class="mb-4">
                                <i class="ti ti-check-circle display-1 text-success"></i>
                            </div>
                            <h3 class="mb-3">Semua jawaban esai sudah dinilai!</h3>
                            <p class="text-muted mb-4">
                                Tidak ada jawaban esai yang perlu dinilai saat ini. Anda telah menyelesaikan semua penilaian.
                            </p>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('quiz.index') }}" class="btn btn-primary btn-lg">
                                    <i class="ti ti-arrow-left me-2"></i>Kembali ke Daftar Quiz
                                </a>
                                <a href="{{ route('quiz.essay.stats') }}" class="btn btn-outline-primary btn-lg">
                                    <i class="ti ti-chart-bar me-2"></i>Lihat Statistik
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Graded Essays Tab -->
            <div class="tab-pane fade" id="graded-content" role="tabpanel">
            @php
            // Get graded essays grouped by user
            $gradedEssays = App\Models\HasilUjianDetail::whereHas('soal', function($query) {
                    $query->where('tipe', 'essay');
                })
                ->whereHas('hasilUjian.quiz', function($query) {
                    $query->where('user_id', Auth::id());
                })
                ->whereIn('status_jawaban', ['benar', 'salah', 'sebagian'])
                ->with(['hasilUjian.user', 'hasilUjian.quiz', 'soal'])
                ->orderBy('updated_at', 'desc')
                ->get()
                ->groupBy('hasilUjian.user_id');
        @endphp

        @if($gradedEssays->count() > 0)
            <div class="row">
                @foreach($gradedEssays as $userId => $userGradedEssays)
                    @php
                        $user = $userGradedEssays->first()->hasilUjian->user;
                        $totalGradedEssays = $userGradedEssays->count();
                        $totalPoints = $userGradedEssays->sum('bobot_soal');
                        
                        // *** PERBAIKAN: Gunakan bobot_diperoleh untuk menghitung persentase ***
                        $totalBobotDiperoleh = $userGradedEssays->sum('bobot_diperoleh');
                        $totalBobotSoal = $userGradedEssays->sum('bobot_soal');
                        $averageScore = $totalBobotSoal > 0 ? round(($totalBobotDiperoleh / $totalBobotSoal) * 100, 1) : 0;
                        
                        $uniqueQuizzes = $userGradedEssays->groupBy('hasilUjian.quiz_id');
                        $quizCount = $uniqueQuizzes->count();
                        $lastGraded = $userGradedEssays->max('updated_at');
                        
                        // Calculate grade distribution
                        $correctCount = $userGradedEssays->where('status_jawaban', 'benar')->count();
                        $partialCount = $userGradedEssays->where('status_jawaban', 'sebagian')->count();
                        $incorrectCount = $userGradedEssays->where('status_jawaban', 'salah')->count();
                        
                        // *** PERBAIKAN: Gunakan bahasa Indonesia ***
                        $tingkatPerforma = $averageScore >= 80 ? 'sangat-baik' : ($averageScore >= 60 ? 'baik' : 'perlu-perbaikan');
                        $warnaPerforma = $averageScore >= 80 ? 'success' : ($averageScore >= 60 ? 'warning' : 'danger');
                        $teksPerforma = $averageScore >= 80 ? 'SANGAT BAIK' : ($averageScore >= 60 ? 'BAIK' : 'PERLU PERBAIKAN');
                    @endphp
                    
                    <div class="col-lg-6 mb-4">
                        <div class="modern-user-card graded-card">
                            <!-- Card Header -->
                            <div class="card-header-section">
                                <div class="user-profile">
                                    <div class="user-avatar graded-avatar">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                        <div class="status-dot graded-dot"></div>
                                    </div>
                                    <div class="user-info">
                                        <h4 class="user-name">{{ $user->name }}</h4>
                                        <p class="user-email">{{ $user->email }}</p>
                                        <span class="member-since">
                                            <i class="ti ti-calendar"></i>
                                            Terakhir dinilai: {{ \Carbon\Carbon::parse($lastGraded)->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                                <div class="priority-badge">
                                    <span class="badge bg-{{ $warnaPerforma }}">
                                        {{ $teksPerforma }}
                                    </span>
                                </div>
                            </div>

                            <!-- Stats Grid for Graded -->
                            <div class="stats-wrapper">
                                <div class="stats-grid">
                                    <div class="stat-item">
                                        <div class="stat-icon graded-essays-icon">
                                            <i class="ti ti-file-check"></i>
                                        </div>
                                        <div class="stat-number">{{ $totalGradedEssays }}</div>
                                        <div class="stat-label">EVALUASI</div>
                                    </div>

                                    <div class="stat-item">
                                        <div class="stat-icon score-icon">
                                            <i class="ti ti-trophy"></i>
                                        </div>
                                        <div class="stat-number">{{ $averageScore }}%</div>
                                        <div class="stat-label">RATA-RATA SKOR</div>
                                    </div>

                                    <div class="stat-item">
                                        <div class="stat-icon points-icon">
                                            <i class="ti ti-star"></i>
                                        </div>
                                        <div class="stat-number">{{ $totalBobotDiperoleh }}/{{ $totalPoints }}</div>
                                        <div class="stat-label">POIN</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Performance Section -->
                            <div class="performance-section">
                                <div class="performance-header">
                                    <span class="performance-title">Rincian Performa</span>
                                </div>
                                
                                <div class="performance-grid">
                                    <div class="performance-item correct">
                                        <div class="performance-count">{{ $correctCount }}</div>
                                        <div class="performance-label">Benar</div>
                                        <div class="performance-bar">
                                            <div class="performance-fill" style="width: {{ $totalGradedEssays > 0 ? ($correctCount / $totalGradedEssays) * 100 : 0 }}%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="performance-item partial">
                                        <div class="performance-count">{{ $partialCount }}</div>
                                        <div class="performance-label">Sebagian</div>
                                        <div class="performance-bar">
                                            <div class="performance-fill" style="width: {{ $totalGradedEssays > 0 ? ($partialCount / $totalGradedEssays) * 100 : 0 }}%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="performance-item incorrect">
                                        <div class="performance-count">{{ $incorrectCount }}</div>
                                        <div class="performance-label">Salah</div>
                                        <div class="performance-bar">
                                            <div class="performance-fill" style="width: {{ $totalGradedEssays > 0 ? ($incorrectCount / $totalGradedEssays) * 100 : 0 }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer for Graded -->
                            <div class="card-footer-section">
                                <div class="footer-info">
                                    <div class="graded-info">
                                        <i class="ti ti-check-circle"></i>
                                        <span>{{ $totalGradedEssays }} esai dinilai</span>
                                    </div>
                                    <div class="quiz-info">
                                        <i class="ti ti-clipboard-list"></i>
                                        <span>{{ $quizCount }} {{ $quizCount > 1 ? 'quiz' : 'quiz' }}</span>
                                    </div>
                                </div>
                                <div class="action-button">
                                    <button class="review-btn" onclick="showUserDetails({{ $userId }}, '{{ $user->name }}', '{{ $user->email }}', {{ $totalGradedEssays }}, {{ $averageScore }}, {{ $correctCount }}, {{ $partialCount }}, {{ $incorrectCount }})">
                                        <div class="btn-icon">
                                            <i class="ti ti-eye"></i>
                                        </div>
                                        <div class="btn-content">
                                            <span class="btn-title">Lihat Detail</span>
                                            <span class="btn-subtitle">Tampilkan ringkasan</span>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State for Graded -->
            <div class="card text-center py-5">
                <div class="card-body">
                    <div class="mb-4">
                        <i class="ti ti-file-search display-1 text-muted"></i>
                    </div>
                    <h3 class="mb-3">Belum ada jawaban esai yang dinilai</h3>
                    <p class="text-muted mb-4">
                        Mulai menilai jawaban esai untuk melihat hasil penilaian di sini.
                    </p>
                    <button class="btn btn-primary" onclick="document.getElementById('pending-tab').click()">
                        <i class="ti ti-arrow-left me-2"></i>Mulai Menilai
                    </button>
                </div>
            </div>
        @endif
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-color: #5d87ff;
            --success-color: #13deb9;
            --warning-color: #ffae1f;
            --info-color: #539bff;
            --danger-color: #fa896b;
        }

        /* Tab Styles */
        .nav-pills .nav-link {
            border-radius: 25px;
            padding: 10px 20px;
            margin-right: 10px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .nav-pills .nav-link.active {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .nav-pills .nav-link:hover {
            background-color: rgba(93, 135, 255, 0.1);
        }

        /* Stats Cards */
        .stats-card {
            transition: all 0.3s ease;
            border-radius: 15px;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Modern User Card */
        .modern-user-card {
            background: #f5f5f5;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            color: #2c3e50;
        }

        .modern-user-card.graded-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
        }

        .modern-user-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        /* Card Header */
        .card-header-section {
            padding: 16px 16px 12px;
            background: white;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .user-profile {
            display: flex;
            gap: 10px;
            flex: 1;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
            position: relative;
            flex-shrink: 0;
        }

        .user-avatar.graded-avatar {
            background: linear-gradient(135deg, #13deb9 0%, #0bb5a0 100%);
        }

        .status-dot {
            position: absolute;
            bottom: -1px;
            right: -1px;
            width: 10px;
            height: 10px;
            background: var(--success-color);
            border: 2px solid white;
            border-radius: 50%;
        }

        .status-dot.graded-dot {
            background: #13deb9;
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1px;
            line-height: 1.3;
        }

        .user-email {
            color: #6c757d;
            font-size: 12px;
            margin-bottom: 4px;
            line-height: 1.2;
        }

        .member-since {
            font-size: 10px;
            color: #6c757d;
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .priority-badge .badge {
            padding: 3px 6px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Stats Section */
        .stats-wrapper {
            background: white;
            padding: 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0;
        }

        .stat-item {
            background: white;
            padding: 16px 12px;
            text-align: center;
            border-right: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .stat-item:last-child {
            border-right: none;
        }

        .stat-item:hover {
            background: #f8f9fa;
        }

        .stat-icon {
            width: 28px;
            height: 28px;
            margin: 0 auto 8px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .essays-icon {
            background: #e3f2fd;
            color: #1976d2;
        }

        .graded-essays-icon {
            background: #e8f5e8;
            color: #2e7d32;
        }

        .score-icon {
            background: #fff8e1;
            color: #f57c00;
        }

        .quizzes-icon {
            background: #e8f5e8;
            color: #2e7d32;
        }

        .points-icon {
            background: #fff3e0;
            color: #f57c00;
        }

        .stat-number {
            font-size: 20px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 3px;
            line-height: 1;
        }

        .stat-label {
            font-size: 9px;
            color: #6c757d;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Timeline Section */
        .timeline-section {
            padding: 12px 16px;
            background: white;
            position: relative;
        }

        .timeline-header {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 12px;
        }

        .total-badge {
            background: #e9ecef;
            color: #6c757d;
            padding: 3px 6px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 500;
        }

        .timeline-item {
            position: relative;
            padding-left: 20px;
        }

        .timeline-line {
            position: absolute;
            left: 5px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #13deb9;
        }

        .timeline-dot {
            position: absolute;
            left: 1px;
            top: 6px;
            width: 8px;
            height: 8px;
            background: #13deb9;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 0 0 1px #13deb9;
        }

        .timeline-content {
            background: transparent;
            padding: 0;
        }

        .quiz-badges {
            display: flex;
            gap: 4px;
            margin-bottom: 6px;
            flex-wrap: wrap;
        }

        .quiz-badge {
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .essays-badge {
            background: #e3f2fd;
            color: #1976d2;
        }

        .points-badge {
            background: #fff3e0;
            color: #f57c00;
        }

        .new-badge {
            background: #13deb9;
            color: white;
        }

        .quiz-meta {
            display: flex;
            gap: 10px;
            font-size: 10px;
            color: #6c757d;
        }

        .quiz-code, .quiz-time {
            display: flex;
            align-items: center;
            gap: 2px;
        }

        /* Performance Section for Graded Cards */
        .performance-section {
            padding: 12px 16px;
            background: white;
            border-top: 1px solid #f0f0f0;
        }

        .performance-header {
            margin-bottom: 12px;
        }

        .performance-title {
            font-size: 11px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .performance-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .performance-item {
            text-align: center;
        }

        .performance-count {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .performance-label {
            font-size: 8px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .performance-item.correct .performance-count {
            color: #13deb9;
        }

        .performance-item.correct .performance-label {
            color: #13deb9;
        }

        .performance-item.partial .performance-count {
            color: #ffae1f;
        }

        .performance-item.partial .performance-label {
            color: #ffae1f;
        }

        .performance-item.incorrect .performance-count {
            color: #fa896b;
        }

        .performance-item.incorrect .performance-label {
            color: #fa896b;
        }

        .performance-bar {
            height: 4px;
            background: #f0f0f0;
            border-radius: 2px;
            overflow: hidden;
        }

        .performance-fill {
            height: 100%;
            transition: width 0.3s ease;
        }

        .performance-item.correct .performance-fill {
            background: #13deb9;
        }

        .performance-item.partial .performance-fill {
            background: #ffae1f;
        }

        .performance-item.incorrect .performance-fill {
            background: #fa896b;
        }

        /* Footer */
        .card-footer-section {
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            background: #f8f9fa;
        }

        .footer-info {
            flex: 1;
        }

        .pending-info, .graded-info, .quiz-info {
            display: flex;
            align-items: center;
            gap: 3px;
            font-size: 11px;
            color: #6c757d;
            margin-bottom: 2px;
        }

        .priority-info .priority-text {
            font-size: 9px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 2px;
        }

        .priority-text.urgent { color: var(--danger-color); }
        .priority-text.medium { color: var(--warning-color); }
        .priority-text.normal { color: var(--success-color); }

        /* Grade Button */
        .grade-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 6px;
            color: white;
            text-decoration: none;
            padding: 6px 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 12px;
        }

        .grade-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(102, 126, 234, 0.3);
            color: white;
        }

        /* Review Button */
        .review-btn {
            background: linear-gradient(135deg, #13deb9 0%, #0bb5a0 100%);
            border: none;
            border-radius: 6px;
            color: white;
            text-decoration: none;
            padding: 6px 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 12px;
        }

        .review-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(19, 222, 185, 0.3);
            color: white;
        }

        .btn-icon {
            font-size: 12px;
        }

        .btn-content {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-title {
            font-size: 12px;
            font-weight: 600;
            line-height: 1.2;
        }

        .btn-subtitle {
            font-size: 9px;
            opacity: 0.8;
            line-height: 1;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .card-header-section {
                flex-direction: column;
                gap: 16px;
            }

            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .performance-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .card-footer-section {
                flex-direction: column;
                text-align: center;
            }

            .grade-btn, .review-btn {
                width: 100%;
                justify-content: center;
            }

            .nav-pills {
                flex-direction: column;
            }

            .nav-pills .nav-link {
                margin-bottom: 8px;
                margin-right: 0;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .stat-item {
                padding: 20px 16px;
            }
        }

        /* Background Utilities */
        .bg-primary-subtle { background-color: rgba(93, 135, 255, 0.1) !important; }
        .bg-success-subtle { background-color: rgba(19, 222, 185, 0.1) !important; }
        .bg-warning-subtle { background-color: rgba(255, 174, 31, 0.1) !important; }
        .bg-info-subtle { background-color: rgba(83, 155, 255, 0.1) !important; }
        .bg-danger-subtle { background-color: rgba(250, 137, 107, 0.1) !important; }

        .text-white-75 { color: rgba(255,255,255,0.75) !important; }

        .breadcrumb-light .breadcrumb-item + .breadcrumb-item::before {
            color: rgba(255,255,255,0.7);
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        /* Tab Animation */
        .tab-pane {
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
        }

        .tab-pane.show.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Modal Styles */
        .user-avatar-large {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #13deb9 0%, #0bb5a0 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 24px;
            box-shadow: 0 4px 12px rgba(19, 222, 185, 0.3);
        }

        .stat-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .stat-icon-small {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .stat-info h3 {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
        }

        .progress-item {
            margin-bottom: 16px;
        }

        .progress {
            border-radius: 4px;
            background-color: #e9ecef;
        }

        .progress-bar {
            transition: width 0.6s ease;
        }

        /* Modal Animation */
        .modal.fade .modal-dialog {
            transform: scale(0.8);
            transition: transform 0.3s ease;
        }

        .modal.show .modal-dialog {
            transform: scale(1);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    if (bootstrap && bootstrap.Alert) {
                        var bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                });
            }, 5000);

            // Add loading state to grade buttons
            document.querySelectorAll('.grade-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const originalContent = this.innerHTML;
                    this.innerHTML = `
                        <div class="btn-icon">
                            <i class="ti ti-loader-2"></i>
                        </div>
                        <div class="btn-content">
                            <span class="btn-title">Memuat...</span>
                            <span class="btn-subtitle">Harap tunggu</span>
                        </div>
                    `;
                    this.style.pointerEvents = 'none';
                    
                    const loader = this.querySelector('.ti-loader-2');
                    if (loader) {
                        loader.style.animation = 'spin 1s linear infinite';
                    }
                });
            });

            // Add loading state to review buttons
            document.querySelectorAll('.review-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    if (this.onclick) return; // Skip if it has onclick handler
                    
                    const originalContent = this.innerHTML;
                    this.innerHTML = `
                        <div class="btn-icon">
                            <i class="ti ti-loader-2"></i>
                        </div>
                        <div class="btn-content">
                            <span class="btn-title">Loading...</span>
                            <span class="btn-subtitle">Please wait</span>
                        </div>
                    `;
                    this.style.pointerEvents = 'none';
                    
                    // Add spinning animation
                    const loader = this.querySelector('.ti-loader-2');
                    if (loader) {
                        loader.style.animation = 'spin 1s linear infinite';
                    }
                });
            });

            // Global functions for modal
            window.showUserDetails = function(userId, userName, userEmail, totalEssays, avgScore, correctCount, partialCount, incorrectCount) {
                // Set user info
                document.getElementById('modalUserAvatar').textContent = userName.substring(0, 2).toUpperCase();
                document.getElementById('modalUserName').textContent = userName;
                document.getElementById('modalUserEmail').textContent = userEmail;
                
                // Set stats
                document.getElementById('modalTotalEssays').textContent = totalEssays;
                document.getElementById('modalAvgScore').textContent = avgScore + '%';
                
                // Set counts
                document.getElementById('modalCorrectCount').textContent = correctCount;
                document.getElementById('modalPartialCount').textContent = partialCount;
                document.getElementById('modalIncorrectCount').textContent = incorrectCount;
                
                // Calculate percentages and set progress bars
                const total = correctCount + partialCount + incorrectCount;
                const correctPercent = total > 0 ? (correctCount / total) * 100 : 0;
                const partialPercent = total > 0 ? (partialCount / total) * 100 : 0;
                const incorrectPercent = total > 0 ? (incorrectCount / total) * 100 : 0;
                
                document.getElementById('modalCorrectBar').style.width = correctPercent + '%';
                document.getElementById('modalPartialBar').style.width = partialPercent + '%';
                document.getElementById('modalIncorrectBar').style.width = incorrectPercent + '%';
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('userDetailsModal'));
                modal.show();
                
                // Store current user ID for export
                window.currentUserId = userId;
            };

            window.exportUserReport = function() {
                if (window.currentUserId) {
                    // Implementasi export functionality
                    alert('Fitur ekspor laporan akan diimplementasikan sesuai kebutuhan backend Anda.');
                    // Contoh: window.open('/quiz/essay/export/' + window.currentUserId, '_blank');
                }
            };

            // Entrance animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.modern-user-card').forEach(function(card) {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.6s ease';
                observer.observe(card);
            });

            // Add hover effects
            document.querySelectorAll('.modern-user-card').forEach(function(card) {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Animate performance bars when tab is shown
            document.getElementById('graded-tab').addEventListener('shown.bs.tab', function() {
                setTimeout(function() {
                    document.querySelectorAll('.performance-fill').forEach(function(fill) {
                        const width = fill.style.width;
                        fill.style.width = '0%';
                        setTimeout(function() {
                            fill.style.width = width;
                        }, 100);
                    });
                }, 200);
            });

            // Smooth scroll for navigation
            document.querySelectorAll('a[href^="#"]').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href === '#' || href.startsWith('#top')) {
                        e.preventDefault();
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Tab switching with URL hash
            const hash = window.location.hash;
            if (hash === '#graded') {
                document.getElementById('graded-tab').click();
            }

            // Update URL when tab changes
            document.querySelectorAll('[data-bs-toggle="pill"]').forEach(function(tab) {
                tab.addEventListener('shown.bs.tab', function(e) {
                    const targetId = e.target.getAttribute('data-bs-target');
                    if (targetId === '#graded-content') {
                        history.replaceState(null, null, '#graded');
                    } else {
                        history.replaceState(null, null, '#pending');
                    }
                });
            });
        });

        // Add spin animation for loader
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
    </script>
@endsection