@extends('layouts.backend')
@section('content')
    @include('layouts.components-backend.css')
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="card bg-gradient-success shadow-sm position-relative overflow-hidden mb-5 border-0">
            <div class="card-body px-4 py-4">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h3 class="fw-bold mb-3 text-white">Terimakasih sudah mengerjakan!!</h3>
                        <p class="text-white-75 mb-3">Semua jawaban anda sudah tersimpan di database kami!!</p>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light">
                                <li class="breadcrumb-item">
                                    <a class="text-white-75 text-decoration-none" href="{{ route('dashboard') }}">
                                        <i class="ti ti-home me-1"></i>Dashboard
                                    </a>
                                </li>
                                <li class="breadcrumb-item active text-white-75" aria-current="page">Quiz</li>
                                <li class="breadcrumb-item active text-white" aria-current="page">Hasil</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center">
                            <img src="{{ asset('assets/backend/images/breadcrumb/ChatBc.png') }}" alt="quiz-results"
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
        <div class="card border-0 mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Informasi Quiz</h5>
                <div class="d-flex gap-2">
                    <span class="badge bg-success fs-6">
                        <i class="ti ti-check me-1"></i>Selesai
                    </span>
                    @if($hasil->quiz->status === 'Privat')
                        <span class="badge bg-secondary fs-6">
                            <i class="ti ti-lock me-1"></i>Privat
                        </span>
                    @else
                        <span class="badge bg-info fs-6">
                            <i class="ti ti-world me-1"></i>Umum
                        </span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="text-primary mb-3">{{ $hasil->quiz->judul_quiz }}
                            @if(isset($hasil->quiz->mataPelajaran) && $hasil->quiz->mataPelajaran)
                                - ({{ $hasil->quiz->mataPelajaran->nama_mapel }})
                            @endif
                        </h4>
                        @if ($hasil->quiz->deskripsi)
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Deskripsi:</h6>
                                <p class="text-dark">{{ $hasil->quiz->deskripsi }}</p>
                            </div>
                        @endif
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">Peserta:</h6>
                            <p class="text-dark">{{ $hasil->user->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light rounded p-3">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary rounded-circle me-3 d-flex justify-content-center align-items-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-calendar text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Tanggal Ujian</h6>
                                    <span
                                        class="text-muted">{{ \Carbon\Carbon::parse($hasil->updated_at)->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success rounded-circle me-3 d-flex justify-content-center align-items-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-clock text-white"></i>
                                </div>
                                @php
                                    $totalDetik = round($hasil->waktu_pengerjaan * 60);
                                    $menit = floor($totalDetik / 60);
                                    $detik = $totalDetik % 60;
                                @endphp

                                <div>
                                    <h6 class="mb-0">Waktu Pengerjaan</h6>
                                    <span class="text-muted">
                                        {{ $menit . ':' . str_pad($detik, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="bg-info rounded-circle me-3 d-flex justify-content-center align-items-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-list-numbers text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Total Soal</h6>
                                    <span class="text-muted">{{ $hasil_detail->count() }} pertanyaan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Section - SELALU TAMPILKAN -->
        <div class="row mb-4">
            <!-- Score Card -->
            <div class="col-md-3">
                <div class="card border-0 bg-gradient-primary text-white">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="ti ti-trophy" style="font-size: 3rem;"></i>
                        </div>
                        <h2 class="fw-bold mb-2 text-white">{{ $hasil->skor ?? 0 }}</h2>
                        <p class="mb-0">Skor Akhir</p>
                    </div>
                </div>
            </div>

            <!-- Correct Answers Card -->
            <div class="col-md-3">
                <div class="card border-0 bg-gradient-success text-white">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="ti ti-check" style="font-size: 3rem;"></i>
                        </div>
                        <h2 class="fw-bold mb-2 text-white">{{ $hasil->jumlah_benar ?? 0 }}</h2>
                        <p class="mb-0">Jawaban Benar</p>
                    </div>
                </div>
            </div>

            <!-- Wrong Answers Card -->
            <div class="col-md-3">
                <div class="card border-0 bg-gradient-danger text-white">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="ti ti-x" style="font-size: 3rem;"></i>
                        </div>
                        <h2 class="fw-bold mb-2 text-white">{{ $hasil->jumlah_salah ?? 0 }}</h2>
                        <p class="mb-0">Jawaban Salah</p>
                    </div>
                </div>
            </div>

            <!-- Ranking Card -->
            <div class="col-md-3">
                <div class="card border-0 bg-gradient-warning text-white">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="ti ti-medal" style="font-size: 3rem;"></i>
                        </div>
                        <h2 class="fw-bold mb-2 text-white">{{ $ranking ?? '-' }}</h2>
                        <p class="mb-0">dari {{ $total_peserta ?? 0 }} peserta</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Weight Information Card -->
        <div class="card border-0 mb-4">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="me-3">
                                <i class="ti ti-calculator text-primary" style="font-size: 2rem;"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Total Bobot</h5>
                                <span class="text-muted fs-4 fw-bold">{{ $hasil->total_bobot ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="me-3">
                                <i class="ti ti-target text-success" style="font-size: 2rem;"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Bobot Diperoleh</h5>
                                <span class="text-success fs-4 fw-bold">{{ $hasil->bobot_diperoleh ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Performers - Hanya untuk Quiz Umum -->
        @if ($hasil->quiz->status === 'Umum' && isset($top_performers) && count($top_performers) > 0)
            <div class="card border-0 mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Papan Peringkat</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Peringkat</th>
                                    <th>Nama</th>
                                    <th>Skor</th>
                                    <th>Benar</th>
                                    <th>Salah</th>
                                    <th>Bobot</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($top_performers as $index => $performer)
                                    <tr class="{{ $performer->id == $hasil->id ? 'table-success' : '' }}">
                                        <td>
                                            @if ($index == 0)
                                                <i class="ti ti-crown text-warning fs-5"></i>
                                            @elseif($index == 1)
                                                <i class="ti ti-medal text-secondary fs-5"></i>
                                            @elseif($index == 2)
                                                <i class="ti ti-award text-warning fs-5"></i>
                                            @else
                                                <span class="badge bg-light text-dark">{{ $index + 1 }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $performer->user->name }}
                                            @if ($performer->id == $hasil->id)
                                                <small class="text-success fw-bold">(Anda)</small>
                                            @endif
                                        </td>
                                        <td><span class="badge bg-primary">{{ $performer->skor }}</span></td>
                                        <td><span class="text-success">{{ $performer->jumlah_benar }}</span></td>
                                        <td><span class="text-danger">{{ $performer->jumlah_salah }}</span></td>
                                        <td><span class="badge bg-info">{{ $performer->bobot_diperoleh }}</span></td>
                                        <td>
                                            @php
                                                $totalDetik = round($performer->waktu_pengerjaan * 60);
                                                $menit = floor($totalDetik / 60);
                                                $detik = $totalDetik % 60;
                                            @endphp
                                            {{ $menit }}:{{ str_pad($detik, 2, '0', STR_PAD_LEFT) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Detail Jawaban Section - SELALU TAMPILKAN JIKA ADA DATA -->
        @if ($hasil_detail && $hasil_detail->count() > 0)
            <div class="card border-0 mb-4">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="ti ti-list-details me-2 text-primary"></i>
                            Review Jawaban Anda
                            @if($hasil->quiz->status === 'Privat')
                                <small class="text-muted">(Quiz Privat - Detail Tersedia)</small>
                            @endif
                        </h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary" onclick="toggleAllAnswers()">
                                <i class="ti ti-eye me-1"></i>
                                <span id="toggleText">Sembunyikan Semua</span>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="filterAnswers('all')" id="filterAll">
                                <i class="ti ti-list me-1"></i>Semua
                            </button>
                            <button class="btn btn-sm btn-outline-success" onclick="filterAnswers('correct')" id="filterCorrect">
                                <i class="ti ti-check me-1"></i>Benar
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="filterAnswers('wrong')" id="filterWrong">
                                <i class="ti ti-x me-1"></i>Salah
                            </button>
                            @if($hasil_detail->where('status_jawaban', 'pending')->count() > 0)
                                <button class="btn btn-sm btn-outline-warning" onclick="filterAnswers('pending')" id="filterPending">
                                    <i class="ti ti-clock me-1"></i>Menunggu
                                </button>
                            @endif
                            @if($hasil_detail->where('status_jawaban', 'sebagian')->count() > 0)
                                <button class="btn btn-sm btn-outline-info" onclick="filterAnswers('sebagian')" id="filterSebagian">
                                    <i class="ti ti-alert-triangle me-1"></i>Sebagian
                                </button>
                            @endif
                            @if($hasil_detail->where('status_jawaban', 'unknown')->count() > 0)
                                <button class="btn btn-sm btn-outline-secondary" onclick="filterAnswers('unknown')" id="filterUnknown">
                                    <i class="ti ti-help me-1"></i>Tidak Diketahui
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <!-- Summary Statistics -->
                    <div class="p-3 bg-light border-bottom">
                        <div class="row text-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="me-2">
                                        <i class="ti ti-list-numbers text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Total Soal</h6>
                                        <span class="text-muted">{{ $hasil_detail->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="me-2">
                                        <i class="ti ti-check-circle text-success fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Benar</h6>
                                        <span class="text-success fw-bold">{{ $hasil_detail->where('status_jawaban', 'benar')->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="me-2">
                                        <i class="ti ti-x-circle text-danger fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Salah</h6>
                                        <span class="text-danger fw-bold">{{ $hasil_detail->where('status_jawaban', 'salah')->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="me-2">
                                        <i class="ti ti-clock text-warning fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Pending</h6>
                                        <span class="text-warning fw-bold">{{ $hasil_detail->where('status_jawaban', 'pending')->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="me-2">
                                        <i class="ti ti-alert-triangle text-info fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Sebagian</h6>
                                        <span class="text-info fw-bold">{{ $hasil_detail->where('status_jawaban', 'sebagian')->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="me-2">
                                        <i class="ti ti-help text-secondary fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Unknown</h6>
                                        <span class="text-secondary fw-bold">{{ $hasil_detail->where('status_jawaban', 'unknown')->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    @php
                        $correctCount = $hasil_detail->where('status_jawaban', 'benar')->count();
                        $totalCount = $hasil_detail->count();
                        $progressPercent = $totalCount > 0 ? ($correctCount / $totalCount) * 100 : 0;
                    @endphp
                    <div class="px-3 py-2 bg-white border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted">Progress Jawaban Benar</small>
                            <small class="text-muted">{{ $correctCount }}/{{ $totalCount }} benar</small>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $progressPercent }}%"
                                aria-valuenow="{{ $progressPercent }}"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <!-- Question Details -->
                    <div class="question-container">
                        @forelse ($hasil_detail as $index => $detail)
                            @php
                                $statusClass = '';
                                switch($detail->status_jawaban) {
                                    case 'benar':
                                        $statusClass = 'correct-answer';
                                        break;
                                    case 'salah':
                                        $statusClass = 'wrong-answer';
                                        break;
                                    case 'pending':
                                        $statusClass = 'pending-answer';
                                        break;
                                    case 'sebagian':
                                        $statusClass = 'partial-answer';
                                        break;
                                    case 'unknown':
                                        $statusClass = 'unknown-answer';
                                        break;
                                    default:
                                        $statusClass = 'wrong-answer';
                                }
                            @endphp
                            <div class="question-item border-bottom {{ $statusClass }}" data-status="{{ $detail->status_jawaban }}">
                                <div class="p-3">
                                    <!-- Question Header -->
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="question-number me-3">
                                                @php
                                                    $badgeClass = 'bg-secondary';
                                                    switch($detail->status_jawaban) {
                                                        case 'benar':
                                                            $badgeClass = 'bg-success';
                                                            break;
                                                        case 'salah':
                                                            $badgeClass = 'bg-danger';
                                                            break;
                                                        case 'pending':
                                                            $badgeClass = 'bg-warning';
                                                            break;
                                                        case 'sebagian':
                                                            $badgeClass = 'bg-info';
                                                            break;
                                                        case 'unknown':
                                                            $badgeClass = 'bg-secondary';
                                                            break;
                                                    }
                                                @endphp
                                                <div class="badge {{ $badgeClass }} rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width: 35px; height: 35px; font-size: 14px;">
                                                    {{ $index + 1 }}
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-bold">Soal {{ $index + 1 }}</h6>
                                                <div class="d-flex align-items-center gap-2">
                                                    @if ($detail->status_jawaban === 'benar')
                                                        <span class="badge bg-success-subtle text-success">
                                                            <i class="ti ti-check me-1"></i>Benar
                                                        </span>
                                                    @elseif ($detail->status_jawaban === 'salah')
                                                        <span class="badge bg-danger-subtle text-danger">
                                                            <i class="ti ti-x me-1"></i>Salah
                                                        </span>
                                                    @elseif ($detail->status_jawaban === 'pending')
                                                        <span class="badge bg-warning-subtle text-warning">
                                                            <i class="ti ti-clock me-1"></i>Menunggu Review
                                                        </span>
                                                    @elseif ($detail->status_jawaban === 'sebagian')
                                                        <span class="badge bg-info-subtle text-info">
                                                            <i class="ti ti-alert-triangle me-1"></i>Sebagian Benar
                                                        </span>
                                                    @elseif ($detail->status_jawaban === 'unknown')
                                                        <span class="badge bg-secondary-subtle text-secondary">
                                                            <i class="ti ti-help me-1"></i>Data Tidak Tersedia
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger-subtle text-danger">
                                                            <i class="ti ti-x me-1"></i>Tidak Terjawab
                                                        </span>
                                                    @endif
                                                    <span class="badge bg-light text-muted">
                                                        <i class="ti ti-star me-1"></i>{{ $detail->bobot_diperoleh ?? 0 }} / {{ $detail->bobot_soal ?? 0 }} poin
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-sm btn-link text-muted toggle-detail"
                                            onclick="toggleQuestionDetail({{ $index }})">
                                            <i class="ti ti-chevron-up" id="toggle-icon-{{ $index }}"></i>
                                        </button>
                                    </div>

                                    <!-- Question Content -->
                                    <div class="question-content" id="question-content-{{ $index }}">
                                        <!-- Question Text -->
                                        <div class="question-text mb-3">
                                            <label class="form-label fw-semibold text-dark">Pertanyaan:</label>
                                            <div class="p-3 bg-light rounded border-start border-4 border-primary">
                                                @if(isset($detail->soal) && $detail->soal)
                                                    {!! $detail->soal->pertanyaan ?? 'Pertanyaan tidak tersedia' !!}
                                                @else
                                                    <em class="text-muted">Pertanyaan tidak tersedia</em>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Answer Section -->
                                        <div class="row">
                                            <!-- Your Answer -->
                                            <div class="{{ (isset($detail->soal) && $detail->soal && $detail->soal->tipe === 'essay') ? 'col-md-12' : 'col-md-6' }} mb-3">
                                                <label class="form-label fw-semibold">Jawaban Anda:</label>
                                                @php
                                                    $answerBoxClass = 'bg-light border-secondary';
                                                    $iconClass = 'ti-help text-muted';
                                                    
                                                    switch($detail->status_jawaban) {
                                                        case 'benar':
                                                            $answerBoxClass = 'bg-success-subtle border-success';
                                                            $iconClass = 'ti-check text-success';
                                                            break;
                                                        case 'salah':
                                                            $answerBoxClass = 'bg-danger-subtle border-danger';
                                                            $iconClass = 'ti-x text-danger';
                                                            break;
                                                        case 'pending':
                                                            $answerBoxClass = 'bg-warning-subtle border-warning';
                                                            $iconClass = 'ti-clock text-warning';
                                                            break;
                                                        case 'sebagian':
                                                            $answerBoxClass = 'bg-info-subtle border-info';
                                                            $iconClass = 'ti-alert-triangle text-info';
                                                            break;
                                                        case 'unknown':
                                                            $answerBoxClass = 'bg-secondary-subtle border-secondary';
                                                            $iconClass = 'ti-help text-secondary';
                                                            break;
                                                    }
                                                @endphp
                                                <div class="answer-box p-3 rounded border-start border-4 {{ $answerBoxClass }}">
                                                    <div class="d-flex align-items-start">
                                                        <i class="ti {{ $iconClass }} me-2 fs-5 mt-1"></i>
                                                        <div class="flex-grow-1">
                                                            @if($detail->jawaban_peserta && $detail->jawaban_peserta !== 'Data tidak tersedia')
                                                                @if(isset($detail->soal) && $detail->soal && $detail->soal->tipe === 'essay')
                                                                    <div class="fw-medium">
                                                                        <div class="mb-2">
                                                                            <span class="text-muted">Jawaban Essay:</span>
                                                                        </div>
                                                                        <div class="p-2 bg-white rounded border">
                                                                            <pre class="mb-0" style="white-space: pre-wrap; font-family: inherit; font-size: 0.9rem;">{{ $detail->jawaban_peserta }}</pre>
                                                                        </div>
                                                                        @if ($detail->status_jawaban === 'pending')
                                                                            <div class="mt-2">
                                                                                <small class="text-warning">
                                                                                    <i class="ti ti-clock me-1"></i>
                                                                                    Sedang menunggu review manual
                                                                                </small>
                                                                            </div>
                                                                        @elseif(isset($detail->feedback) && $detail->feedback)
                                                                            <div class="mt-2 p-2 bg-info-subtle rounded">
                                                                                <small class="text-info fw-semibold">
                                                                                    <i class="ti ti-message-circle me-1"></i>
                                                                                    Feedback:
                                                                                </small>
                                                                                <div class="mt-1">
                                                                                    <small>{{ $detail->feedback }}</small>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                @elseif(isset($detail->soal) && $detail->soal && $detail->soal->tipe === 'checkbox')
                                                                    @php
                                                                        $selectedAnswers = is_array($detail->jawaban_peserta) 
                                                                            ? $detail->jawaban_peserta 
                                                                            : explode(',', $detail->jawaban_peserta);
                                                                    @endphp
                                                                    <div class="fw-medium">
                                                                        @if(is_array($selectedAnswers) && count($selectedAnswers) > 0 && $selectedAnswers[0] !== '')
                                                                            @foreach($selectedAnswers as $answer)
                                                                                @if(trim($answer) !== '')
                                                                                    <span class="badge bg-primary me-1 mb-1">{{ trim($answer) }}</span>
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            <span class="text-muted">Tidak ada pilihan yang dipilih</span>
                                                                        @endif
                                                                    </div>
                                                                @elseif(isset($detail->soal) && $detail->soal && $detail->soal->tipe === 'benar_salah')
                                                                    <span class="fw-medium">
                                                                        @if($detail->jawaban_peserta === 'Benar')
                                                                            <span class="badge bg-success">Benar</span>
                                                                        @elseif($detail->jawaban_peserta === 'Salah')
                                                                            <span class="badge bg-danger">Salah</span>
                                                                        @else
                                                                            <span class="text-muted">{{ $detail->jawaban_peserta }}</span>
                                                                        @endif
                                                                    </span>
                                                                @else
                                                                    <span class="fw-medium">{{ $detail->jawaban_peserta }}</span>
                                                                @endif
                                                            @else
                                                                <span class="fw-medium text-muted">
                                                                    @if($detail->jawaban_peserta === 'Data tidak tersedia')
                                                                        Data tidak tersedia (Quiz lama)
                                                                    @else
                                                                        Tidak dijawab
                                                                    @endif
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Correct Answer -->
                                            @if(isset($detail->soal) && $detail->soal && $detail->soal->tipe !== 'essay')
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-semibold">Jawaban Benar:</label>
                                                    <div class="answer-box p-3 rounded border-start border-4 bg-success-subtle border-success">
                                                        <div class="d-flex align-items-start">
                                                            <i class="ti ti-check text-success me-2 fs-5 mt-1"></i>
                                                            <div class="flex-grow-1">
                                                                @if($detail->soal->jawaban_benar)
                                                                    @if($detail->soal->tipe === 'checkbox')
                                                                        @php
                                                                            $correctAnswers = is_array($detail->soal->jawaban_benar)
                                                                                ? $detail->soal->jawaban_benar
                                                                                : explode(',', $detail->soal->jawaban_benar);
                                                                        @endphp
                                                                        <div class="fw-medium">
                                                                            @if(is_array($correctAnswers) && count($correctAnswers) > 0)
                                                                                @foreach($correctAnswers as $answer)
                                                                                    @if(trim($answer) !== '')
                                                                                        <span class="badge bg-success me-1 mb-1">{{ trim($answer) }}</span>
                                                                                    @endif
                                                                                @endforeach
                                                                            @else
                                                                                <span class="text-muted">Tidak ada jawaban benar yang ditetapkan</span>
                                                                            @endif
                                                                        </div>
                                                                    @elseif($detail->soal->tipe === 'benar_salah')
                                                                        <span class="fw-medium">
                                                                            @if($detail->soal->jawaban_benar === 'Benar')
                                                                                <span class="badge bg-success">Benar</span>
                                                                            @else
                                                                                <span class="badge bg-danger">Salah</span>
                                                                            @endif
                                                                        </span>
                                                                    @elseif($detail->soal->tipe === 'pilihan_ganda')
                                                                        <span class="fw-medium">
                                                                            {{ $detail->soal->jawaban_benar }}
                                                                            @if($detail->soal->jawaban_benar === 'A' && $detail->soal->pilihan_a)
                                                                                - {{ $detail->soal->pilihan_a }}
                                                                            @elseif($detail->soal->jawaban_benar === 'B' && $detail->soal->pilihan_b)
                                                                                - {{ $detail->soal->pilihan_b }}
                                                                            @elseif($detail->soal->jawaban_benar === 'C' && $detail->soal->pilihan_c)
                                                                                - {{ $detail->soal->pilihan_c }}
                                                                            @elseif($detail->soal->jawaban_benar === 'D' && $detail->soal->pilihan_d)
                                                                                - {{ $detail->soal->pilihan_d }}
                                                                            @elseif($detail->soal->jawaban_benar === 'E' && $detail->soal->pilihan_e)
                                                                                - {{ $detail->soal->pilihan_e }}
                                                                            @endif
                                                                        </span>
                                                                    @else
                                                                        <span class="fw-medium">{{ $detail->soal->jawaban_benar }}</span>
                                                                    @endif
                                                                @else
                                                                    <span class="fw-medium text-muted">-</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Show Multiple Choice Options -->
                                        @if(isset($detail->soal) && $detail->soal && $detail->soal->tipe === 'pilihan_ganda')
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-dark">Pilihan Jawaban:</label>
                                                <div class="row">
                                                    @if($detail->soal->pilihan_a)
                                                        <div class="col-md-6 mb-2">
                                                            <div class="p-2 rounded border {{ $detail->jawaban_peserta === 'A' ? ($detail->soal->jawaban_benar === 'A' ? 'bg-success-subtle border-success' : 'bg-danger-subtle border-danger') : ($detail->soal->jawaban_benar === 'A' ? 'bg-success-subtle border-success' : 'bg-light') }}">
                                                                <strong>A.</strong> {{ $detail->soal->pilihan_a }}
                                                                @if($detail->jawaban_peserta === 'A')
                                                                    <i class="ti ti-arrow-left text-primary ms-2"></i>
                                                                @endif
                                                                @if($detail->soal->jawaban_benar === 'A')
                                                                    <i class="ti ti-check text-success ms-2"></i>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($detail->soal->pilihan_b)
                                                        <div class="col-md-6 mb-2">
                                                            <div class="p-2 rounded border {{ $detail->jawaban_peserta === 'B' ? ($detail->soal->jawaban_benar === 'B' ? 'bg-success-subtle border-success' : 'bg-danger-subtle border-danger') : ($detail->soal->jawaban_benar === 'B' ? 'bg-success-subtle border-success' : 'bg-light') }}">
                                                                <strong>B.</strong> {{ $detail->soal->pilihan_b }}
                                                                @if($detail->jawaban_peserta === 'B')
                                                                    <i class="ti ti-arrow-left text-primary ms-2"></i>
                                                                @endif
                                                                @if($detail->soal->jawaban_benar === 'B')
                                                                    <i class="ti ti-check text-success ms-2"></i>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($detail->soal->pilihan_c)
                                                        <div class="col-md-6 mb-2">
                                                            <div class="p-2 rounded border {{ $detail->jawaban_peserta === 'C' ? ($detail->soal->jawaban_benar === 'C' ? 'bg-success-subtle border-success' : 'bg-danger-subtle border-danger') : ($detail->soal->jawaban_benar === 'C' ? 'bg-success-subtle border-success' : 'bg-light') }}">
                                                                <strong>C.</strong> {{ $detail->soal->pilihan_c }}
                                                                @if($detail->jawaban_peserta === 'C')
                                                                    <i class="ti ti-arrow-left text-primary ms-2"></i>
                                                                @endif
                                                                @if($detail->soal->jawaban_benar === 'C')
                                                                    <i class="ti ti-check text-success ms-2"></i>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($detail->soal->pilihan_d)
                                                        <div class="col-md-6 mb-2">
                                                            <div class="p-2 rounded border {{ $detail->jawaban_peserta === 'D' ? ($detail->soal->jawaban_benar === 'D' ? 'bg-success-subtle border-success' : 'bg-danger-subtle border-danger') : ($detail->soal->jawaban_benar === 'D' ? 'bg-success-subtle border-success' : 'bg-light') }}">
                                                                <strong>D.</strong> {{ $detail->soal->pilihan_d }}
                                                                @if($detail->jawaban_peserta === 'D')
                                                                    <i class="ti ti-arrow-left text-primary ms-2"></i>
                                                                @endif
                                                                @if($detail->soal->jawaban_benar === 'D')
                                                                    <i class="ti ti-check text-success ms-2"></i>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($detail->soal->pilihan_e)
                                                        <div class="col-md-6 mb-2">
                                                            <div class="p-2 rounded border {{ $detail->jawaban_peserta === 'E' ? ($detail->soal->jawaban_benar === 'E' ? 'bg-success-subtle border-success' : 'bg-danger-subtle border-danger') : ($detail->soal->jawaban_benar === 'E' ? 'bg-success-subtle border-success' : 'bg-light') }}">
                                                                <strong>E.</strong> {{ $detail->soal->pilihan_e }}
                                                                @if($detail->jawaban_peserta === 'E')
                                                                    <i class="ti ti-arrow-left text-primary ms-2"></i>
                                                                @endif
                                                                @if($detail->soal->jawaban_benar === 'E')
                                                                    <i class="ti ti-check text-success ms-2"></i>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Show Checkbox Options -->
                                        @if(isset($detail->soal) && $detail->soal && $detail->soal->tipe === 'checkbox')
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-dark">Pilihan Checkbox:</label>
                                                @php
                                                    $userAnswers = is_array($detail->jawaban_peserta) 
                                                        ? $detail->jawaban_peserta 
                                                        : explode(',', $detail->jawaban_peserta);
                                                    $correctAnswers = is_array($detail->soal->jawaban_benar)
                                                        ? $detail->soal->jawaban_benar
                                                        : explode(',', $detail->soal->jawaban_benar);
                                                    
                                                    $options = [];
                                                    if($detail->soal->pilihan_a) $options['A'] = $detail->soal->pilihan_a;
                                                    if($detail->soal->pilihan_b) $options['B'] = $detail->soal->pilihan_b;
                                                    if($detail->soal->pilihan_c) $options['C'] = $detail->soal->pilihan_c;
                                                    if($detail->soal->pilihan_d) $options['D'] = $detail->soal->pilihan_d;
                                                    if($detail->soal->pilihan_e) $options['E'] = $detail->soal->pilihan_e;
                                                @endphp
                                                <div class="row">
                                                    @foreach($options as $key => $option)
                                                        @php
                                                            $isUserSelected = in_array($key, array_map('trim', $userAnswers));
                                                            $isCorrect = in_array($key, array_map('trim', $correctAnswers));
                                                            
                                                            $bgClass = 'bg-light';
                                                            if($isUserSelected && $isCorrect) {
                                                                $bgClass = 'bg-success-subtle border-success';
                                                            } elseif($isUserSelected && !$isCorrect) {
                                                                $bgClass = 'bg-danger-subtle border-danger';
                                                            } elseif(!$isUserSelected && $isCorrect) {
                                                                $bgClass = 'bg-warning-subtle border-warning';
                                                            }
                                                        @endphp
                                                        <div class="col-md-6 mb-2">
                                                            <div class="p-2 rounded border {{ $bgClass }}">
                                                                <div class="d-flex align-items-center">
                                                                    <input type="checkbox" 
                                                                           {{ $isUserSelected ? 'checked' : '' }} 
                                                                           disabled 
                                                                           class="form-check-input me-2">
                                                                    <span><strong>{{ $key }}.</strong> {{ $option }}</span>
                                                                    @if($isUserSelected)
                                                                        <i class="ti ti-arrow-left text-primary ms-2"></i>
                                                                    @endif
                                                                    @if($isCorrect)
                                                                        <i class="ti ti-check text-success ms-2"></i>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Explanation if available -->
                                        @if(isset($detail->soal) && $detail->soal && $detail->soal->penjelasan)
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-dark">Penjelasan:</label>
                                                <div class="p-3 bg-info-subtle rounded border-start border-4 border-info">
                                                    <i class="ti ti-lightbulb text-info me-2"></i>
                                                    <span class="text-info fw-medium">{{ $detail->soal->penjelasan }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center p-5">
                                <i class="ti ti-file-unknown text-muted" style="font-size: 3rem;"></i>
                                <h5 class="text-muted mt-3">Tidak ada detail jawaban</h5>
                                <p class="text-muted">Detail jawaban tidak tersedia untuk quiz ini</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- No Results Message -->
                    <div id="no-results" class="text-center p-5 d-none">
                        <i class="ti ti-search-off text-muted" style="font-size: 3rem;"></i>
                        <h5 class="text-muted mt-3">Tidak ada hasil yang sesuai dengan filter</h5>
                        <p class="text-muted">Coba ubah filter untuk melihat soal lainnya</p>
                    </div>
                </div>
            </div>
        @else
            {{-- Jika benar-benar tidak ada detail --}}
            <div class="card border-0 mb-4">
                <div class="card-body text-center py-5">
                    <i class="ti ti-file-unknown text-muted" style="font-size: 4rem;"></i>
                    <h4 class="text-muted mt-3 mb-2">Detail Jawaban Tidak Tersedia</h4>
                    <p class="text-muted mb-3">
                        @if($hasil->quiz->status === 'Privat')
                            Quiz ini bersifat privat sehingga detail jawaban tidak ditampilkan.
                        @else
                            Detail jawaban tidak tersedia untuk quiz ini.
                        @endif
                    </p>
                    <div class="mt-4">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="alert alert-info" role="alert">
                                    <i class="ti ti-info-circle me-2"></i>
                                    <strong>Informasi:</strong> 
                                    Anda masih bisa melihat skor dan statistik umum dari hasil quiz Anda di atas.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
            <div class="d-flex gap-2">
                @if ($hasil->quiz->status === 'Umum')
                    <button class="btn btn-info" onclick="shareResult()">
                        <i class="ti ti-share me-2"></i>Bagikan
                    </button>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Toggle question detail visibility
        function toggleQuestionDetail(index) {
            const content = document.getElementById(`question-content-${index}`);
            const icon = document.getElementById(`toggle-icon-${index}`);

            if (content.style.display === 'none') {
                content.style.display = 'block';
                icon.classList.remove('ti-chevron-down');
                icon.classList.add('ti-chevron-up');
            } else {
                content.style.display = 'none';
                icon.classList.remove('ti-chevron-up');
                icon.classList.add('ti-chevron-down');
            }
        }

        // Toggle all answers visibility
        function toggleAllAnswers() {
            const allContent = document.querySelectorAll('[id^="question-content-"]');
            const toggleText = document.getElementById('toggleText');
            const allIcons = document.querySelectorAll('[id^="toggle-icon-"]');

            const firstContent = allContent[0];
            const isVisible = firstContent.style.display !== 'none';

            allContent.forEach(content => {
                content.style.display = isVisible ? 'none' : 'block';
            });

            allIcons.forEach(icon => {
                if (isVisible) {
                    icon.classList.remove('ti-chevron-up');
                    icon.classList.add('ti-chevron-down');
                } else {
                    icon.classList.remove('ti-chevron-down');
                    icon.classList.add('ti-chevron-up');
                }
            });

            toggleText.textContent = isVisible ? 'Tampilkan Semua' : 'Sembunyikan Semua';
        }

        // Filter answers by type
        function filterAnswers(type) {
            const questions = document.querySelectorAll('.question-item');
            const noResults = document.getElementById('no-results');
            const filterButtons = document.querySelectorAll('[id^="filter"]');
            let visibleCount = 0;

            // Remove active class from all filter buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));

            // Add active class to clicked button
            const activeButton = document.getElementById(`filter${type.charAt(0).toUpperCase() + type.slice(1)}`);
            if (activeButton) {
                activeButton.classList.add('active');
            }

            questions.forEach(question => {
                const status = question.getAttribute('data-status');
                let shouldShow = false;

                switch (type) {
                    case 'all':
                        shouldShow = true;
                        break;
                    case 'correct':
                        shouldShow = status === 'benar';
                        break;
                    case 'wrong':
                        shouldShow = status === 'salah';
                        break;
                    case 'pending':
                        shouldShow = status === 'pending';
                        break;
                    case 'sebagian':
                        shouldShow = status === 'sebagian';
                        break;
                    case 'unknown':
                        shouldShow = status === 'unknown';
                        break;
                }

                if (shouldShow) {
                    question.style.display = 'block';
                    visibleCount++;
                } else {
                    question.style.display = 'none';
                }
            });

            // Show/hide no results message
            if (visibleCount === 0) {
                noResults.classList.remove('d-none');
            } else {
                noResults.classList.add('d-none');
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Set initial filter to 'all'
            document.getElementById('filterAll').classList.add('active');

            // Animate question items
            const questionItems = document.querySelectorAll('.question-item');
            questionItems.forEach((item, index) => {
                item.style.animationDelay = `${index * 0.05}s`;
                item.classList.add('fade-in-question');
            });

            // Animate cards on load
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.classList.add('fade-in');
            });

            // Animate progress bars
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 500);
            });
        });

        function printResult() {
            window.print();
        }

        function shareResult() {
            if (navigator.share) {
                navigator.share({
                    title: 'Hasil Quiz',
                    text: 'Saya telah menyelesaikan quiz dan mendapat skor {{ $hasil->skor ?? "N/A" }}!',
                    url: window.location.href
                });
            } else {
                // Fallback for browsers that don't support Web Share API
                const url = window.location.href;
                navigator.clipboard.writeText(url).then(() => {
                    alert('Link hasil telah disalin ke clipboard!');
                }).catch(() => {
                    // Fallback if clipboard API is not available
                    const textArea = document.createElement('textarea');
                    textArea.value = url;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                    alert('Link hasil telah disalin ke clipboard!');
                });
            }
        }
    </script>

    <style>
        /* Main Card Styles */
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        .card.fade-in {
            opacity: 1;
            transform: translateY(0);
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        /* Gradient Backgrounds */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
        }

        .bg-gradient-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ffa8a8 100%);
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
        }

        /* Question Detail Styles */
        .question-item {
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(10px);
        }

        .question-item.fade-in-question {
            opacity: 1;
            transform: translateY(0);
        }

        .question-item:hover {
            background-color: #f8f9fa;
        }

        .question-number {
            flex-shrink: 0;
        }

        .question-content {
            transition: all 0.3s ease;
        }

        .answer-box {
            transition: all 0.2s ease;
            border-width: 2px;
        }

        .answer-box:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .toggle-detail {
            border: none !important;
            padding: 0.25rem 0.5rem;
            transition: all 0.2s ease;
        }

        .toggle-detail:hover {
            background-color: #e9ecef;
            border-radius: 0.375rem;
        }

        /* Background Subtle Colors */
        .bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }

        .bg-danger-subtle {
            background-color: rgba(220, 53, 69, 0.1) !important;
        }

        .bg-info-subtle {
            background-color: rgba(13, 202, 240, 0.1) !important;
        }

        .bg-warning-subtle {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }

        .bg-secondary-subtle {
            background-color: rgba(108, 117, 125, 0.1) !important;
        }

        /* Text Colors */
        .text-success {
            color: #198754 !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .text-info {
            color: #0dcaf0 !important;
        }

        .text-warning {
            color: #ffc107 !important;
        }

        .text-secondary {
            color: #6c757d !important;
        }

        /* Border Colors */
        .border-success {
            border-color: #198754 !important;
        }

        .border-danger {
            border-color: #dc3545 !important;
        }

        .border-info {
            border-color: #0dcaf0 !important;
        }

        .border-warning {
            border-color: #ffc107 !important;
        }

        .border-secondary {
            border-color: #6c757d !important;
        }

        /* Filter Button Styles */
        .btn-outline-primary.active,
        .btn-outline-success.active,
        .btn-outline-danger.active,
        .btn-outline-secondary.active,
        .btn-outline-warning.active,
        .btn-outline-info.active {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
            color: white;
        }

        .btn-outline-success.active {
            background-color: var(--bs-success);
            border-color: var(--bs-success);
        }

        .btn-outline-danger.active {
            background-color: var(--bs-danger);
            border-color: var(--bs-danger);
        }

        .btn-outline-warning.active {
            background-color: var(--bs-warning);
            border-color: var(--bs-warning);
            color: black;
        }

        .btn-outline-info.active {
            background-color: var(--bs-info);
            border-color: var(--bs-info);
            color: white;
        }

        .btn-outline-secondary.active {
            background-color: var(--bs-secondary);
            border-color: var(--bs-secondary);
        }

        /* Progress Bar Animation */
        .progress {
            background-color: #e9ecef;
            border-radius: 0.5rem;
        }

        .progress-bar {
            transition: width 1.5s ease-in-out;
            border-radius: 0.5rem;
        }

        /* Badge Styles */
        .badge {
            font-size: 0.875em;
            font-weight: 500;
        }

        /* Table Styles */
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .table-success {
            background-color: rgba(25, 135, 84, 0.1);
        }

        /* Animation Keyframes */
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

        @keyframes fadeInQuestion {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-question {
            animation: fadeInQuestion 0.5s ease forwards;
        }

        /* Pre styling for essay answers */
        pre {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            white-space: pre-wrap;
            word-wrap: break-word;
            margin: 0;
        }

        /* Multiple Choice Option Styles */
        .question-item .answer-option {
            transition: all 0.2s ease;
        }

        .question-item .answer-option:hover {
            transform: translateX(5px);
        }

        /* Checkbox Styles */
        .form-check-input:disabled {
            opacity: 0.7;
        }

        .form-check-input:checked:disabled {
            background-color: #198754;
            border-color: #198754;
        }

        /* Unknown Answer Styles */
        .unknown-answer {
            border-left: 4px solid #6c757d !important;
        }

        .unknown-answer:hover {
            background-color: #f8f9fa;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .d-flex.gap-2 {
                flex-wrap: wrap;
            }

            .btn-sm {
                margin-bottom: 0.25rem;
                font-size: 0.8rem;
            }

            .question-number {
                margin-bottom: 1rem;
            }

            .col-md-6 {
                margin-bottom: 1rem;
            }

            .card-body {
                padding: 1rem;
            }

            .answer-box {
                font-size: 0.9rem;
            }

            /* Stack statistics on mobile */
            .col-md-2 {
                margin-bottom: 1rem;
            }

            /* Adjust multiple choice options on mobile */
            .answer-option .col-md-6 {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }

        @media (max-width: 576px) {
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }

            .badge {
                font-size: 0.7rem;
            }

            .fs-4 {
                font-size: 1.2rem !important;
            }

            .card-header .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .card-header .d-flex .d-flex {
                margin-top: 1rem;
                width: 100%;
                justify-content: flex-start;
            }
        }

        /* Print Styles */
        @media print {
            .btn,
            .breadcrumb,
            .toggle-detail {
                display: none !important;
            }

            .card {
                box-shadow: none !important;
                border: 1px solid #dee2e6 !important;
                break-inside: avoid;
            }

            .question-content {
                display: block !important;
            }

            .bg-gradient-primary,
            .bg-gradient-success,
            .bg-gradient-danger,
            .bg-gradient-warning {
                background: #f8f9fa !important;
                color: #000 !important;
            }

            .text-white {
                color: #000 !important;
            }
        }

        /* Icon Styles */
        .ti {
            font-size: 1.2em;
        }

        /* Additional utility classes */
        .fs-4 {
            font-size: 1.5rem !important;
        }

        .fs-5 {
            font-size: 1.25rem !important;
        }

        .text-white-75 {
            color: rgba(255, 255, 255, 0.75) !important;
        }

        .breadcrumb-light .breadcrumb-item + .breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.7);
        }

        /* Loading Animation for Progress Bars */
        .progress-bar-animated {
            animation: progress-bar-stripes 1s linear infinite;
        }

        @keyframes progress-bar-stripes {
            0% {
                background-position-x: 1rem;
            }
        }

        /* Enhanced hover effects */
        .question-item:hover .question-number .badge {
            transform: scale(1.1);
        }

        .answer-box:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Status specific styles */
        .correct-answer {
            border-left: 4px solid #198754 !important;
        }

        .wrong-answer {
            border-left: 4px solid #dc3545 !important;
        }

        .pending-answer {
            border-left: 4px solid #ffc107 !important;
        }

        .partial-answer {
            border-left: 4px solid #0dcaf0 !important;
        }

        /* Focus states for accessibility */
        .btn:focus,
        .toggle-detail:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        /* Improved table responsive */
        .table-responsive {
            border-radius: 0.375rem;
        }

        /* Custom scrollbar for question container */
        .question-container::-webkit-scrollbar {
            width: 8px;
        }

        .question-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .question-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        .question-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
@endsection