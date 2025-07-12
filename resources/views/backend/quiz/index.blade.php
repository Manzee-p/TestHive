@extends('layouts.backend')
@section('content')
    <div class="container-fluid">
        <!-- Enhanced Header Section -->
        <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5">
            <div class="card-body px-4 py-4">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h3 class="fw-bold mb-3 text-white">Semua Quiz Anda!!</h3>
                        <p class="text-white-75 mb-3">Kelola dan pantau semua quiz dengan berbagai tipe soal: Pilihan Ganda, Essay, dan Benar/Salah</p>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light">
                                <li class="breadcrumb-item">
                                    <a class="text-white-75 text-decoration-none" href="">
                                        <i class="ti ti-home me-1"></i>Front Pages
                                    </a>
                                </li>
                                <li class="breadcrumb-item active text-white" aria-current="page">Quiz</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center">
                            <img src="{{asset ('assets/backend/img/illustrations/man-with-laptop.png') }}" alt="quiz-dashboard"
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

        <!-- Enhanced Action Section -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body py-3">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;">
                                    <i class="bx bx-list-ol p-3 text-primary"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-1">Daftar Quiz Anda</h5>
                                <p class="text-muted mb-0">
                                    @if ($quizzes->count() > 0)
                                        Menampilkan {{ $quizzes->count() }} quiz dari total koleksi Anda
                                    @else
                                        Belum ada quiz yang dibuat - mulai dengan membuat quiz pertama!
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="{{ route('backend.quiz.create') }}" class="btn btn-primary btn-lg px-4">
                            <i class='bx bx-plus me-2'></i>Buat Quiz Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Quiz Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold">
                        <i class="bx bx-table me-2 text-primary"></i>Tabel Quiz
                    </h5>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary-subtle text-primary px-3 py-2">
                            {{ $quizzes->count() }} Quiz Tersedia
                        </span>
                    </div>
                </div>
            </div>

            @if ($quizzes->count() > 0)
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover quiz-table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3">
                                        <i class="bx bx-file me-1 p-2"></i>Judul
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                        <i class="bx bxs-key me-1 p-2"></i>Kode Quiz
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                        <i class="bx bx-calendar me-1 p-2"></i>Tanggal
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                        <i class="bx bx-list-ol me-1 p-2"></i>Soal
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                        <i class="bx bx-category me-1 p-2"></i>Tipe Soal
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                        <i class="bx bx-time-five me-1 p-2"></i>Durasi
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                        <i class="bx bx-user me-1 p-2"></i>Peserta
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                        <i class="bx bx-check-circle me-1 p-2"></i>Mapel
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3 text-center">
                                        <i class="bx bx-check-circle me-1 p-2"></i>Status
                                    </th>
                                    <th scope="col" class="border-0 fw-bold text-dark py-3 text-center pe-4">
                                        <i class="bx bx-cog me-1"></i>Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quizzes as $index => $quiz)
                                    <tr class="quiz-row" data-quiz-id="{{ $quiz->id }}">
                                        <td class="py-4">
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3">
                                                    <i class="ti text-primary"> {{ $loop->iteration }} </i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 fw-bold text-dark" title="{{ $quiz->judul_quiz }}">
                                                        {{ Str::limit($quiz->judul_quiz, 35) }}
                                                    </h6>
                                                    @if ($quiz->kategori)
                                                        <small
                                                            class="text-muted">{{ $quiz->kategori->nama_kategori }}</small>
                                                    @endif
                                                    <div class="mt-1">
                                                        <small class="text-muted">
                                                            <i class="bx bx-user me-1 p-2"></i>{{ $quiz->user->name }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 text-center">
                                            @if ($quiz->kode_quiz)
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <span class="badge bg-primary-subtle text-primary px-3 py-2 me-2">
                                                        <i class="bx bxs-key me-1 p-2"></i>{{ $quiz->kode_quiz }}
                                                    </span>
                                                    <button class="btn btn-sm btn-outline-secondary copy-quiz-btn"
                                                        data-quiz-code="{{ $quiz->kode_quiz }}" title="Salin Kode Quiz"
                                                        type="button">
                                                        <i class="bx bx-copy text-primary p-2"></i>
                                                    </button>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="py-4 text-center">
                                            <div class="d-flex flex-column align-items-center">
                                                <span
                                                    class="fw-bold text-dark">{{ \Carbon\Carbon::parse($quiz->tanggal_buat)->format('d M Y') }}</span>
                                                <small
                                                    class="text-muted">{{ \Carbon\Carbon::parse($quiz->tanggal_buat)->format('H:i') }}</small>
                                            </div>
                                        </td>
                                        <td class="py-4 text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center me-2"
                                                    style="width: 30px; height: 30px;">
                                                    <i class="bx bx-list-ol text-info" style="font-size: 14px;"></i>
                                                </div>
                                                <span class="fw-bold text-info">{{ $quiz->soals->count() }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 text-center">
                                            <div class="d-flex flex-column align-items-center gap-1">
                                                @php
                                                    $questionTypes = $quiz->soals->groupBy('tipe');
                                                    $multipleChoice = $questionTypes->get('multiple_choice', collect())->count();
                                                    $essay = $questionTypes->get('essay', collect())->count();
                                                    $trueFalse = $questionTypes->get('true_false', collect())->count();
                                                @endphp
                                                
                                                @if($multipleChoice > 0)
                                                    <span class="badge bg-primary-subtle text-primary">
                                                        <i class="bx bx-list-ol me-1"></i>PG: {{ $multipleChoice }}
                                                    </span>
                                                @endif
                                                
                                                @if($essay > 0)
                                                    <span class="badge bg-purple-subtle text-purple">
                                                        <i class="bx bx-edit me-1"></i>Essay: {{ $essay }}
                                                    </span>
                                                @endif
                                                
                                                @if($trueFalse > 0)
                                                    <span class="badge bg-success-subtle text-success">
                                                        <i class="bx bx-check-double me-1"></i>B/S: {{ $trueFalse }}
                                                    </span>
                                                @endif
                                                
                                                @if($quiz->soals->count() == 0)
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-4 text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div class="rounded-circle bg-warning-subtle d-flex align-items-center justify-content-center me-2"
                                                    style="width: 30px; height: 30px;">
                                                    <i class="bx bxs-time-five text-warning" style="font-size: 14px;"></i>
                                                </div>
                                                <span class="fw-bold text-warning">{{ $quiz->waktu_menit }}</span>
                                                <small class="text-muted ms-1">min</small>
                                            </div>
                                        </td>
                                        <td class="py-4 text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center me-2"
                                                    style="width: 30px; height: 30px;">
                                                    <i class="bx bx-user text-success" style="font-size: 14px;"></i>
                                                </div>
                                                <span class="fw-bold text-success">{{ $quiz->hasilUjian->count() }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center me-2"
                                                    style="width: 30px; height: 30px;">
                                                    <i class="bx bxs-bookmarks text-success" style="font-size: 14px;"></i>
                                                </div>
                                                <span class="fw-bold text-success">{{ $quiz->mataPelajaran->nama_mapel }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 text-center">
                                            <span
                                                class="badge bg-{{ $quiz->soals->count() > 0 ? 'success' : 'warning' }}-subtle 
                                                     text-{{ $quiz->soals->count() > 0 ? 'success' : 'warning' }} px-3 py-2">
                                                <i
                                                    class="bx bx-{{ $quiz->soals->count() > 0 ? 'check-circle' : 'time-five' }} me-1"></i>
                                                {{ $quiz->status }}
                                            </span>
                                        </td>
                                        <td class="py-4 text-center pe-4">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('backend.quiz.show', $quiz->id) }}" class="btn btn-info btn-sm"
                                                    title="Lihat Detail">
                                                    <i class="bx bx-show p-2"></i>
                                                </a>
                                                <a href="{{ route('backend.quiz.edit', $quiz->id) }}"
                                                    class="btn btn-warning btn-sm" title="Edit Quiz">
                                                    <i class="bx bxs-edit-alt"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" title="Hapus Quiz"
                                                    onclick="deleteQuiz({{ $quiz->id }}, '{{ $quiz->judul_quiz }}')">
                                                    <i class="bx bxs-trash p-2"></i>
                                                </button>
                                            </div>

                                            <!-- Hidden delete form -->
                                            <form id="delete-form-{{ $quiz->id }}"
                                                action="{{ route('backend.quiz.destroy', $quiz->id) }}" method="POST"
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
            @else
                <!-- Enhanced Empty State -->
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <div class="rounded-circle bg-primary-subtle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 100px; height: 100px;">
                            <i class="ti ti-file-text text-primary" style="font-size: 48px;"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-dark mb-3">Belum Ada Quiz</h3>
                    <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">
                        Mulai perjalanan pembelajaran Anda dengan membuat quiz pertama.
                        Buat pertanyaan menarik dengan berbagai tipe soal dan ukur pemahaman peserta dengan mudah!
                    </p>
                    <a href="{{ route('backend.quiz.create') }}" class="btn btn-primary btn-lg px-5">
                        <i class="bx bx-plus me-2"></i>Buat Quiz Pertama
                    </a>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if ($quizzes instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            {{ $quizzes->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Enhanced Toast Messages -->
    @if (session('success'))
        <div class="position-fixed top-0 end-0 p-4" style="z-index: 1050;">
            <div class="toast show border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-success text-white border-0">
                    <div class="rounded-circle bg-white d-flex align-items-center justify-content-center me-2"
                        style="width: 20px; height: 20px;">
                        <i class="ti ti-check text-success" style="font-size: 12px;"></i>
                    </div>
                    <strong class="me-auto">Berhasil</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body bg-white">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="position-fixed top-0 end-0 p-4" style="z-index: 1050;">
            <div class="toast show border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger text-white border-0">
                    <div class="rounded-circle bg-white d-flex align-items-center justify-content-center me-2"
                        style="width: 20px; height: 20px;">
                        <i class="bx bx-x-circle text-danger" style="font-size: 12px;"></i>
                    </div>
                    <strong class="me-auto">Error</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body bg-white">
                    {{ session('error') }}
                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const copyButtons = document.querySelectorAll('.copy-quiz-btn');

            copyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const quizCode = this.getAttribute('data-quiz-code');

                    // Buat elemen sementara
                    const tempInput = document.createElement('input');
                    tempInput.value = quizCode;
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    tempInput.setSelectionRange(0, 99999); // Untuk mobile
                    document.execCommand('copy');
                    document.body.removeChild(tempInput);

                    // Show feedback
                    const originalIcon = this.innerHTML;
                    this.innerHTML = '<i class="bx bx-check text-success p-2"></i>';
                    setTimeout(() => {
                        this.innerHTML = originalIcon;
                    }, 2000);
                });
            });
        });

        // Delete confirmation function
        function deleteQuiz(quizId, quizTitle) {
            if (confirm(`Apakah Anda yakin ingin menghapus quiz "${quizTitle}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
                document.getElementById('delete-form-' + quizId).submit();
            }
        }
    </script>

    <style>
        .bg-purple-subtle {
            background-color: #f3e5f5;
        }
        
        .text-purple {
            color: #7b1fa2;
        }
        
        .badge {
            font-size: 0.75rem;
        }
        
        .question-type-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 500;
            border-radius: 0.25rem;
        }
    </style>

    @include('layouts.component-backend.css')
@endsection