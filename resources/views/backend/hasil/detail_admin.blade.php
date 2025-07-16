@extends('layouts.backend')
@section('title', 'Detail Hasil Quiz')
@section('content')
<div class="container-fluid">
    <!-- Enhanced Header Section -->
    <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5">
        <div class="card-body px-4 py-4">
            <div class="row align-items-center">
                <div class="col-9">
                    <h3 class="fw-bold mb-3 text-white">Detail Hasil Quiz</h3>
                    <p class="text-white-75 mb-3">Informasi lengkap hasil quiz peserta</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-light">
                            <li class="breadcrumb-item">
                                <a class="text-white-75 text-decoration-none" href="{{ route('admin.quiz-terbaru') }}">
                                    <i class="ti ti-home me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="text-white-75 text-decoration-none" href="{{ route('quiz.hasil.keseluruhan') }}">
                                    Hasil Quiz
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Detail</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center">
                        <img src="{{ asset('assets/backend/images/breadcrumb/ChatBc.png') }}" alt="quiz-detail"
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

    <!-- Action Buttons -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px;">
                                <i class="ti ti-user text-primary"></i>
                            </div>
                        </div>
                        <div>
                            <h5 class="mb-1">{{ $hasil->user->name }}</h5>
                            <p class="text-muted mb-0">{{ $hasil->user->email }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('quiz.hasil.keseluruhan') }}" class="btn btn-secondary me-2">
                        <i class="ti ti-arrow-left me-1"></i>Kembali
                    </a>
                    <button type="button" class="btn btn-danger" onclick="deleteResult({{ $hasil->id }}, '{{ $hasil->user->name }}')">
                        <i class="ti ti-trash me-1"></i>Hapus Hasil
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Quiz Info & Score Summary -->
    <div class="row mb-4">
        <!-- Quiz Information -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="ti ti-file-text me-2 text-primary"></i>Informasi Quiz
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center me-3"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-file-text text-info"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $hasil->quiz->judul_quiz }}</h6>
                                    <small class="text-muted">Judul Quiz</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-key text-primary"></i>
                                </div>
                                <div>
                                    <span class="badge bg-primary-subtle text-primary px-3 py-2">{{ $hasil->quiz->kode_quiz }}</span>
                                    <div><small class="text-muted">Kode Quiz</small></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center me-3"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-book text-success"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $hasil->quiz->mataPelajaran->nama_mapel }}</h6>
                                    <small class="text-muted">Mata Pelajaran</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-warning-subtle d-flex align-items-center justify-content-center me-3"
                                    style="width: 40px; height: 40px;">
                                    <i class="ti ti-clock text-warning"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $hasil->quiz->waktu_menit }} Menit</h6>
                                    <small class="text-muted">Durasi Quiz</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Score Summary -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="ti ti-chart-bar me-2 text-primary"></i>Ringkasan Skor
                    </h5>
                </div>
                <div class="card-body text-center">
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
                    <div class="rounded-circle bg-{{ $skorClass }}-subtle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 80px; height: 80px;">
                        <i class="ti ti-{{ $skorIcon }} text-{{ $skorClass }}" style="font-size: 36px;"></i>
                    </div>
                    <h2 class="text-{{ $skorClass }} fw-bold mb-1">{{ number_format($hasil->skor, 1) }}</h2>
                    <p class="text-muted mb-3">dari 100 poin</p>
                    
                    <div class="row text-center">
                        <div class="col-4">
                            <h6 class="text-success mb-0">{{ $hasil->jumlah_benar }}</h6>
                            <small class="text-muted">Benar</small>
                        </div>
                        <div class="col-4">
                            <h6 class="text-danger mb-0">{{ $hasil->jumlah_salah }}</h6>
                            <small class="text-muted">Salah</small>
                        </div>
                        <div class="col-4">
                            <h6 class="text-info mb-0">{{ number_format($hasil->waktu_pengerjaan, 1) }}</h6>
                            <small class="text-muted">Menit</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ranking & Performance -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="ti ti-award me-2 text-primary"></i>Ranking & Performa
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="d-flex flex-column align-items-center p-3">
                                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center mb-2"
                                    style="width: 50px; height: 50px;">
                                    <i class="ti ti-trophy text-primary" style="font-size: 24px;"></i>
                                </div>
                                <h4 class="text-primary mb-1">{{ $ranking }}</h4>
                                <p class="text-muted mb-0">Ranking</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex flex-column align-items-center p-3">
                                <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center mb-2"
                                    style="width: 50px; height: 50px;">
                                    <i class="ti ti-users text-info" style="font-size: 24px;"></i>
                                </div>
                                <h4 class="text-info mb-1">{{ $totalPeserta }}</h4>
                                <p class="text-muted mb-0">Total Peserta</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex flex-column align-items-center p-3">
                                <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center mb-2"
                                    style="width: 50px; height: 50px;">
                                    <i class="ti ti-weight text-success" style="font-size: 24px;"></i>
                                </div>
                                <h4 class="text-success mb-1">{{ number_format($hasil->bobot_diperoleh, 1) }}</h4>
                                <p class="text-muted mb-0">Bobot Diperoleh</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex flex-column align-items-center p-3">
                                <div class="rounded-circle bg-warning-subtle d-flex align-items-center justify-content-center mb-2"
                                    style="width: 50px; height: 50px;">
                                    <i class="ti ti-calendar text-warning" style="font-size: 24px;"></i>
                                </div>
                                <h4 class="text-warning mb-1">{{ Carbon\Carbon::parse($hasil->tanggal_ujian)->format('d M Y') }}</h4>
                                <p class="text-muted mb-0">Tanggal Ujian</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Answers -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-bottom py-3">
            <h5 class="mb-0 fw-bold">
                <i class="ti ti-list me-2 text-primary"></i>Detail Jawaban
            </h5>
        </div>
        <div class="card-body p-0">
            @if($detailByType && $detailByType->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 fw-bold text-dark py-3">No</th>
                                <th class="border-0 fw-bold text-dark py-3">Soal</th>
                                <th class="border-0 fw-bold text-dark py-3">Tipe</th>
                                <th class="border-0 fw-bold text-dark py-3">Jawaban Peserta</th>
                                <th class="border-0 fw-bold text-dark py-3">Jawaban Benar</th>
                                <th class="border-0 fw-bold text-dark py-3 text-center">Status</th>
                                <th class="border-0 fw-bold text-dark py-3 text-center">Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($detailByType->flatten() as $detail)
                                <tr>
                                    <td class="py-3">
                                        <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center"
                                            style="width: 30px; height: 30px;">
                                            <span class="text-primary fw-bold">{{ $no++ }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div class="fw-bold text-dark mb-1">{{ Str::limit($detail->soal->pertanyaan, 80) }}</div>
                                        @if($detail->soal->tipe == 'pilihan_ganda')
                                            <div class="mt-2">
                                                @php
                                                    $options = ['A' => $detail->soal->pilihan_a, 'B' => $detail->soal->pilihan_b, 'C' => $detail->soal->pilihan_c, 'D' => $detail->soal->pilihan_d];
                                                    if($detail->soal->pilihan_e) $options['E'] = $detail->soal->pilihan_e;
                                                @endphp
                                                @foreach($options as $key => $option)
                                                    @if($option)
                                                        <small class="d-block text-muted">{{ $key }}. {{ Str::limit($option, 50) }}</small>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        @php
                                            $typeClass = '';
                                            $typeText = '';
                                            switch($detail->soal->tipe) {
                                                case 'pilihan_ganda':
                                                    $typeClass = 'primary';
                                                    $typeText = 'Pilihan Ganda';
                                                    break;
                                                case 'essay':
                                                    $typeClass = 'info';
                                                    $typeText = 'Essay';
                                                    break;
                                                case 'benar_salah':
                                                    $typeClass = 'warning';
                                                    $typeText = 'Benar/Salah';
                                                    break;
                                                case 'checkbox':
                                                    $typeClass = 'secondary';
                                                    $typeText = 'Checkbox';
                                                    break;
                                                default:
                                                    $typeClass = 'dark';
                                                    $typeText = 'Unknown';
                                            }
                                        @endphp
                                        <span class="badge bg-{{ $typeClass }}-subtle text-{{ $typeClass }} px-3 py-2">
                                            {{ $typeText }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        @if($detail->soal->tipe == 'essay')
                                            <div class="bg-light p-2 rounded" style="max-height: 100px; overflow-y: auto;">
                                                {{ $detail->jawaban_peserta ?: 'Tidak dijawab' }}
                                            </div>
                                        @else
                                            <span class="fw-medium">{{ $detail->jawaban_peserta ?: 'Tidak dijawab' }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-medium text-success">{{ $detail->soal->jawaban_benar }}</span>
                                    </td>
                                    <td class="py-3 text-center">
                                        @php
                                            $statusClass = '';
                                            $statusText = '';
                                            $statusIcon = '';
                                            switch($detail->status_jawaban) {
                                                case 'benar':
                                                    $statusClass = 'success';
                                                    $statusText = 'Benar';
                                                    $statusIcon = 'check-circle';
                                                    break;
                                                case 'salah':
                                                    $statusClass = 'danger';
                                                    $statusText = 'Salah';
                                                    $statusIcon = 'x-circle';
                                                    break;
                                                case 'sebagian':
                                                    $statusClass = 'warning';
                                                    $statusText = 'Sebagian';
                                                    $statusIcon = 'alert-circle';
                                                    break;
                                                case 'pending':
                                                    $statusClass = 'info';
                                                    $statusText = 'Pending';
                                                    $statusIcon = 'clock';
                                                    break;
                                                default:
                                                    $statusClass = 'secondary';
                                                    $statusText = 'Unknown';
                                                    $statusIcon = 'help-circle';
                                            }
                                        @endphp
                                        <span class="badge bg-{{ $statusClass }}-subtle text-{{ $statusClass }} px-3 py-2">
                                            <i class="ti ti-{{ $statusIcon }} me-1"></i>{{ $statusText }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="fw-bold text-primary">{{ number_format($detail->bobot_diperoleh, 1) }}</div>
                                        <small class="text-muted">/ {{ $detail->bobot_soal }}</small>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="rounded-circle bg-warning-subtle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 80px; height: 80px;">
                        <i class="ti ti-help-circle text-warning" style="font-size: 36px;"></i>
                    </div>
                    <h5 class="mb-3">Detail Jawaban Tidak Tersedia</h5>
                    <p class="text-muted">Detail jawaban untuk hasil quiz ini tidak dapat ditampilkan.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus hasil quiz ini?</p>
                <div class="alert alert-warning">
                    <i class="ti ti-alert-triangle me-2"></i>
                    <strong>Peringatan:</strong> Data yang dihapus tidak dapat dikembalikan!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden delete form -->
<form id="delete-form-{{ $hasil->id }}" action="{{ route('quiz.hasil.hapus', $hasil->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
// Delete confirmation function
function deleteResult(resultId, userName) {
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
    
    document.getElementById('confirmDelete').onclick = function() {
        document.getElementById('delete-form-' + resultId).submit();
    };
}
</script>
@include('layouts.components-backend.css')
@endsection