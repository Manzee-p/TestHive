@extends('layouts.backend')
@section('title', 'Hasil Quiz Keseluruhan')
@section('content')
<div class="container-fluid">
    <!-- Enhanced Header Section -->
    <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5">
        <div class="card-body px-4 py-4">
            <div class="row align-items-center">
                <div class="col-9">
                    <h3 class="fw-bold mb-3 text-white">Hasil Quiz Keseluruhan</h3>
                    <p class="text-white-75 mb-3">Lihat dan kelola semua hasil quiz dari peserta</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-light">
                            <li class="breadcrumb-item">
                                <a class="text-white-75 text-decoration-none" href="{{ route('admin.quiz-terbaru') }}">
                                    <i class="ti ti-home me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Hasil Quiz</li>
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

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ti ti-alert-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Enhanced Action Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px;">
                                <i class="ti ti-chart-bar text-primary"></i>
                            </div>
                        </div>
                        <div>
                            <h5 class="mb-1">Filter Hasil Quiz</h5>
                            <p class="text-muted mb-0">Pilih quiz untuk melihat hasil yang spesifik</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <form method="GET" action="{{ route('quiz.hasil.keseluruhan') }}" id="filterForm">
                        <div class="d-flex gap-2">
                            <select name="quiz_id" id="quiz_id" class="form-select">
                                <option value="">Semua Quiz</option>
                                @foreach($quizList as $quiz)
                                    <option value="{{ $quiz->id }}" {{ request('quiz_id') == $quiz->id ? 'selected' : '' }}>
                                        {{ $quiz->judul_quiz }} ({{ $quiz->kode_quiz }})
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-filter"></i>
                            </button>
                            <a href="{{ route('quiz.hasil.keseluruhan') }}" class="btn btn-secondary">
                                <i class="ti ti-refresh"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics Section --}}
    @if($statistik)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-transparent border-bottom py-3">
            <h5 class="mb-0 fw-bold">
                <i class="ti ti-chart-bar me-2 text-primary"></i>Statistik Quiz: {{ $statistik['quiz_title'] }}
            </h5>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-2">
                    <div class="d-flex flex-column align-items-center p-3">
                        <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center mb-2"
                            style="width: 50px; height: 50px;">
                            <i class="ti ti-users text-primary" style="font-size: 24px;"></i>
                        </div>
                        <h4 class="text-primary mb-1">{{ $statistik['total_peserta'] }}</h4>
                        <p class="text-muted mb-0">Total Peserta</p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex flex-column align-items-center p-3">
                        <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center mb-2"
                            style="width: 50px; height: 50px;">
                            <i class="ti ti-chart-line text-info" style="font-size: 24px;"></i>
                        </div>
                        <h4 class="text-info mb-1">{{ number_format($statistik['rata_rata_skor'], 1) }}</h4>
                        <p class="text-muted mb-0">Rata-rata Skor</p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex flex-column align-items-center p-3">
                        <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center mb-2"
                            style="width: 50px; height: 50px;">
                            <i class="ti ti-trophy text-success" style="font-size: 24px;"></i>
                        </div>
                        <h4 class="text-success mb-1">{{ number_format($statistik['skor_tertinggi'], 1) }}</h4>
                        <p class="text-muted mb-0">Skor Tertinggi</p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex flex-column align-items-center p-3">
                        <div class="rounded-circle bg-warning-subtle d-flex align-items-center justify-content-center mb-2"
                            style="width: 50px; height: 50px;">
                            <i class="ti ti-arrow-down text-warning" style="font-size: 24px;"></i>
                        </div>
                        <h4 class="text-warning mb-1">{{ number_format($statistik['skor_terendah'], 1) }}</h4>
                        <p class="text-muted mb-0">Skor Terendah</p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex flex-column align-items-center p-3">
                        <div class="rounded-circle bg-secondary-subtle d-flex align-items-center justify-content-center mb-2"
                            style="width: 50px; height: 50px;">
                            <i class="ti ti-clock text-secondary" style="font-size: 24px;"></i>
                        </div>
                        <h4 class="text-secondary mb-1">{{ number_format($statistik['rata_rata_waktu'], 1) }}</h4>
                        <p class="text-muted mb-0">Rata-rata Waktu (menit)</p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex flex-column align-items-center p-3">
                        <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center mb-2"
                            style="width: 50px; height: 50px;">
                            <i class="ti ti-key text-info" style="font-size: 24px;"></i>
                        </div>
                        <div class="badge bg-primary-subtle text-primary px-3 py-2 mb-1">
                            <strong>{{ $statistik['quiz_code'] }}</strong>
                        </div>
                        <p class="text-muted mb-0">Kode Quiz</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Enhanced Results Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-bottom py-3">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold">
                    <i class="ti ti-table me-2 text-primary"></i>Daftar Hasil Quiz
                </h5>
                <div class="d-flex align-items-center">
                    <span class="badge bg-primary-subtle text-primary px-3 py-2">
                        {{ $hasilUjian->total() }} Hasil Tersedia
                    </span>
                </div>
            </div>
        </div>

        @if($hasilUjian->count() > 0)
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover quiz-table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="border-0 fw-bold text-dark py-3">
                                      No
                                </th>
                                <th scope="col" class="border-0 fw-bold text-dark py-3">
                                    <i class="ti ti-user me-1"></i>Peserta
                                </th>
                                <th scope="col" class="border-0 fw-bold text-dark py-3">
                                    <i class="ti ti-file-text me-1"></i>Quiz
                                </th>
                                <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                    <i class="ti ti-calendar me-1"></i>Tanggal
                                </th>
                                <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                    <i class="ti ti-chart-bar me-1"></i>Skor
                                </th>
                                <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                    <i class="ti ti-weight me-1"></i>Bobot
                                </th>
                                <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                    <i class="ti ti-check-circle me-1"></i>Benar/Salah
                                </th>
                                <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                    <i class="ti ti-clock me-1"></i>Waktu
                                </th>
                                <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                    <i class="ti ti-circle-check me-1"></i>Status
                                </th>
                                <th scope="col" class="border-0 fw-bold text-dark py-3 text-center pe-4">
                                    <i class="ti ti-settings me-1"></i>Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hasilUjian as $index => $hasil)
                                <tr class="quiz-row">
                                    <td class="py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3"
                                                style="width: 35px; height: 35px;">
                                                <span class="text-primary fw-bold">{{ $hasilUjian->firstItem() + $index }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- PESERTA -->
                                    <td class="py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center me-3"
                                                style="width: 40px; height: 40px;">
                                                <i class="ti ti-user text-info"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-bold text-dark">{{ $hasil->user->name }}</h6>
                                                <small class="text-muted">{{ $hasil->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- QUIZ -->
                                    <td class="py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-secondary-subtle d-flex align-items-center justify-content-center me-3"
                                                style="width: 40px; height: 40px;">
                                                <i class="ti ti-file-text text-secondary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-bold text-dark" title="{{ $hasil->quiz->judul_quiz }}">
                                                    {{ Str::limit($hasil->quiz->judul_quiz, 30) }}
                                                </h6>
                                                <small class="text-muted">
                                                    <span class="badge bg-info-subtle text-info">{{ $hasil->quiz->kode_quiz }}</span>
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- TANGGAL -->
                                    <td class="py-4 text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="d-flex align-items-center mb-1">
                                                <div class="rounded-circle bg-warning-subtle d-flex align-items-center justify-content-center me-2"
                                                    style="width: 30px; height: 30px;">
                                                    <i class="ti ti-calendar text-warning" style="font-size: 14px;"></i>
                                                </div>
                                                <span class="fw-bold text-dark">{{ Carbon\Carbon::parse($hasil->tanggal_ujian)->format('d M Y') }}</span>
                                            </div>
                                            <small class="text-muted">
                                                <i class="ti ti-clock me-1"></i>{{ Carbon\Carbon::parse($hasil->created_at)->format('H:i') }}
                                            </small>
                                        </div>
                                    </td>
                                    
                                    <!-- SKOR -->
                                    <td class="py-4 text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            @php
                                                $skorClass = '';
                                                $skorIcon = '';
                                                if($hasil->skor >= 80) {
                                                    $skorClass = 'success';
                                                    $skorIcon = 'trophy';
                                                } elseif($hasil->skor >= 60) {
                                                    $skorClass = 'warning';
                                                    $skorIcon = 'star';
                                                } else {
                                                    $skorClass = 'danger';
                                                    $skorIcon = 'alert-circle';
                                                }
                                            @endphp
                                            <div class="rounded-circle bg-{{ $skorClass }}-subtle d-flex align-items-center justify-content-center mb-2"
                                                style="width: 40px; height: 40px;">
                                                <i class="ti ti-{{ $skorIcon }} text-{{ $skorClass }}" style="font-size: 16px;"></i>
                                            </div>
                                            <h5 class="mb-0 text-{{ $skorClass }} fw-bold">{{ number_format($hasil->skor, 1) }}</h5>
                                            <small class="text-muted">/ 100</small>
                                        </div>
                                    </td>
                                    
                                    <!-- BOBOT -->
                                    <td class="py-4 text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="rounded-circle bg-purple-subtle d-flex align-items-center justify-content-center mb-2"
                                                style="width: 40px; height: 40px;">
                                                <i class="ti ti-weight text-purple" style="font-size: 16px;"></i>
                                            </div>
                                            <span class="fw-bold text-purple">{{ number_format($hasil->bobot_diperoleh, 1) }}</span>
                                            <small class="text-muted">/ {{ $hasil->total_bobot }}</small>
                                        </div>
                                    </td>
                                    
                                    <!-- BENAR/SALAH -->
                                    <td class="py-4 text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center mb-1"
                                                    style="width: 30px; height: 30px;">
                                                    <i class="ti ti-check text-success" style="font-size: 14px;"></i>
                                                </div>
                                                <span class="text-success fw-bold">{{ $hasil->jumlah_benar }}</span>
                                            </div>
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="rounded-circle bg-danger-subtle d-flex align-items-center justify-content-center mb-1"
                                                    style="width: 30px; height: 30px;">
                                                    <i class="ti ti-x text-danger" style="font-size: 14px;"></i>
                                                </div>
                                                <span class="text-danger fw-bold">{{ $hasil->jumlah_salah }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- WAKTU -->
                                    <td class="py-4 text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center mb-2"
                                                style="width: 40px; height: 40px;">
                                                <i class="ti ti-clock text-info" style="font-size: 16px;"></i>
                                            </div>
                                            <span class="fw-bold text-info">{{ number_format($hasil->waktu_pengerjaan, 1) }}</span>
                                            <small class="text-muted">menit</small>
                                        </div>
                                    </td>
                                    
                                    <!-- STATUS -->
                                    <td class="py-4 text-center">
                                        @php
                                            $hasEssayPending = $hasil->detail->where('status_jawaban', 'pending')->count() > 0;
                                        @endphp
                                        <span class="badge bg-{{ $hasEssayPending ? 'warning' : 'success' }}-subtle 
                                                text-{{ $hasEssayPending ? 'warning' : 'success' }} px-3 py-2">
                                            <i class="ti ti-{{ $hasEssayPending ? 'clock' : 'check-circle' }} me-1"></i>
                                            {{ $hasEssayPending ? 'Menunggu Penilaian' : 'Selesai' }}
                                        </span>
                                    </td>
                                    
                                    <!-- AKSI -->
                                    <td class="py-4 text-center pe-4">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('quiz.hasil.detail', $hasil->id) }}" 
                                               class="btn btn-info btn-sm" title="Lihat Detail">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" title="Hapus Hasil"
                                                onclick="deleteResult({{ $hasil->id }}, '{{ $hasil->user->name }}')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Hidden delete form -->
                                        <form id="delete-form-{{ $hasil->id }}"
                                            action="{{ route('quiz.hasil.hapus', $hasil->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if($hasilUjian instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="card-footer bg-transparent">
                    <div class="row align-items-center">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info text-muted">
                                Menampilkan {{ $hasilUjian->firstItem() }} sampai {{ $hasilUjian->lastItem() }} dari {{ $hasilUjian->total() }} hasil
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="d-flex justify-content-end">
                                {{ $hasilUjian->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <!-- Enhanced Empty State -->
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <div class="rounded-circle bg-warning-subtle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 100px; height: 100px;">
                        <i class="ti ti-chart-bar text-warning" style="font-size: 48px;"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-3">Belum Ada Hasil Quiz</h3>
                <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">
                    Belum ada peserta yang mengerjakan quiz atau tidak ada hasil yang sesuai dengan filter yang dipilih.
                </p>
                @if(request()->filled('quiz_id'))
                    <a href="{{ route('quiz.hasil.keseluruhan') }}" class="btn btn-primary btn-lg px-5">
                        <i class="ti ti-refresh me-2"></i>Lihat Semua Hasil
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<script>
// Delete confirmation function
function deleteResult(resultId, userName) {
    if (confirm(`Apakah Anda yakin ingin menghapus hasil quiz dari "${userName}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
        document.getElementById('delete-form-' + resultId).submit();
    }
}
</script>
@include('layouts.components-backend.css')
@endsection