@extends('layouts.backend')
@section('content')
    @include('layouts.components-backend.css')
    <div class="container-fluid">
        <!-- Enhanced Header Section -->
        <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5">
            <div class="card-body px-4 py-4">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h3 class="fw-bold mb-3 text-white">Statistik Penilaian Esai</h3>
                        <p class="text-white-75 mb-3">Dashboard untuk memantau progress penilaian jawaban esai.</p>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light">
                                <li class="breadcrumb-item">
                                    <a class="text-white text-decoration-none" href="{{ route('admin.quiz-terbaru') }}">
                                        <i class="ti ti-home me-1"></i>Dasbor
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a class="text-white text-decoration-none" href="{{ route('quiz.essay.grading') }}">
                                        Penilaian Esai
                                    </a>
                                </li>
                                <li class="breadcrumb-item active text-white-75" aria-current="page">
                                    Statistik
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center">
                            <img src="{{ asset('assets/backend/images/breadcrumb/ChatBc.png') }}" alt="essay-stats"
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
                $totalEssays = $pendingCount + $gradedCount;
                $progressPercent = $totalEssays > 0 ? round(($gradedCount / $totalEssays) * 100, 1) : 0;
            @endphp
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm stats-card">
                    <div class="card-body text-center py-4">
                        <div class="rounded-circle bg-warning-subtle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="ti ti-clock text-warning" style="font-size: 24px;"></i>
                        </div>
                        <h4 class="fw-bold text-warning mb-1">{{ $pendingCount }}</h4>
                        <p class="text-muted mb-0">Menunggu Penilaian</p>
                        @if($pendingCount > 0)
                            <div class="mt-3">
                                <a href="{{ route('quiz.essay.grading') }}" class="btn btn-warning btn-sm">
                                    <i class="ti ti-edit me-1"></i>Nilai Sekarang
                                </a>
                            </div>
                        @endif
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
                        <p class="text-muted mb-0">Sudah Dinilai</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm stats-card">
                    <div class="card-body text-center py-4">
                        <div class="rounded-circle bg-info-subtle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="ti ti-file-text text-info" style="font-size: 24px;"></i>
                        </div>
                        <h4 class="fw-bold text-info mb-1">{{ $totalEssays }}</h4>
                        <p class="text-muted mb-0">Total Jawaban Esai</p>
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

        <!-- Progress Overview -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="mb-3">Progress Penilaian Keseluruhan</h5>
                        <p class="text-muted mb-3">{{ $gradedCount }} dari {{ $totalEssays }} jawaban telah dinilai</p>
                        
                        <div class="progress mb-3" style="height: 12px;">
                            <div class="progress-bar progress-bar-animated 
                                @if($progressPercent >= 80) bg-success 
                                @elseif($progressPercent >= 50) bg-warning 
                                @else bg-danger @endif" 
                                 style="width: {{ $progressPercent }}%">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between text-sm">
                            <span class="text-muted">0%</span>
                            <span class="text-muted">{{ $progressPercent }}%</span>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="{{ route('quiz.essay.grading') }}" class="btn btn-warning me-2">
                            <i class="ti ti-edit me-2"></i>Nilai Esai
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

        <!-- Quiz Priority List or Success Message -->
        <div class="row mb-4">
            <div class="col-12">
                @if($quizWithMostPending->count() > 0)
                    <div class="card quiz-card">
                        <div class="card-body">
                            <h5 class="mb-3">
                                <i class="ti ti-alert-triangle text-warning me-2"></i>Quiz Prioritas
                            </h5>
                            <p class="text-muted mb-4">Quiz yang memerlukan perhatian segera</p>
                            
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0 text-muted fw-medium">Quiz</th>
                                            <th class="border-0 text-muted fw-medium text-center">Pending</th>
                                            <th class="border-0 text-muted fw-medium text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($quizWithMostPending as $quiz)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-warning-subtle d-inline-flex align-items-center justify-content-center me-3"
                                                        style="width: 40px; height: 40px;">
                                                        <i class="ti ti-clipboard text-warning"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $quiz->judul_quiz }}</h6>
                                                        <small class="text-muted">Memerlukan penilaian</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-warning-subtle text-warning">
                                                    {{ $quiz->pending_count }} jawaban
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('quiz.essay.grading') }}" 
                                                   class="btn btn-warning btn-sm btn-action">
                                                    <i class="ti ti-edit me-1"></i>Nilai
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card text-center py-5">
                        <div class="card-body">
                            <div class="mb-4">
                                <i class="ti ti-trophy display-1 text-success"></i>
                            </div>
                            <h3 class="mb-3">Kerja Bagus!</h3>
                            <p class="text-muted mb-4">
                                Semua jawaban esai telah dinilai. Tidak ada quiz yang memerlukan penilaian mendesak saat ini.
                            </p>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('quiz.index') }}" class="btn btn-primary btn-lg">
                                    <i class="ti ti-eye me-2"></i>Lihat Semua Quiz
                                </a>
                                <a href="{{ route('quiz.essay.grading') }}" class="btn btn-outline-primary btn-lg">
                                    <i class="ti ti-edit me-2"></i>Nilai Esai
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Performance Insights -->
        <div class="row">
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card quiz-card h-100">
                    <div class="card-body text-center py-4">
                        <div class="rounded-circle bg-info-subtle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="ti ti-clock text-info" style="font-size: 24px;"></i>
                        </div>
                        <h5 class="mb-2">Estimasi Waktu</h5>
                        <h4 class="fw-bold text-info mb-1">{{ $pendingCount * 3 }} menit</h4>
                        <small class="text-muted">untuk menyelesaikan semua</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card quiz-card h-100">
                    <div class="card-body text-center py-4">
                        <div class="rounded-circle bg-primary-subtle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="ti ti-target text-primary" style="font-size: 24px;"></i>
                        </div>
                        <h5 class="mb-2">Target Harian</h5>
                        <h4 class="fw-bold text-primary mb-1">
                            @if($pendingCount <= 10)
                                Satu sesi
                            @else
                                10-15 jawaban
                            @endif
                        </h4>
                        <small class="text-muted">rekomendasi per hari</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card quiz-card h-100">
                    <div class="card-body text-center py-4">
                        <div class="rounded-circle bg-success-subtle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="ti ti-chart-line text-success" style="font-size: 24px;"></i>
                        </div>
                        <h5 class="mb-2">Produktivitas</h5>
                        <h4 class="fw-bold text-success mb-1">{{ $gradedCount }}</h4>
                        <small class="text-muted">jawaban telah dinilai</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        @if($pendingCount > 0)
        <div class="card">
            <div class="card-body text-center py-4">
                <h6 class="mb-3">
                    <i class="ti ti-zap text-primary me-2"></i>Aksi Cepat
                </h6>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="{{ route('quiz.essay.grading') }}" class="btn btn-warning btn-action">
                        <i class="ti ti-edit me-2"></i>Mulai Menilai Esai
                    </a>
                    <a href="{{ route('quiz.index') }}" class="btn btn-outline-secondary btn-action">
                        <i class="ti ti-list me-2"></i>Lihat Semua Quiz
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>

    <style>
        :root {
            --primary-color: #5d87ff;
            --success-color: #13deb9;
            --warning-color: #ffae1f;
            --info-color: #539bff;
            --danger-color: #fa896b;
        }

        .quiz-card {
            border-radius: 20px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .quiz-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }

        .stats-card {
            transition: all 0.3s ease;
            border-radius: 15px;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .btn-action {
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
        }

        /* Background Utilities */
        .bg-primary-subtle {
            background-color: rgba(93, 135, 255, 0.1) !important;
        }

        .bg-success-subtle {
            background-color: rgba(19, 222, 185, 0.1) !important;
        }

        .bg-warning-subtle {
            background-color: rgba(255, 174, 31, 0.1) !important;
        }

        .bg-info-subtle {
            background-color: rgba(83, 155, 255, 0.1) !important;
        }

        /* Progress Bar Enhancements */
        .progress {
            border-radius: 0.5rem;
            background-color: #f8f9fa;
        }

        .progress-bar {
            border-radius: 0.5rem;
            transition: width 1s ease-in-out;
        }

        /* Table Enhancements */
        .table > :not(caption) > * > * {
            padding: 1rem 0.75rem;
            border-bottom-width: 1px;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.025);
        }

        /* Animation for cards */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .quiz-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .quiz-card {
                margin-bottom: 20px;
            }

            .btn-action {
                font-size: 0.875rem;
                padding: 8px 12px;
            }

            .col-4 .stats-item {
                padding: 8px 2px;
            }

            .col-4 .stats-item small {
                font-size: 0.7rem;
            }
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Animate progress bar on load
        const progressBar = document.querySelector('.progress-bar');
        if (progressBar) {
            const width = progressBar.style.width;
            progressBar.style.width = '0%';
            setTimeout(() => {
                progressBar.style.width = width;
            }, 500);
        }
        
        // Add hover effects to stats cards
        const statsCards = document.querySelectorAll('.stats-card');
        statsCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
    </script>
@endsection