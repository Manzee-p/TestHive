@extends('layouts.backend')
@section('content')
    <div class="container-fluid px-3 px-lg-4">
        <!-- Modern Header Section -->
        <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5">
            <div class="card-body px-4 py-4">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h3 class="fw-bold mb-3 text-white">Histori Pengerjaan Quiz</h3>
                        <p class="text-white-75 mb-3">Pantau semua hasil quiz yang telah Anda kerjakan</p>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light">
                                <li class="breadcrumb-item">
                                    <a class="text-white-75 text-decoration-none" href="">
                                        <i class="ti ti-home me-1"></i>Dasbor
                                    </a>
                                </li>
                                <li class="breadcrumb-item active text-white" aria-current="page">Histori Quiz</li>
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

        <!-- Enhanced Statistics Cards -->
        <div class="row g-3 g-lg-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 64px; height: 64px;">
                            <i class="ti ti-file-text text-primary fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-primary mb-1 fs-4">{{ $histori->count() ?? 0 }}</h3>
                        <p class="text-muted mb-0 small">Total Quiz</p>
                    </div>
                </div>
            </div>

            @php
                $totalBenar = $histori->sum('jumlah_benar');
                $totalSalah = $histori->sum('jumlah_salah');
                $rataRata = $histori->avg('skor');
            @endphp

            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 64px; height: 64px;">
                            <i class="ti ti-check text-success fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-success mb-1 fs-4">{{ $totalBenar }}</h3>
                        <p class="text-muted mb-0 small">Jawaban Benar</p>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-danger bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 64px; height: 64px;">
                            <i class="ti ti-x text-danger fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-danger mb-1 fs-4">{{ $totalSalah }}</h3>
                        <p class="text-muted mb-0 small">Jawaban Salah</p>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 64px; height: 64px;">
                            <i class="ti ti-star text-warning fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-warning mb-1 fs-4">{{ number_format($rataRata ?? 0, 1) }}</h3>
                        <p class="text-muted mb-0 small">Rata-rata Skor</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Action Section -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center g-3">
                    <div class="col-md-7">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
                                     style="width: 48px; height: 48px;">
                                    <i class="ti ti-history text-success fs-5"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-semibold">Riwayat Pengerjaan Quiz</h5>
                                <p class="text-muted mb-0">
                                    @if ($histori->count() > 0)
                                        Menampilkan {{ $histori->count() }} hasil quiz yang telah dikerjakan
                                    @else
                                        Belum ada riwayat pengerjaan quiz
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Table Section -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-bottom-0 py-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h5 class="mb-0 fw-semibold d-flex align-items-center">
                        <i class="ti ti-table me-2 text-success"></i>Tabel Histori Pengerjaan
                    </h5>
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                        {{ $histori->count() }} Hasil Tersedia
                    </span>
                </div>
            </div>

            @if ($histori->count() > 0)
                <div class="card-body p-0">
                    <!-- Mobile Card View (Hidden on larger screens) -->
                    <div class="d-block d-lg-none">
                        @foreach ($histori as $index => $item)
                            @php
                                $totalSoal = $item->jumlah_benar + $item->jumlah_salah;
                                $persentase = $totalSoal > 0 ? round(($item->jumlah_benar / $totalSoal) * 100, 1) : 0;
                                $status = $persentase >= 75 ? 'Lulus' : ($persentase >= 50 ? 'Cukup' : 'Tidak Lulus');
                                $statusColor = $persentase >= 75 ? 'success' : ($persentase >= 50 ? 'warning' : 'danger');
                                $statusIcon = $persentase >= 75 ? 'check-circle' : ($persentase >= 50 ? 'clock' : 'x-circle');
                                $totalDetik = round($item->waktu_pengerjaan * 60);
                                $menit = floor($totalDetik / 60);
                                $detik = $totalDetik % 60;
                            @endphp
                            
                            <div class="border-bottom p-3">
                                <div class="d-flex align-items-start justify-content-between mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                             style="width: 40px; height: 40px;">
                                            <span class="text-primary fw-bold small">{{ $index + 1 }}</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-semibold">{{ $item->quiz->judul_quiz ?? 'Quiz Title' }}</h6>
                                            <small class="text-muted">{{ $item->quiz->kategori->nama_kategori ?? 'Kategori Umum' }}</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-{{ $statusColor }} bg-opacity-10 text-{{ $statusColor }} px-2 py-1 rounded-pill">
                                        <i class="ti ti-{{ $statusIcon }} me-1" style="font-size: 12px;"></i>{{ $status }}
                                    </span>
                                </div>
                                
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <div class="text-center bg-light rounded p-2">
                                            <div class="fw-bold text-warning">{{ $item->skor }}</div>
                                            <small class="text-muted">Skor</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-center bg-light rounded p-2">
                                            <div class="fw-bold text-info">{{ $menit }}:{{ str_pad($detik, 2, '0', STR_PAD_LEFT) }}</div>
                                            <small class="text-muted">Waktu</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row g-2 mb-3">
                                    <div class="col-4">
                                        <div class="text-center">
                                            <div class="fw-bold text-success">{{ $item->jumlah_benar }}</div>
                                            <small class="text-muted">Benar</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-center">
                                            <div class="fw-bold text-danger">{{ $item->jumlah_salah }}</div>
                                            <small class="text-muted">Salah</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-center">
                                            <div class="fw-bold text-muted">
                                                {{ $item->tanggal_ujian ? \Carbon\Carbon::parse($item->tanggal_ujian)->format('d/m') : date('d/m') }}
                                            </div>
                                            <small class="text-muted">Tanggal</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-grid">
                                    <a href="{{ route('quiz.hasil', $item->id) }}" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="ti ti-eye me-1"></i>Lihat Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Desktop Table View (Hidden on mobile) -->
                    <div class="d-none d-lg-block">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="historiTable">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="border-0 fw-semibold py-3 ps-4">#</th>
                                        <th scope="col" class="border-0 fw-semibold py-3">Quiz</th>
                                        <th scope="col" class="border-0 fw-semibold py-3 text-center">Tanggal</th>
                                        <th scope="col" class="border-0 fw-semibold py-3 text-center">Skor</th>
                                        <th scope="col" class="border-0 fw-semibold py-3 text-center">Benar</th>
                                        <th scope="col" class="border-0 fw-semibold py-3 text-center">Salah</th>
                                        <th scope="col" class="border-0 fw-semibold py-3 text-center">Waktu</th>
                                        <th scope="col" class="border-0 fw-semibold py-3 text-center">Status</th>
                                        <th scope="col" class="border-0 fw-semibold py-3 text-center pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($histori as $index => $item)
                                        @php
                                            $totalSoal = $item->jumlah_benar + $item->jumlah_salah;
                                            $persentase = $totalSoal > 0 ? round(($item->jumlah_benar / $totalSoal) * 100, 1) : 0;
                                            $status = $persentase >= 75 ? 'Lulus' : ($persentase >= 50 ? 'Cukup' : 'Tidak Lulus');
                                            $statusColor = $persentase >= 75 ? 'success' : ($persentase >= 50 ? 'warning' : 'danger');
                                            $statusIcon = $persentase >= 75 ? 'check-circle' : ($persentase >= 50 ? 'clock' : 'x-circle');
                                            $totalDetik = round($item->waktu_pengerjaan * 60);
                                            $menit = floor($totalDetik / 60);
                                            $detik = $totalDetik % 60;
                                        @endphp
                                        
                                        <tr class="border-0">
                                            <td class="ps-4">
                                                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                                                     style="width: 32px; height: 32px;">
                                                    <span class="text-primary fw-semibold small">{{ $index + 1 }}</span>
                                                </div>
                                            </td>
                                            
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                                         style="width: 40px; height: 40px;">
                                                        <i class="ti ti-file-text text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1 fw-semibold">{{ $item->quiz->judul_quiz ?? 'Quiz Title' }}</h6>
                                                        <small class="text-muted">{{ $item->quiz->kategori->nama_kategori ?? 'Kategori Umum' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            <td class="text-center">
                                                <div>
                                                    <div class="fw-semibold">
                                                        {{ $item->tanggal_ujian ? \Carbon\Carbon::parse($item->tanggal_ujian)->format('d M Y') : date('d M Y') }}
                                                    </div>
                                                    <small class="text-muted">
                                                        {{ $item->created_at ? $item->created_at->format('H:i') : date('H:i') }}
                                                    </small>
                                                </div>
                                            </td>
                                            
                                            <td class="text-center">
                                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">
                                                    {{ $item->skor }}
                                                </span>
                                            </td>
                                            
                                            <td class="text-center">
                                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                                    {{ $item->jumlah_benar }}
                                                </span>
                                            </td>
                                            
                                            <td class="text-center">
                                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">
                                                    {{ $item->jumlah_salah }}
                                                </span>
                                            </td>
                                            
                                            <td class="text-center">
                                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">
                                                    {{ $menit }}:{{ str_pad($detik, 2, '0', STR_PAD_LEFT) }}
                                                </span>
                                            </td>
                                            
                                            <td class="text-center">
                                                <span class="badge bg-{{ $statusColor }} bg-opacity-10 text-{{ $statusColor }} px-3 py-2 rounded-pill">
                                                    <i class="ti ti-{{ $statusIcon }} me-1"></i>{{ $status }}
                                                </span>
                                            </td>
                                            
                                            <td class="text-center pe-4">
                                                <a href="{{ route('quiz.hasil', $item->id) }}" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="ti ti-eye me-1"></i>Lihat
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
                <!-- Enhanced Empty State -->
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-4"
                             style="width: 120px; height: 120px;">
                            <i class="ti ti-history text-success" style="font-size: 3rem;"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold mb-3">Belum Ada Riwayat Quiz</h3>
                    <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">
                        Anda belum mengerjakan quiz apapun. Mulai kerjakan quiz untuk melihat
                        riwayat dan hasil pencapaian Anda di sini.
                    </p>
                    <a href="{{ route('quiz.index') }}" class="btn btn-success btn-lg px-4 py-3">
                        <i class="ti ti-play me-2"></i>Mulai Quiz Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Enhanced Toast Container -->
    <div id="toastContainer" class="position-fixed top-0 end-0 p-3" style="z-index: 1050;"></div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast('success', '{{ session('success') }}');
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast('error', '{{ session('error') }}');
            });
        </script>
    @endif

    <script>
        // Enhanced Export to Excel Function
        function exportToExcel() {
            const table = document.getElementById('historiTable');
            if (!table) {
                showToast('error', 'Tidak ada data untuk diekspor');
                return;
            }

            let csvContent = '\uFEFF'; // BOM for UTF-8
            const rows = table.querySelectorAll('tr');

            rows.forEach((row, index) => {
                const cells = row.querySelectorAll('th, td');
                const rowData = [];

                cells.forEach(cell => {
                    let cellText = cell.textContent.trim();
                    cellText = cellText.replace(/\s+/g, ' ');
                    cellText = cellText.replace(/"/g, '""'); // Escape quotes
                    rowData.push('"' + cellText + '"');
                });

                csvContent += rowData.join(',') + '\r\n';
            });

            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);

            link.setAttribute('href', url);
            link.setAttribute('download', `histori_quiz_${new Date().toISOString().split('T')[0]}.csv`);
            link.style.display = 'none';

            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            showToast('success', 'Data berhasil diekspor ke Excel!');
        }

        // Enhanced Export to PDF Function
        function exportToPDF() {
            // Add print-specific styles temporarily
            const printStylesheet = document.createElement('style');
            printStylesheet.innerHTML = `
                @media print {
                    body * { visibility: hidden; }
                    .card, .card * { visibility: visible; }
                    .card { position: absolute; top: 0; left: 0; right: 0; }
                    .btn, .breadcrumb, .position-fixed, #toastContainer { display: none !important; }
                    .table { font-size: 12px; }
                    .badge { background-color: #f8f9fa !important; color: #000 !important; }
                    .card-header { background-color: #f8f9fa !important; }
                }
            `;
            document.head.appendChild(printStylesheet);

            // Trigger print dialog
            window.print();

            // Remove print styles after a delay
            setTimeout(() => {
                document.head.removeChild(printStylesheet);
            }, 1000);

            showToast('success', 'Halaman siap untuk dicetak sebagai PDF!');
        }

        // Enhanced Toast Function
        function showToast(type, message) {
            const toastContainer = document.getElementById('toastContainer');
            const toastId = 'toast-' + Date.now();
            
            const toastColor = type === 'success' ? 'success' : 'danger';
            const toastIcon = type === 'success' ? 'check' : 'x';
            const toastTitle = type === 'success' ? 'Berhasil' : 'Error';

            const toastHTML = `
                <div id="${toastId}" class="toast show border-0 shadow-lg mb-2" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-${toastColor} text-white border-0">
                        <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center me-2" 
                             style="width: 20px; height: 20px;">
                            <i class="ti ti-${toastIcon} text-white" style="font-size: 12px;"></i>
                        </div>
                        <strong class="me-auto">${toastTitle}</strong>
                        <button type="button" class="btn-close btn-close-white ms-2" onclick="removeToast('${toastId}')"></button>
                    </div>
                    <div class="toast-body bg-white text-dark">
                        ${message}
                    </div>
                </div>
            `;

            toastContainer.insertAdjacentHTML('beforeend', toastHTML);

            // Auto remove after 5 seconds
            setTimeout(() => {
                removeToast(toastId);
            }, 5000);
        }

        function removeToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }
        }

        // Add hover effects and smooth transitions
        document.addEventListener('DOMContentLoaded', function() {
            // Add custom CSS for modern effects
            const style = document.createElement('style');
            style.textContent = `
                .hover-lift {
                    transition: all 0.3s ease;
                }
                .hover-lift:hover {
                    transform: translateY(-4px);
                    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
                }
                .breadcrumb-style-2 .breadcrumb-item + .breadcrumb-item::before {
                    content: "›";
                    font-weight: bold;
                    font-size: 1.2em;
                }
                .table tbody tr {
                    transition: all 0.2s ease;
                }
                .table tbody tr:hover {
                    background-color: rgba(0,123,255,0.05);
                    transform: scale(1.01);
                }
                .btn {
                    transition: all 0.2s ease;
                }
                .btn:hover {
                    transform: translateY(-1px);
                }
                .badge {
                    font-weight: 500;
                }
                @media (max-width: 991.98px) {
                    .display-6 { font-size: 1.75rem; }
                    .lead { font-size: 1rem; }
                }
            `;
            document.head.appendChild(style);
        });
    </script>

    @include('layouts.components-backend.css')
@endsection