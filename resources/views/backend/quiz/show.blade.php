@extends('layouts.backend')
@section('content')
    @include('layouts.components-backend.css')
    <div class="container-fluid" style="padding-top: 0;">

        <!-- Header Section -->
        <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5 border-0">
            <div class="card-body px-4 py-4">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h3 class="fw-bold mb-3 text-white">Detail Quiz</h3>
                        <p class="text-white mb-3">Lihat informasi lengkap dan semua soal quiz</p>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light">
                                <li class="breadcrumb-item">
                                    <a class="text-white text-decoration-none" href="">
                                        <i class="ti ti-home me-1"></i>Kelola
                                    </a>
                                </li>
                                <li class="breadcrumb-item active text-white" aria-current="page">Quiz</li>
                                <li class="breadcrumb-item active text-white" aria-current="page">Detail</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center">
                            <img src="{{ asset('assets/backend/images/breadcrumb/ChatBc.png') }}" alt="quiz-dashboard"
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

        <!-- Quiz Information -->
        <div class="card border-0 mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Informasi Quiz</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('quiz.edit', $quiz->id) }}" class="btn btn-warning btn-sm">
                        <i class="ti ti-edit me-1"></i>Edit Quiz
                    </a>
                    <span class="badge {{ $quiz->status_aktivasi == 'aktif' ? 'bg-success' : 'bg-secondary' }} fs-6">
                        {{ ucfirst($quiz->status_aktivasi) }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="text-primary mb-3">{{ $quiz->judul_quiz }}</h4>
                        @if ($quiz->deskripsi)
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Deskripsi:</h6>
                                <p class="text-dark">{{ $quiz->deskripsi }}</p>
                            </div>
                        @endif
                        
                        <!-- Quiz Metadata -->
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted d-block">Kategori</small>
                                <span class="badge bg-primary mb-2">{{ $quiz->kategori->nama_kategori ?? 'Tidak ada kategori' }}</span>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Mata Pelajaran</small>
                                <span class="badge bg-info mb-2">{{ $quiz->mataPelajaran->nama_mapel ?? 'Tidak ada mata pelajaran' }}</span>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Status Visibilitas</small>
                                <span class="badge {{ $quiz->status == 'Umum' ? 'bg-success' : 'bg-warning' }} mb-2">{{ $quiz->status }}</span>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Pengulangan</small>
                                <span class="badge {{ $quiz->pengulangan_pekerjaan == 'Boleh' ? 'bg-success' : 'bg-danger' }} mb-2">{{ $quiz->pengulangan_pekerjaan }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light rounded p-3">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary rounded-circle me-3 d-flex justify-content-center align-items-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-clock text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Durasi</h6>
                                    <span class="text-muted">{{ $quiz->waktu_menit }} menit</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success rounded-circle me-3 d-flex justify-content-center align-items-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-list-numbers text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Total Soal</h6>
                                    <span class="text-muted">{{ $quiz->soals->count() }} pertanyaan</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-warning rounded-circle me-3 d-flex justify-content-center align-items-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-scale text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Total Bobot</h6>
                                    <span class="text-muted">{{ $quiz->soals->sum('bobot') }} poin</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="bg-info rounded-circle me-3 d-flex justify-content-center align-items-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-calendar text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Dibuat</h6>
                                    <span class="text-muted">{{ $quiz->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quiz Statistics -->
        @if($quiz->soals->count() > 0)
        <div class="card border-0 mb-4 shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">Statistik Soal</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center p-4 bg-primary-subtle rounded stats-card">
                            <i class="ti ti-list text-primary fs-1 mb-3"></i>
                            <h4 class="text-primary mb-2">{{ $quiz->soals->where('tipe', 'pilihan_ganda')->count() }}</h4>
                            <small class="text-muted fw-semibold">Pilihan Ganda</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-4 bg-success-subtle rounded stats-card">
                            <i class="ti ti-check text-success fs-1 mb-3"></i>
                            <h4 class="text-success mb-2">{{ $quiz->soals->where('tipe', 'benar_salah')->count() }}</h4>
                            <small class="text-muted fw-semibold">Benar/Salah</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-4 bg-warning-subtle rounded stats-card">
                            <i class="ti ti-file-text text-warning fs-1 mb-3"></i>
                            <h4 class="text-warning mb-2">{{ $quiz->soals->where('tipe', 'essay')->count() }}</h4>
                            <small class="text-muted fw-semibold">Essay</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-4 bg-info-subtle rounded stats-card">
                            <i class="ti ti-qrcode text-info fs-1 mb-3"></i>
                            <h4 class="text-info mb-2">{{ $quiz->kode_quiz }}</h4>
                            <small class="text-muted fw-semibold">Kode Quiz</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Questions Section -->
        <div class="card border-0 shadow-sm mb-5">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="ti ti-list-details me-2"></i>Daftar Soal Quiz
                </h5>
            </div>
            <div class="card-body">
                @if ($quiz->soals->count() > 0)
                    @foreach ($quiz->soals as $index => $soal)
                        <div class="question-item card mb-4" data-type="{{ $soal->tipe }}">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-title mb-0 text-primary">
                                        <i class="ti ti-help-circle me-2"></i>Soal {{ $index + 1 }}
                                    </h6>
                                    <div class="d-flex gap-2">
                                        @php
                                            $typeColors = [
                                                'pilihan_ganda' => 'primary',
                                                'essay' => 'warning',
                                                'benar_salah' => 'success'
                                            ];
                                            $typeNames = [
                                                'pilihan_ganda' => 'Pilihan Ganda',
                                                'essay' => 'Essay',
                                                'benar_salah' => 'Benar/Salah'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $typeColors[$soal->tipe] ?? 'secondary' }}">
                                            {{ $typeNames[$soal->tipe] ?? ucfirst($soal->tipe) }}
                                        </span>
                                        @if($soal->bobot)
                                            <span class="badge bg-secondary">
                                                <i class="ti ti-star me-1"></i>Bobot: {{ $soal->bobot }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Question Text -->
                                <div class="mb-4">
                                    <h6 class="text-dark mb-2">
                                        <i class="ti ti-message-2 me-2 text-primary"></i>Pertanyaan:
                                    </h6>
                                    <p class="text-dark fs-6 bg-light p-3 rounded border-start border-primary border-3">{{ $soal->pertanyaan }}</p>
                                </div>

                                <!-- Question Options Based on Type -->
                                @if($soal->tipe === 'pilihan_ganda')
                                    <!-- Multiple Choice Options -->
                                    <div class="mb-4">
                                        <h6 class="text-dark mb-3">
                                            <i class="ti ti-list me-2 text-primary"></i>Pilihan Jawaban:
                                        </h6>
                                        <div class="row">
                                            @php
                                                $options = ['A' => $soal->pilihan_a, 'B' => $soal->pilihan_b, 'C' => $soal->pilihan_c, 'D' => $soal->pilihan_d];
                                                if($soal->pilihan_e) $options['E'] = $soal->pilihan_e;
                                                if($soal->pilihan_f) $options['F'] = $soal->pilihan_f;
                                                if($soal->pilihan_g) $options['G'] = $soal->pilihan_g;
                                                if($soal->pilihan_h) $options['H'] = $soal->pilihan_h;
                                                if($soal->pilihan_i) $options['I'] = $soal->pilihan_i;
                                                if($soal->pilihan_j) $options['J'] = $soal->pilihan_j;
                                            @endphp
                                            
                                            @foreach($options as $letter => $option)
                                                @if($option)
                                                    <div class="col-md-6 mb-3">
                                                        <div class="option-item d-flex align-items-center p-3 rounded {{ $soal->jawaban_benar == $letter ? 'bg-success-subtle border border-success' : 'bg-light border' }}">
                                                            <span class="badge {{ $soal->jawaban_benar == $letter ? 'bg-success' : 'bg-secondary' }} me-3 option-badge">{{ $letter }}</span>
                                                            <span class="text-dark flex-grow-1">{{ $option }}</span>
                                                            @if ($soal->jawaban_benar == $letter)
                                                                <i class="ti ti-check-circle text-success ms-2 fs-5"></i>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <div class="d-inline-flex align-items-center bg-success-subtle px-3 py-2 rounded">
                                            <i class="ti ti-check-circle text-success me-2"></i>
                                            <small class="text-success fw-bold">
                                                Jawaban benar: {{ $soal->jawaban_benar }}
                                            </small>
                                        </div>
                                    </div>

                                @elseif($soal->tipe === 'benar_salah')
                                    <!-- True/False Options -->
                                    <div class="mb-4">
                                        <h6 class="text-dark mb-3">
                                            <i class="ti ti-toggle-left me-2 text-primary"></i>Pilihan Jawaban:
                                        </h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="option-item d-flex align-items-center p-3 rounded {{ $soal->jawaban_benar == 'Benar' ? 'bg-success-subtle border border-success' : 'bg-light border' }}">
                                                    <div class="bg-{{ $soal->jawaban_benar == 'Benar' ? 'success' : 'secondary' }} rounded-circle me-3 d-flex justify-content-center align-items-center" style="width: 35px; height: 35px;">
                                                        <i class="ti ti-check text-white"></i>
                                                    </div>
                                                    <span class="text-dark flex-grow-1 fw-semibold">Benar</span>
                                                    @if ($soal->jawaban_benar == 'Benar')
                                                        <i class="ti ti-check-circle text-success ms-2 fs-4"></i>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="option-item d-flex align-items-center p-3 rounded {{ $soal->jawaban_benar == 'Salah' ? 'bg-success-subtle border border-success' : 'bg-light border' }}">
                                                    <div class="bg-{{ $soal->jawaban_benar == 'Salah' ? 'success' : 'secondary' }} rounded-circle me-3 d-flex justify-content-center align-items-center" style="width: 35px; height: 35px;">
                                                        <i class="ti ti-x text-white"></i>
                                                    </div>
                                                    <span class="text-dark flex-grow-1 fw-semibold">Salah</span>
                                                    @if ($soal->jawaban_benar == 'Salah')
                                                        <i class="ti ti-check-circle text-success ms-2 fs-4"></i>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <div class="d-inline-flex align-items-center bg-success-subtle px-3 py-2 rounded">
                                            <i class="ti ti-check-circle text-success me-2"></i>
                                            <small class="text-success fw-bold">
                                                Jawaban benar: {{ $soal->jawaban_benar }}
                                            </small>
                                        </div>
                                    </div>

                                @elseif($soal->tipe === 'essay')
                                    <!-- Essay Answer/Rubric -->
                                    <div class="mb-4">
                                        @if($soal->jawaban_benar)
                                            <h6 class="text-dark mb-3">
                                                <i class="ti ti-clipboard-text me-2 text-warning"></i>Jawaban Model / Rubrik Penilaian:
                                            </h6>
                                            <div class="bg-warning-subtle border border-warning rounded p-4">
                                                <div class="d-flex">
                                                    <i class="ti ti-file-text text-warning me-3 mt-1 fs-5"></i>
                                                    <span class="text-dark">{{ $soal->jawaban_benar }}</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="bg-info-subtle border border-info rounded p-4 text-center">
                                                <i class="ti ti-info-circle text-info me-2 fs-4"></i>
                                                <span class="text-info fw-semibold">Soal essay ini akan dinilai secara manual oleh guru</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="text-end">
                                        <div class="d-inline-flex align-items-center bg-warning-subtle px-3 py-2 rounded">
                                            <i class="ti ti-edit text-warning me-2"></i>
                                            <small class="text-warning fw-bold">
                                                Tipe: Essay (Penilaian Manual)
                                            </small>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="ti ti-file-plus text-muted" style="font-size: 5rem;"></i>
                        </div>
                        <h5 class="text-muted mb-3">Belum Ada Soal</h5>
                        <p class="text-muted mb-4">Quiz ini belum memiliki soal. Tambahkan soal untuk melengkapi quiz.</p>
                        <a href="{{ route('quiz.edit', $quiz->id) }}" class="btn btn-primary btn-lg">
                            <i class="ti ti-plus me-2"></i>Tambah Soal Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between align-items-center mt-5 mb-5">
            <a href="{{ route('quiz.index') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-2"></i>Kembali ke Daftar Quiz
            </a>
            <div class="d-flex gap-2">
                <a href="{{ route('quiz.edit', $quiz->id) }}" class="btn btn-warning">
                    <i class="ti ti-edit me-2"></i>Edit Quiz
                </a>
                @if ($quiz->status_aktivasi == 'aktif')
                    <button class="btn btn-success" onclick="shareQuiz('{{ $quiz->kode_quiz }}')">
                        <i class="ti ti-share me-2"></i>Bagikan Quiz
                    </button>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const questionItems = document.querySelectorAll('.question-item');

            questionItems.forEach((item, index) => {
                item.style.animationDelay = `${index * 0.1}s`;
                item.classList.add('fade-in');
            });
        });

        function shareQuiz(quizCode) {
            const url = `${window.location.origin}/quiz/start/${quizCode}`;
            
            if (navigator.share) {
                navigator.share({
                    title: 'Quiz: {{ $quiz->judul_quiz }}',
                    text: 'Ikuti quiz ini dengan kode: ' + quizCode,
                    url: url
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(url).then(function() {
                    alert('Link quiz berhasil disalin ke clipboard!\n\nKode Quiz: ' + quizCode + '\nLink: ' + url);
                }, function(err) {
                    prompt('Salin link ini untuk membagikan quiz:', url);
                });
            }
        }
    </script>

    <style>
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }

        .question-item {
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
            transform: translateY(20px);
            border-left: 4px solid #0d6efd;
        }

        .question-item.fade-in {
            opacity: 1;
            transform: translateY(0);
        }

        .question-item:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .option-item {
            transition: all 0.2s ease;
            border: 1px solid #dee2e6;
        }

        .option-item:hover {
            transform: translateX(3px);
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
        }

        .option-badge {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Stats card hover effect */
        .stats-card {
            transition: all 0.3s ease;
            cursor: pointer;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        /* Background color utilities */
        .bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }

        .bg-primary-subtle {
            background-color: rgba(13, 110, 253, 0.1) !important;
        }

        .bg-warning-subtle {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }

        .bg-info-subtle {
            background-color: rgba(13, 202, 240, 0.1) !important;
        }

        /* Button styles */
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #000;
        }

        .btn-warning:hover {
            background-color: #ffb300;
            border-color: #ffb300;
            color: #000;
        }

        .btn-success {
            background-color: #198754;
            border-color: #198754;
        }

        .btn-outline-secondary {
            color: #6c757d;
            border-color: #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
        }

        /* Badge styles */
        .badge {
            font-size: 0.775em;
            font-weight: 500;
        }

        /* Text utilities */
        .text-primary {
            color: #0d6efd !important;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }

        .rounded {
            border-radius: 0.375rem !important;
        }

        .fs-6 {
            font-size: 1rem !important;
        }

        .fs-1 {
            font-size: 2.5rem !important;
        }

        .fs-4 {
            font-size: 1.5rem !important;
        }

        .fs-5 {
            font-size: 1.25rem !important;
        }

        /* Border utilities */
        .border-start {
            border-left: var(--bs-border-width) var(--bs-border-style) var(--bs-border-color) !important;
        }

        .border-3 {
            border-width: 3px !important;
        }

        .border-primary {
            border-color: #0d6efd !important;
        }

        /* Animations */
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

        /* Icon styles */
        .ti {
            font-size: 1.2em;
        }

        /* Question type specific styling */
        .question-item[data-type="pilihan_ganda"] {
            border-left-color: #0d6efd;
        }

        .question-item[data-type="essay"] {
            border-left-color: #ffc107;
        }

        .question-item[data-type="benar_salah"] {
            border-left-color: #198754;
        }

        /* Enhanced spacing */
        .mb-5:last-child {
            margin-bottom: 3rem !important;
        }

        /* Improved text hierarchy */
        h6 {
            font-weight: 600;
        }

        .fw-semibold {
            font-weight: 600 !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .d-flex.gap-2 {
                flex-direction: column;
                gap: 0.75rem !important;
            }

            .d-flex.gap-2 .btn {
                width: 100%;
            }

            .col-md-6 .option-item {
                margin-bottom: 1rem;
            }

            .row .col-md-3 {
                margin-bottom: 1.5rem;
            }

            .stats-card {
                margin-bottom: 1rem;
            }
        }

        /* Enhanced hover effects for interactive elements */
        .card-header:hover {
            background-color: #e9ecef !important;
            transition: background-color 0.2s ease;
        }

        /* Correct answer highlighting */
        .border-success {
            border-width: 2px !important;
            border-color: #198754 !important;
        }

        /* Enhanced statistics cards */
        .stats-card {
            height: 140px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, 
                var(--bs-primary) 0%, 
                var(--bs-success) 25%, 
                var(--bs-warning) 50%, 
                var(--bs-info) 75%);
        }

        /* Icon animations */
        .stats-card i {
            transition: transform 0.3s ease;
        }

        .stats-card:hover i {
            transform: scale(1.1) rotate(5deg);
        }

        /* Empty state styling */
        .text-center.py-5 {
            padding: 4rem 2rem !important;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 1rem;
            border: 2px dashed #dee2e6;
        }

        /* Background gradient fix */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        /* Text color utilities for header - using opacity classes */
        .opacity-75 {
            opacity: 0.75 !important;
        }

        .breadcrumb-light .breadcrumb-item + .breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.75);
        }

        .breadcrumb-light {
            --bs-breadcrumb-divider-color: rgba(255, 255, 255, 0.75);
        }

        /* Improved shadow effects */
        .shadow-sm {
            box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.075) !important;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
        }

        /* Question text styling */
        .border-start.border-primary.border-3 {
            background: linear-gradient(90deg, rgba(13, 110, 253, 0.05) 0%, rgba(13, 110, 253, 0.02) 100%);
        }

        /* Better color variables */
        :root {
            --bs-primary: #0d6efd;
            --bs-success: #198754;
            --bs-warning: #ffc107;
            --bs-info: #0dcaf0;
            --bs-secondary: #6c757d;
        }
        @media (max-width: 576px) {
            .container-fluid {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            .stats-card {
                height: 120px;
                margin-bottom: 1rem;
            }
            
            .option-item {
                min-height: 50px;
                padding: 0.75rem !important;
            }
            
            .question-item {
                margin-bottom: 2rem;
            }
        }
    </style>
@endsection