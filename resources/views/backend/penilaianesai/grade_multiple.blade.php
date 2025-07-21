@extends('layouts.backend')
@section('content')
    @include('layouts.components-backend.css')
    <div class="container-fluid">
        <!-- Enhanced Header Section -->
        <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5">
            <div class="card-body px-4 py-4">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h3 class="fw-bold mb-3 text-white">Nilai Jawaban Esai</h3>
                        <p class="text-white-75 mb-3">Berikan penilaian dan feedback untuk jawaban esai peserta.</p>
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
                                    Form Penilaian
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center">
                            <img src="{{ asset('assets/backend/images/breadcrumb/ChatBc.png') }}" alt="grade-essay"
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

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h6><i class="ti ti-alert-triangle me-2"></i>Terdapat kesalahan:</h6>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @php
            // Get all pending essays from the same user
            $user = $essayDetail->hasilUjian->user;
            $userId = $user->id;
            
            // Find all pending essays from this user for quizzes created by current admin
            $userEssays = App\Models\HasilUjianDetail::with(['hasilUjian.user', 'hasilUjian.quiz', 'soal'])
                ->whereHas('soal', function($query) {
                    $query->where('tipe', 'essay');
                })
                ->whereHas('hasilUjian.quiz', function($query) {
                    $query->where('user_id', Auth::id());
                })
                ->whereHas('hasilUjian', function($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->where('status_jawaban', 'pending')
                ->orderBy('created_at', 'desc')
                ->get();
        @endphp

        <!-- User Info -->
        <div class="card info-card mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="user-avatar me-3">
                            <i class="ti ti-user"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1 fw-bold">{{ $user->name }}</h5>
                            <p class="text-muted mb-0">{{ $user->email }}</p>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-warning me-2">{{ $userEssays->count() }} Esai Pending</span>
                        <a href="{{ route('quiz.essay.grading') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Multiple Grading Form -->
        <form action="{{ route('quiz.essay.grade-multiple') }}" method="POST" id="multipleGradeForm">
            @csrf
            
            @foreach($userEssays as $index => $essay)
                <div class="card essay-card mb-4" data-essay-index="{{ $index }}">
                    <div class="card-body">
                        <!-- Essay Header -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="card-title mb-0">
                                <i class="ti ti-file-text me-2"></i>Esai #{{ $index + 1 }}
                            </h6>
                            <div class="d-flex gap-2">
                                <span class="badge bg-primary">{{ $essay->bobot_soal }} poin</span>
                                <span class="badge bg-secondary">{{ $essay->hasilUjian->quiz->kode_quiz }}</span>
                            </div>
                        </div>

                        <!-- Hidden Fields -->
                        <input type="hidden" name="grades[{{ $index }}][detail_id]" value="{{ $essay->id }}">

                        <!-- Quiz Info -->
                        <div class="quiz-info mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">Quiz:</small>
                                    <div class="fw-semibold">{{ $essay->hasilUjian->quiz->judul_quiz }}</div>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Tanggal:</small>
                                    <div>{{ Carbon\Carbon::parse($essay->hasilUjian->tanggal_ujian)->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Question -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pertanyaan:</label>
                            <div class="question-box">
                                {{ $essay->soal->pertanyaan }}
                            </div>
                            
                            @if($essay->soal->jawaban_benar)
                                <div class="answer-key mt-2">
                                    <small class="text-success fw-semibold">
                                        <i class="ti ti-key me-1"></i>Kunci Jawaban:
                                    </small>
                                    <div class="key-content">
                                        {{ $essay->soal->jawaban_benar }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Student Answer -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jawaban Peserta:</label>
                            @if($essay->jawaban_peserta)
                                <div class="answer-box-tight">
                                    {{ $essay->jawaban_peserta }}
                                </div>
                            @else
                                <div class="no-answer">
                                    <i class="ti ti-alert-triangle"></i>
                                    <span>Peserta tidak memberikan jawaban</span>
                                </div>
                            @endif
                        </div>

                        <!-- Quick Score Buttons -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih Nilai Cepat:</label>
                            <div class="quick-score-buttons">
                                <button type="button" class="btn btn-outline-danger quick-score" 
                                        data-percentage="0" data-index="{{ $index }}">
                                    0% - Salah
                                </button>
                                <button type="button" class="btn btn-outline-warning quick-score" 
                                        data-percentage="25" data-index="{{ $index }}">
                                    25% - Kurang
                                </button>
                                <button type="button" class="btn btn-outline-info quick-score" 
                                        data-percentage="50" data-index="{{ $index }}">
                                    50% - Cukup
                                </button>
                                <button type="button" class="btn btn-outline-primary quick-score" 
                                        data-percentage="75" data-index="{{ $index }}">
                                    75% - Baik
                                </button>
                                <button type="button" class="btn btn-outline-success quick-score" 
                                        data-percentage="100" data-index="{{ $index }}">
                                    100% - Sempurna
                                </button>
                            </div>
                        </div>

                        <!-- Score Input -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Poin Diperoleh <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" 
                                           class="form-control bobot-input" 
                                           name="grades[{{ $index }}][bobot_diperoleh]" 
                                           min="0" 
                                           max="{{ $essay->bobot_soal }}" 
                                           step="0.1"
                                           data-max="{{ $essay->bobot_soal }}"
                                           data-index="{{ $index }}"
                                           required>
                                    <span class="input-group-text">/ {{ $essay->bobot_soal }}</span>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select status-select" 
                                        name="grades[{{ $index }}][status_jawaban]" 
                                        data-index="{{ $index }}"
                                        required>
                                    <option value="">Pilih Status</option>
                                    <option value="benar">Benar</option>
                                    <option value="sebagian">Sebagian Benar</option>
                                    <option value="salah">Salah</option>
                                </select>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label">Persentase</label>
                                <div class="input-group">
                                    <input type="text" 
                                           class="form-control percentage-display" 
                                           readonly 
                                           placeholder="0">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Feedback -->
                        <div class="mb-3">
                            <label class="form-label">Feedback untuk Peserta</label>
                            <textarea class="form-control" 
                                      name="grades[{{ $index }}][feedback]" 
                                      rows="3" 
                                      placeholder="Berikan feedback untuk membantu peserta..."></textarea>
                        </div>

                        <!-- Completion Status -->
                        <div class="completion-status text-center" style="display: none;">
                            <i class="ti ti-check-circle text-success me-2"></i>
                            <span class="text-success">Esai telah dinilai</span>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Summary & Submit -->
            <div class="card summary-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-2">
                                <i class="ti ti-calculator me-2"></i>Ringkasan Penilaian
                            </h6>
                            <div class="progress-info">
                                <span class="text-muted">Progress: </span>
                                <span class="completed-count fw-bold">0</span> / 
                                <span class="total-count">{{ $userEssays->count() }}</span> esai dinilai
                            </div>
                            <div class="progress mt-2" style="height: 8px;">
                                <div class="progress-bar" style="width: 0%;"></div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="total-score-info">
                                <small class="text-muted">Total Skor:</small>
                                <div class="h5 mb-0">
                                    <span class="total-obtained">0</span> / 
                                    <span class="total-possible">{{ $userEssays->sum('bobot_soal') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                <i class="ti ti-info-circle me-1"></i>
                                Semua esai harus dinilai sebelum dapat disimpan
                            </small>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-warning" id="autoGradeBtn">
                                <i class="ti ti-magic me-2"></i>Nilai Otomatis
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                                <i class="ti ti-device-floppy me-2"></i>Simpan Semua Penilaian
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <style>
        /* Enhanced gradient and styling to match the original design */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        .breadcrumb-light .breadcrumb-item + .breadcrumb-item::before {
            color: rgba(255,255,255,0.7);
        }

        .text-white-75 {
            color: rgba(255,255,255,0.75) !important;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            background: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 24px;
        }

        .info-card,
        .essay-card,
        .summary-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .essay-card {
            position: relative;
        }

        .essay-card.completed {
            border-color: #28a745;
            background: linear-gradient(135deg, #f8fff9 0%, #f0fff4 100%);
        }

        .essay-card.completed::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: #28a745;
            border-radius: 8px 8px 0 0;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #495057;
        }

        .quiz-info {
            background: #f8f9fa;
            border-radius: 6px;
            padding: 0.75rem;
        }

        .question-box {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 1rem;
            font-size: 15px;
            line-height: 1.6;
        }

        .answer-key {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 6px;
            padding: 0.75rem;
        }

        .key-content {
            font-size: 14px;
            color: #155724;
            margin-top: 0.25rem;
        }

        .answer-box-tight {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 0.75rem;
    min-height: 60px;
    white-space: pre-line; /* Changed from pre-wrap to pre-line */
    font-family: inherit;
    font-size: 14px;
    line-height: 1.3;
    word-wrap: break-word;
    overflow-wrap: break-word;
    margin: 0;
}

        

        .no-answer {
            text-align: center;
            padding: 1.5rem;
            color: #6c757d;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
        }

        .quick-score-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .quick-score {
            border-width: 2px;
            transition: all 0.3s ease;
        }

        .quick-score:hover {
            transform: translateY(-1px);
        }

        .quick-score.active {
            transform: scale(1.05);
        }

        .completion-status {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.95);
            padding: 1rem;
            border-radius: 8px;
            border: 2px solid #28a745;
        }

        .progress {
            border-radius: 4px;
        }

        .progress-bar {
            transition: width 0.3s ease;
        }

        .total-score-info {
            text-align: center;
            padding: 0.5rem;
            background: #f8f9fa;
            border-radius: 6px;
        }

        .breadcrumb-item a {
            text-decoration: none;
            color: #6c757d;
        }

        .breadcrumb-item.active {
            color: #495057;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .quick-score-buttons {
                flex-direction: column;
            }

            .quick-score {
                width: 100%;
                margin-bottom: 0.25rem;
            }

            .row .col-md-4 {
                margin-bottom: 1rem;
            }

            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('multipleGradeForm');
        const submitBtn = document.getElementById('submitBtn');
        const autoGradeBtn = document.getElementById('autoGradeBtn');
        const totalEssays = {{ $userEssays->count() }};
        let completedEssays = 0;

        // Quick score button handlers
        document.querySelectorAll('.quick-score').forEach(btn => {
            btn.addEventListener('click', function() {
                const percentage = parseInt(this.dataset.percentage);
                const index = this.dataset.index;
                
                // Remove active class from siblings
                this.parentNode.querySelectorAll('.quick-score').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                setEssayScore(index, percentage);
            });
        });

        // Auto grade button
        autoGradeBtn.addEventListener('click', function() {
            if (confirm('Penilaian otomatis akan memberikan nilai berdasarkan panjang jawaban. Lanjutkan?')) {
                autoGradeAllEssays();
            }
        });

        // Input change handlers
        document.querySelectorAll('.bobot-input').forEach(input => {
            input.addEventListener('input', function() {
                const index = this.dataset.index;
                updateEssayFromInput(index);
            });
        });

        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function() {
                const index = this.dataset.index;
                updateEssayFromInput(index);
            });
        });

        function setEssayScore(index, percentage) {
            const essayCard = document.querySelector(`[data-essay-index="${index}"]`);
            const bobotInput = essayCard.querySelector('.bobot-input');
            const statusSelect = essayCard.querySelector('.status-select');
            const percentageDisplay = essayCard.querySelector('.percentage-display');
            
            const maxBobot = parseFloat(bobotInput.dataset.max);
            const bobot = (percentage / 100) * maxBobot;
            
            bobotInput.value = bobot.toFixed(1);
            percentageDisplay.value = percentage;
            
            // Set status
            if (percentage === 0) {
                statusSelect.value = 'salah';
            } else if (percentage === 100) {
                statusSelect.value = 'benar';
            } else {
                statusSelect.value = 'sebagian';
            }
            
            markEssayCompleted(index);
            updateSummary();
        }

        function updateEssayFromInput(index) {
            const essayCard = document.querySelector(`[data-essay-index="${index}"]`);
            const bobotInput = essayCard.querySelector('.bobot-input');
            const statusSelect = essayCard.querySelector('.status-select');
            const percentageDisplay = essayCard.querySelector('.percentage-display');
            
            const maxBobot = parseFloat(bobotInput.dataset.max);
            const currentBobot = parseFloat(bobotInput.value) || 0;
            const percentage = maxBobot > 0 ? Math.round((currentBobot / maxBobot) * 100) : 0;
            
            percentageDisplay.value = percentage;
            
            if (bobotInput.value && statusSelect.value) {
                markEssayCompleted(index);
            } else {
                markEssayIncomplete(index);
            }
            
            updateSummary();
        }

        function markEssayCompleted(index) {
            const essayCard = document.querySelector(`[data-essay-index="${index}"]`);
            if (!essayCard.classList.contains('completed')) {
                essayCard.classList.add('completed');
                essayCard.querySelector('.completion-status').style.display = 'block';
                
                setTimeout(() => {
                    essayCard.querySelector('.completion-status').style.display = 'none';
                }, 2000);
            }
        }

        function markEssayIncomplete(index) {
            const essayCard = document.querySelector(`[data-essay-index="${index}"]`);
            essayCard.classList.remove('completed');
            essayCard.querySelector('.completion-status').style.display = 'none';
        }

        function updateSummary() {
            completedEssays = document.querySelectorAll('.essay-card.completed').length;
            const progressPercent = (completedEssays / totalEssays) * 100;
            
            // Update counts
            document.querySelector('.completed-count').textContent = completedEssays;
            document.querySelector('.progress-bar').style.width = progressPercent + '%';
            
            // Calculate total scores
            let totalObtained = 0;
            document.querySelectorAll('.bobot-input').forEach(input => {
                const value = parseFloat(input.value) || 0;
                totalObtained += value;
            });
            
            document.querySelector('.total-obtained').textContent = totalObtained.toFixed(1);
            
            // Enable/disable submit button
            submitBtn.disabled = completedEssays < totalEssays;
            
            if (completedEssays === totalEssays) {
                submitBtn.classList.remove('btn-outline-primary');
                submitBtn.classList.add('btn-primary');
            } else {
                submitBtn.classList.add('btn-outline-primary');
                submitBtn.classList.remove('btn-primary');
            }
        }

        function autoGradeAllEssays() {
            document.querySelectorAll('.essay-card').forEach((card, index) => {
                const answerBox = card.querySelector('.answer-box-tight');
                const noAnswer = card.querySelector('.no-answer');
                
                let percentage = 0;
                
                if (answerBox) {
                    const answerText = answerBox.textContent.trim();
                    if (answerText.length < 50) {
                        percentage = 25; // Short answer
                    } else if (answerText.length < 150) {
                        percentage = 50; // Medium answer
                    } else {
                        percentage = 75; // Long answer
                    }
                } else if (noAnswer) {
                    percentage = 0; // No answer
                }
                
                setEssayScore(index, percentage);
                
                // Activate corresponding quick score button
                const quickScoreBtn = card.querySelector(`[data-percentage="${percentage}"]`);
                if (quickScoreBtn) {
                    card.querySelectorAll('.quick-score').forEach(b => b.classList.remove('active'));
                    quickScoreBtn.classList.add('active');
                }
            });
        }

        // Form validation
        form.addEventListener('submit', function(e) {
            if (completedEssays < totalEssays) {
                e.preventDefault();
                alert('Harap selesaikan penilaian semua esai terlebih dahulu!');
            }
        });

        // Initial summary update
        updateSummary();
    });
    </script>
@endsection