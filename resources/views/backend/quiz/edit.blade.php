@extends('layouts.backend')
@section('content')
    @include('layouts.components-backend.css')
    <div class="container-fluid">

        <div class="card bg-gradient-primary shadow-sm position-relative overflow-hidden mb-5 border-0">
            <div class="card-body px-4 py-4">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h3 class="fw-bold mb-3 text-white">Edit Quiz</h3>
                        <p class="text-white-75 mb-3">Perbarui dan kelola quiz anda dengan mudah</p>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light">
                                <li class="breadcrumb-item">
                                    <a class="text-white-75 text-decoration-none" href="">
                                        <i class="ti ti-home me-1"></i>Kelola
                                    </a>
                                </li>
                                <li class="breadcrumb-item active text-white-75" aria-current="page">Quiz</li>
                                <li class="breadcrumb-item active text-white" aria-current="page">Edit</li>
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

        <!-- Quiz Edit Form -->
        <form id="quiz-edit-form" action="{{ route('quiz.update', $quiz->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Quiz Basic Information -->
            <div class="card border-0 mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informasi Quiz</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="judul-quiz" class="form-label">Judul Quiz<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('judul_quiz') is-invalid @enderror"
                                    id="judul-quiz" name="judul_quiz" value="{{ old('judul_quiz', $quiz->judul_quiz) }}"
                                    required>
                                @error('judul_quiz')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="waktu-menit" class="form-label">Durasi (menit) <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('waktu_menit') is-invalid @enderror"
                                    id="waktu-menit" name="waktu_menit" min="1" max="300"
                                    value="{{ old('waktu_menit', $quiz->waktu_menit) }}" required>
                                @error('waktu_menit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="categories" class="form-label">Kategori <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('categories') is-invalid @enderror" id="categories"
                                    name="categories" required>
                                    <option value="" disabled>Pilih Kategori Quiz</option>
                                    @foreach ($categories as $items)
                                        <option value="{{ $items->id }}"
                                            {{ old('categories', $quiz->kategori_id) == $items->id ? 'selected' : '' }}>
                                            {{ $items->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                @error('categories')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="mapel" class="form-label">Mata Pelajaran <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('mapel') is-invalid @enderror" id="mapel"
                                    name="mapel" required>
                                    <option value="" disabled>Pilih Mata Pelajaran Quiz</option>
                                    @foreach ($mataPelajaran as $items)
                                        <option value="{{ $items->id }}"
                                            {{ old('mapel', $quiz->mata_pelajaran_id) == $items->id ? 'selected' : '' }}>
                                            {{ $items->nama_mapel }}</option>
                                    @endforeach
                                </select>
                                @error('mapel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="" disabled>Pilih Status</option>
                                    <option value="Privat"
                                        {{ old('status', $quiz->status) == 'Privat' ? 'selected' : '' }}>Privat</option>
                                    <option value="Umum" {{ old('status', $quiz->status) == 'Umum' ? 'selected' : '' }}>
                                        Umum</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Quiz</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi"
                                rows="4" placeholder="Tambahkan keterangan atau instruksi untuk quiz...">{{ old('deskripsi', $quiz->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Questions Section -->
            <div class="card border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Soal Quiz</h5>
                    <button type="button" class="btn btn-primary btn-sm" id="add-question">
                        <i class="ti ti-plus me-1"></i>Tambah Soal
                    </button>
                </div>
                <div class="card-body">
                    <div id="questions-container">
                        @foreach ($quiz->soals as $index => $soal)
                            <div class="question-item card mb-4" data-question-index="{{ $index }}" data-question-type="{{ $soal->tipe }}">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="card-title mb-0">Soal {{ $index + 1 }} 
                                        <span class="badge bg-{{ $soal->tipe == 'pilihan_ganda' ? 'primary' : ($soal->tipe == 'benar_salah' ? 'success' : 'warning') }}">
                                            {{ $soal->tipe == 'pilihan_ganda' ? 'Pilihan Ganda' : ($soal->tipe == 'benar_salah' ? 'Benar/Salah' : 'Essay') }}
                                        </span>
                                    </h6>
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-question">
                                        <i class="ti ti-trash me-1"></i>Hapus
                                    </button>
                                </div>
                                <div class="card-body">
                                    <!-- Hidden field for existing question ID -->
                                    <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $soal->id }}">

                                    <div class="mb-3">
                                        <label for="question-{{ $index }}" class="form-label">Teks Soal <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control @error('questions.' . $index . '.text') is-invalid @enderror"
                                            id="question-{{ $index }}" name="questions[{{ $index }}][text]" rows="3" required
                                            placeholder="Masukkan soal di sini...">{{ old('questions.' . $index . '.text', $soal->pertanyaan) }}</textarea>
                                        @error('questions.' . $index . '.text')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="question-type-{{ $index }}" class="form-label">Tipe Soal <span class="text-danger">*</span></label>
                                                <select class="form-select question-type-select" id="question-type-{{ $index }}" 
                                                        name="questions[{{ $index }}][type]" required data-question-index="{{ $index }}">
                                                    <option value="">Pilih Tipe Soal</option>
                                                    <option value="pilihan_ganda" {{ $soal->tipe == 'pilihan_ganda' ? 'selected' : '' }}>Pilihan Ganda</option>
                                                    <option value="benar_salah" {{ $soal->tipe == 'benar_salah' ? 'selected' : '' }}>Benar/Salah</option>
                                                    <option value="essay" {{ $soal->tipe == 'essay' ? 'selected' : '' }}>Essay</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="weight-{{ $index }}" class="form-label">Bobot Soal</label>
                                                <input type="number" class="form-control" id="weight-{{ $index }}" 
                                                    name="questions[{{ $index }}][weight]" min="1" max="100" 
                                                    value="{{ old('questions.' . $index . '.weight', $soal->bobot ?? 10) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dynamic Options Container -->
                                    <div id="question-options-{{ $index }}">
                                        <!-- Options berdasarkan tipe soal yang sudah ada -->
                                        @if($soal->tipe === 'pilihan_ganda')
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="option-a-{{ $index }}" class="form-label">Pilihan A <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control @error('questions.' . $index . '.option_a') is-invalid @enderror"
                                                            id="option-a-{{ $index }}" name="questions[{{ $index }}][option_a]"
                                                            value="{{ old('questions.' . $index . '.option_a', $soal->pilihan_a) }}"
                                                            required placeholder="Masukkan pilihan A">
                                                        @error('questions.' . $index . '.option_a')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="option-b-{{ $index }}" class="form-label">Pilihan B <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control @error('questions.' . $index . '.option_b') is-invalid @enderror"
                                                            id="option-b-{{ $index }}" name="questions[{{ $index }}][option_b]"
                                                            value="{{ old('questions.' . $index . '.option_b', $soal->pilihan_b) }}"
                                                            required placeholder="Masukkan pilihan B">
                                                        @error('questions.' . $index . '.option_b')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="option-c-{{ $index }}" class="form-label">Pilihan C <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control @error('questions.' . $index . '.option_c') is-invalid @enderror"
                                                            id="option-c-{{ $index }}" name="questions[{{ $index }}][option_c]"
                                                            value="{{ old('questions.' . $index . '.option_c', $soal->pilihan_c) }}"
                                                            required placeholder="Masukkan pilihan C">
                                                        @error('questions.' . $index . '.option_c')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="option-d-{{ $index }}" class="form-label">Pilihan D <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control @error('questions.' . $index . '.option_d') is-invalid @enderror"
                                                            id="option-d-{{ $index }}" name="questions[{{ $index }}][option_d]"
                                                            value="{{ old('questions.' . $index . '.option_d', $soal->pilihan_d) }}"
                                                            required placeholder="Masukkan pilihan D">
                                                        @error('questions.' . $index . '.option_d')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jawaban Benar <span class="text-danger">*</span></label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="questions[{{ $index }}][correct_answer]"
                                                            id="correct-a-{{ $index }}" value="A"
                                                            {{ old('questions.' . $index . '.correct_answer', $soal->jawaban_benar) == 'A' ? 'checked' : '' }}
                                                            required>
                                                        <label class="form-check-label" for="correct-a-{{ $index }}">A</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="questions[{{ $index }}][correct_answer]"
                                                            id="correct-b-{{ $index }}" value="B"
                                                            {{ old('questions.' . $index . '.correct_answer', $soal->jawaban_benar) == 'B' ? 'checked' : '' }}
                                                            required>
                                                        <label class="form-check-label" for="correct-b-{{ $index }}">B</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="questions[{{ $index }}][correct_answer]"
                                                            id="correct-c-{{ $index }}" value="C"
                                                            {{ old('questions.' . $index . '.correct_answer', $soal->jawaban_benar) == 'C' ? 'checked' : '' }}
                                                            required>
                                                        <label class="form-check-label" for="correct-c-{{ $index }}">C</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="questions[{{ $index }}][correct_answer]"
                                                            id="correct-d-{{ $index }}" value="D"
                                                            {{ old('questions.' . $index . '.correct_answer', $soal->jawaban_benar) == 'D' ? 'checked' : '' }}
                                                            required>
                                                        <label class="form-check-label" for="correct-d-{{ $index }}">D</label>
                                                    </div>
                                                </div>
                                                @error('questions.' . $index . '.correct_answer')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        @elseif($soal->tipe === 'benar_salah')
                                            <div class="mb-3">
                                                <label class="form-label">Jawaban Benar <span class="text-danger">*</span></label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="questions[{{ $index }}][correct_answer]"
                                                            id="correct-benar-{{ $index }}" value="Benar"
                                                            {{ old('questions.' . $index . '.correct_answer', $soal->jawaban_benar) == 'Benar' ? 'checked' : '' }}
                                                            required>
                                                        <label class="form-check-label" for="correct-benar-{{ $index }}">Benar</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="questions[{{ $index }}][correct_answer]"
                                                            id="correct-salah-{{ $index }}" value="Salah"
                                                            {{ old('questions.' . $index . '.correct_answer', $soal->jawaban_benar) == 'Salah' ? 'checked' : '' }}
                                                            required>
                                                        <label class="form-check-label" for="correct-salah-{{ $index }}">Salah</label>
                                                    </div>
                                                </div>
                                                @error('questions.' . $index . '.correct_answer')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        @elseif($soal->tipe === 'essay')
                                            <div class="mb-3">
                                                <label for="essay-answer-{{ $index }}" class="form-label">Jawaban Model / Rubrik Penilaian <small class="text-muted">(Opsional)</small></label>
                                                <textarea class="form-control" id="essay-answer-{{ $index }}"
                                                    name="questions[{{ $index }}][correct_answer]" rows="4"
                                                    placeholder="Masukkan jawaban model atau rubrik penilaian...">{{ old('questions.' . $index . '.correct_answer', $soal->jawaban_benar) }}</textarea>
                                                <small class="text-muted">Jawaban model akan digunakan sebagai referensi untuk penilaian manual oleh guru</small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('quiz.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="ti ti-device-floppy me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let questionIndex = {{ count($quiz->soals) }};

            // Add event listener for question type changes using event delegation
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('question-type-select')) {
                    const questionIndex = e.target.getAttribute('data-question-index');
                    const selectedType = e.target.value;
                    handleQuestionTypeChange(questionIndex, selectedType);
                }
            });

            // Add new question
            document.getElementById('add-question').addEventListener('click', function() {
                const questionsContainer = document.getElementById('questions-container');
                const newQuestion = createQuestionForm(questionIndex);
                questionsContainer.appendChild(newQuestion);
                questionIndex++;
                updateQuestionNumbers();
            });

            // Remove question functionality
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-question') || e.target.closest('.remove-question')) {
                    const questionItem = e.target.closest('.question-item');
                    const questionsContainer = document.getElementById('questions-container');

                    // Don't allow removing if it's the last question
                    if (questionsContainer.children.length <= 1) {
                        alert('Quiz harus memiliki minimal satu soal.');
                        return;
                    }

                    if (confirm('Apakah Anda yakin ingin menghapus soal ini?')) {
                        questionItem.remove();
                        updateQuestionNumbers();
                        updateQuestionIndexes();
                    }
                }
            });

            // Create new question form
            function createQuestionForm(index) {
                const questionDiv = document.createElement('div');
                questionDiv.className = 'question-item card mb-4';
                questionDiv.setAttribute('data-question-index', index);

                questionDiv.innerHTML = `
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">Soal ${index + 1} <span class="badge bg-secondary" id="type-badge-${index}">Pilih Tipe</span></h6>
                    <button type="button" class="btn btn-outline-danger btn-sm remove-question">
                        <i class="ti ti-trash me-1"></i>Hapus
                    </button>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="question-${index}" class="form-label">Teks Soal <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="question-${index}" name="questions[${index}][text]" rows="3" required placeholder="Masukkan soal di sini..."></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="question-type-${index}" class="form-label">Tipe Soal <span class="text-danger">*</span></label>
                                <select class="form-select question-type-select" id="question-type-${index}" name="questions[${index}][type]" required data-question-index="${index}">
                                    <option value="">Pilih Tipe Soal</option>
                                    <option value="pilihan_ganda">Pilihan Ganda</option>
                                    <option value="benar_salah">Benar/Salah</option>
                                    <option value="essay">Essay</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="weight-${index}" class="form-label">Bobot Soal</label>
                                <input type="number" class="form-control" id="weight-${index}" name="questions[${index}][weight]" min="1" max="100" value="10" placeholder="1-100">
                            </div>
                        </div>
                    </div>
                    
                    <div id="question-options-${index}">
                        <div class="alert alert-info">
                            <i class="ti ti-info-circle me-2"></i>
                            Silakan pilih tipe soal untuk menampilkan opsi jawaban
                        </div>
                    </div>
                </div>
            `;

                return questionDiv;
            }

            // Handle question type change for both existing and new questions
            function handleQuestionTypeChange(index, selectedType) {
                const optionsContainer = document.getElementById(`question-options-${index}`);
                const typeBadge = document.getElementById(`type-badge-${index}`);
                const questionItem = document.querySelector(`[data-question-index="${index}"]`);

                // Update badge and question type attribute
                if (selectedType) {
                    questionItem.setAttribute('data-question-type', selectedType);
                    
                    const typeNames = {
                        'pilihan_ganda': 'Pilihan Ganda',
                        'benar_salah': 'Benar/Salah',
                        'essay': 'Essay'
                    };
                    
                    const typeColors = {
                        'pilihan_ganda': 'bg-primary',
                        'benar_salah': 'bg-success',
                        'essay': 'bg-warning'
                    };
                    
                    if (typeBadge) {
                        typeBadge.textContent = typeNames[selectedType];
                        typeBadge.className = `badge ${typeColors[selectedType]}`;
                    }
                } else {
                    if (typeBadge) {
                        typeBadge.textContent = 'Pilih Tipe';
                        typeBadge.className = 'badge bg-secondary';
                    }
                }

                // Clear previous options
                optionsContainer.innerHTML = '';

                // Generate options based on type
                switch (selectedType) {
                    case 'pilihan_ganda':
                        optionsContainer.innerHTML = createMultipleChoiceOptions(index);
                        break;
                    case 'benar_salah':
                        optionsContainer.innerHTML = createTrueFalseOptions(index);
                        break;
                    case 'essay':
                        optionsContainer.innerHTML = createEssayOptions(index);
                        break;
                    default:
                        optionsContainer.innerHTML = `
                            <div class="alert alert-info">
                                <i class="ti ti-info-circle me-2"></i>
                                Silakan pilih tipe soal untuk menampilkan opsi jawaban
                            </div>
                        `;
                        break;
                }
            }

            // Create multiple choice options
            function createMultipleChoiceOptions(index) {
                return `
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="option-a-${index}" class="form-label">Pilihan A <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="option-a-${index}" name="questions[${index}][option_a]" required placeholder="Masukkan pilihan A">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="option-b-${index}" class="form-label">Pilihan B <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="option-b-${index}" name="questions[${index}][option_b]" required placeholder="Masukkan pilihan B">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="option-c-${index}" class="form-label">Pilihan C <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="option-c-${index}" name="questions[${index}][option_c]" required placeholder="Masukkan pilihan C">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="option-d-${index}" class="form-label">Pilihan D <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="option-d-${index}" name="questions[${index}][option_d]" required placeholder="Masukkan pilihan D">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jawaban Benar <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="questions[${index}][correct_answer]" id="correct-a-${index}" value="A" required>
                                <label class="form-check-label" for="correct-a-${index}">A</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="questions[${index}][correct_answer]" id="correct-b-${index}" value="B" required>
                                <label class="form-check-label" for="correct-b-${index}">B</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="questions[${index}][correct_answer]" id="correct-c-${index}" value="C" required>
                                <label class="form-check-label" for="correct-c-${index}">C</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="questions[${index}][correct_answer]" id="correct-d-${index}" value="D" required>
                                <label class="form-check-label" for="correct-d-${index}">D</label>
                            </div>
                        </div>
                    </div>
                `;
            }

            // Create true/false options
            function createTrueFalseOptions(index) {
                return `
                    <div class="mb-3">
                        <label class="form-label">Jawaban Benar <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="questions[${index}][correct_answer]" id="correct-benar-${index}" value="Benar" required>
                                <label class="form-check-label" for="correct-benar-${index}">Benar</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="questions[${index}][correct_answer]" id="correct-salah-${index}" value="Salah" required>
                                <label class="form-check-label" for="correct-salah-${index}">Salah</label>
                            </div>
                        </div>
                    </div>
                `;
            }

            // Create essay options
            function createEssayOptions(index) {
                return `
                    <div class="mb-3">
                        <label for="essay-answer-${index}" class="form-label">Jawaban Model / Rubrik Penilaian <small class="text-muted">(Opsional)</small></label>
                        <textarea class="form-control" id="essay-answer-${index}" name="questions[${index}][correct_answer]" rows="4" placeholder="Masukkan jawaban model atau rubrik penilaian..."></textarea>
                        <small class="text-muted">Jawaban model akan digunakan sebagai referensi untuk penilaian manual oleh guru</small>
                    </div>
                `;
            }

            // Update question numbers after add/remove
            function updateQuestionNumbers() {
                const questionItems = document.querySelectorAll('.question-item');
                questionItems.forEach((item, index) => {
                    const titleElement = item.querySelector('.card-title');
                    const badgeElement = titleElement.querySelector('.badge');
                    const badgeText = badgeElement ? badgeElement.textContent : 'Pilih Tipe';
                    const badgeClass = badgeElement ? badgeElement.className : 'badge bg-secondary';
                    titleElement.innerHTML = `Soal ${index + 1} <span class="${badgeClass}" id="type-badge-${index}">${badgeText}</span>`;
                    item.setAttribute('data-question-index', index);
                });
            }

            // Update question name attributes to maintain proper indexing
            function updateQuestionIndexes() {
                const questionItems = document.querySelectorAll('.question-item');
                questionItems.forEach((item, index) => {
                    // Update all input names and ids for consistency
                    const inputs = item.querySelectorAll('input, textarea, select');
                    inputs.forEach(input => {
                        if (input.name) {
                            input.name = input.name.replace(/questions\[\d+\]/, `questions[${index}]`);
                        }
                        if (input.id) {
                            input.id = input.id.replace(/-\d+$/, `-${index}`);
                        }
                        if (input.hasAttribute('data-question-index')) {
                            input.setAttribute('data-question-index', index);
                        }
                    });

                    // Update labels for attributes
                    const labels = item.querySelectorAll('label');
                    labels.forEach(label => {
                        if (label.getAttribute('for')) {
                            label.setAttribute('for', label.getAttribute('for').replace(/-\d+$/, `-${index}`));
                        }
                    });

                    // Update the options container id
                    const optionsContainer = item.querySelector('[id^="question-options-"]');
                    if (optionsContainer) {
                        optionsContainer.id = `question-options-${index}`;
                    }
                });
            }

            // Form validation before submission - Support untuk semua tipe soal
            document.getElementById('quiz-edit-form').addEventListener('submit', function(e) {
                const questions = document.querySelectorAll('[name*="[text]"]');
                let isValid = true;
                let errorMessage = '';

                // Check if there's at least one question
                if (questions.length === 0) {
                    isValid = false;
                    errorMessage = 'Quiz harus memiliki minimal satu soal.';
                }

                // Check if all questions have text and type
                if (isValid) {
                    questions.forEach((question, index) => {
                        if (!question.value.trim()) {
                            isValid = false;
                            errorMessage = `Harap isi teks untuk Soal ${index + 1}.`;
                            return;
                        }

                        // Get question type from the select element
                        const typeSelect = document.querySelector(`[name="questions[${index}][type]"]`);
                        const questionType = typeSelect ? typeSelect.value : '';

                        // Check if question type is selected
                        if (!questionType) {
                            isValid = false;
                            errorMessage = `Harap pilih tipe soal untuk Soal ${index + 1}.`;
                            return;
                        }

                        // Validate based on question type
                        if (questionType === 'pilihan_ganda') {
                            // Check if all options are filled
                            const options = ['option_a', 'option_b', 'option_c', 'option_d'];
                            for (let opt of options) {
                                const optionInput = document.querySelector(`[name="questions[${index}][${opt}]"]`);
                                if (!optionInput || !optionInput.value.trim()) {
                                    isValid = false;
                                    const optionLetter = opt.slice(-1).toUpperCase();
                                    errorMessage = `Harap isi Pilihan ${optionLetter} untuk Soal ${index + 1}.`;
                                    return;
                                }
                            }

                            // Check if correct answer is selected
                            const correctAnswer = document.querySelector(`[name="questions[${index}][correct_answer]"]:checked`);
                            if (!correctAnswer) {
                                isValid = false;
                                errorMessage = `Harap pilih jawaban benar untuk Soal ${index + 1}.`;
                                return;
                            }
                        } else if (questionType === 'benar_salah') {
                            // Check if correct answer is selected
                            const correctAnswer = document.querySelector(`[name="questions[${index}][correct_answer]"]:checked`);
                            if (!correctAnswer) {
                                isValid = false;
                                errorMessage = `Harap pilih jawaban benar untuk Soal ${index + 1}.`;
                                return;
                            }
                        }
                        // Essay questions don't need additional validation as answer is optional
                    });
                }

                if (!isValid) {
                    e.preventDefault();
                    alert(errorMessage);
                    return false;
                }
            });
        });
    </script>

    <style>
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }

        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
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

        .btn-outline-danger {
            color: #dc3545;
            border-color: #dc3545;
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }

        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
        }

        .question-item {
            transition: all 0.3s ease;
        }

        .question-item:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .badge {
            font-size: 0.75rem;
        }

        /* Question type specific styling */
        .question-item[data-question-type="pilihan_ganda"] {
            border-left: 4px solid #0d6efd;
        }

        .question-item[data-question-type="benar_salah"] {
            border-left: 4px solid #198754;
        }

        .question-item[data-question-type="essay"] {
            border-left: 4px solid #ffc107;
        }

        .alert-info {
            background-color: #d1ecf1;
            border-color: #b8daff;
            color: #0c5460;
        }
    </style>
@endsection