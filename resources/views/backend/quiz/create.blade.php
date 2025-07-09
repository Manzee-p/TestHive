@extends('layouts.backend')
@section('content')
<div class="container-fluid">
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Buat Quiz</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="../main/index.html">Quiz</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Buat Quiz</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{asset ('assets/backend/img/illustrations/man-with-laptop.png') }}" alt="modernize-img" class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quiz Setup Form -->
    <div class="card p-4">
    <h5 class="mb-4">Pengaturan Quiz</h5>
    
    <div class="row g-3">
        <div class="col-md-4">
        <label for="quiz_title" class="form-label">Judul Quiz <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-pencil-square"></i></span>
            <input type="text" name="quiz_title" id="quiz_title" class="form-control" placeholder="Masukkan judul quiz">
        </div>
        </div>

        <div class="col-md-4">
        <label for="num_questions" class="form-label">Banyak Soal <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-list-ol"></i></span>
            <input type="number" name="num_questions" id="num_questions" class="form-control" placeholder="Contoh: 10">
        </div>
        </div>

        <div class="col-md-4">
        <label for="duration" class="form-label">Durasi (menit) <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-clock"></i></span>
            <input type="number" name="duration" id="duration" class="form-control" placeholder="Contoh: 60">
        </div>
        </div>

        <div class="col-md-6">
        <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-tags"></i></span>
            <select name="category_id" id="category_id" class="form-select">
            <option selected disabled>Pilih Kategori Quiz</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->nama }}</option>
            @endforeach
            </select>
        </div>
        </div>

        <div class="col-md-6">
        <label for="visibility" class="form-label">Status Visibilitas <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-eye"></i></span>
            <select name="visibility" id="visibility" class="form-select">
            <option selected disabled>Pilih Status</option>
            <option value="Umum">Umum</option>
            <option value="Privat">Privat</option>
            </select>
        </div>
        </div>

        <div class="col-12">
        <label for="description" class="form-label">Deskripsi Quiz</label>
        <textarea name="description" id="description" rows="3" class="form-control" placeholder="Tulis deskripsi quiz..."></textarea>
        </div>
    </div>

    <div class="mt-4 text-end">
        <button type="submit" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Buat Soal
        </button>
    </div>
    </div>

    <!-- Questions Form Container (Initially Hidden) -->
    <div class="card" id="questions-container" style="display: none;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Soal Quiz</h5>
            <button type="button" class="btn btn-outline-secondary btn-sm" id="back-to-setup">
                <i class="ti ti-arrow-left me-1"></i>Kembali ke Pengaturan
            </button>
        </div>
        <div class="card-body">
            <!-- Quiz Info Display -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <h6 class="mb-2">Informasi Quiz:</h6>
                        <p class="mb-1"><strong>Judul:</strong> <span id="display-title"></span></p>
                        <p class="mb-1"><strong>Jumlah Soal:</strong> <span id="display-questions"></span></p>
                        <p class="mb-1"><strong>Durasi:</strong> <span id="display-duration"></span> menit</p>
                        <p class="mb-1"><strong>Status:</strong> <span id="display-visibility"></span></p>
                        <p class="mb-1"><strong>Kategori:</strong> <span id="display-categories"></span></p>
                        <p class="mb-0"><strong>Deskripsi:</strong> <span id="display-description"></span></p>
                    </div>
                </div>
            </div>

            <!-- Final Quiz Form -->
            <form id="final-quiz-form" action="{{ route('backend.quiz.store') }}" method="POST">
                @csrf
                <!-- Hidden fields for quiz info -->
                <input type="hidden" name="quiz_title" id="hidden-title">
                <input type="hidden" name="num_questions" id="hidden-questions">
                <input type="hidden" name="duration" id="hidden-duration">
                <input type="hidden" name="description" id="hidden-description">
                <input type="hidden" name="visibility" id="hidden-visibility">
                <input type="hidden" name="categories" id="hidden-categories">

                <!-- Dynamic Questions Container -->
                <div id="questions-list"></div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class='bx bx-check-circle me-2 p-2'></i>Simpan Quiz
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const setupForm = document.getElementById('quiz-setup-form');
    const setupCard = document.getElementById('quiz-setup-card');
    const questionsContainer = document.getElementById('questions-container');
    const questionsList = document.getElementById('questions-list');
    const backButton = document.getElementById('back-to-setup');
    
    // Handle quiz setup form submission
    setupForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const title = document.getElementById('quiz-title').value;
        const numQuestions = parseInt(document.getElementById('num-questions').value);
        const duration = document.getElementById('duration').value;
        const description = document.getElementById('quiz-description').value;
        const visibility = document.getElementById('visibility').value;
        const categories = document.getElementById('categories').value;
        
        if (!title || !numQuestions || !duration || !visibility || !categories) {
            alert('Harap isi semua field yang wajib diisi.');
            return;
        }
        
        if (numQuestions < 1 || numQuestions > 50) {
            alert('Jumlah soal harus antara 1 sampai 50.');
            return;
        }
        
        // Get category name from selected option
        const categorySelect = document.getElementById('categories');
        const selectedCategoryName = categorySelect.options[categorySelect.selectedIndex].text;
        
        // Update display information
        document.getElementById('display-title').textContent = title;
        document.getElementById('display-questions').textContent = numQuestions;
        document.getElementById('display-duration').textContent = duration;
        document.getElementById('display-description').textContent = description || 'Tidak ada deskripsi';
        document.getElementById('display-visibility').textContent = visibility;
        document.getElementById('display-categories').textContent = selectedCategoryName;
        
        // Update hidden fields
        document.getElementById('hidden-title').value = title;
        document.getElementById('hidden-questions').value = numQuestions;
        document.getElementById('hidden-duration').value = duration;
        document.getElementById('hidden-description').value = description;
        document.getElementById('hidden-visibility').value = visibility;
        document.getElementById('hidden-categories').value = categories;
        
        // Generate question forms
        generateQuestionForms(numQuestions);
        
        // Show questions container and hide setup
        setupCard.style.display = 'none';
        questionsContainer.style.display = 'block';
        
        // Scroll to top
        window.scrollTo(0, 0);
    });
    
    // Handle back to setup button
    backButton.addEventListener('click', function() {
        setupCard.style.display = 'block';
        questionsContainer.style.display = 'none';
        window.scrollTo(0, 0);
    });
    
    // Generate question forms dynamically
    function generateQuestionForms(numQuestions) {
        questionsList.innerHTML = '';
        
        for (let i = 1; i <= numQuestions; i++) {
            const questionCard = createQuestionForm(i);
            questionsList.appendChild(questionCard);
        }
    }
    
    // Create individual question form
    function createQuestionForm(questionNumber) {
        const card = document.createElement('div');
        card.className = 'card mb-4';
        card.innerHTML = `
            <div class="card-header">
                <h6 class="card-title mb-0">Soal ${questionNumber}</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="question-${questionNumber}" class="form-label">Teks Soal <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="question-${questionNumber}" name="questions[${questionNumber}][text]" rows="3" required placeholder="Masukkan soal di sini..."></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option-a-${questionNumber}" class="form-label">Pilihan A <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="option-a-${questionNumber}" name="questions[${questionNumber}][option_a]" required placeholder="Masukkan pilihan A">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option-b-${questionNumber}" class="form-label">Pilihan B <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="option-b-${questionNumber}" name="questions[${questionNumber}][option_b]" required placeholder="Masukkan pilihan B">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option-c-${questionNumber}" class="form-label">Pilihan C <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="option-c-${questionNumber}" name="questions[${questionNumber}][option_c]" required placeholder="Masukkan pilihan C">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="option-d-${questionNumber}" class="form-label">Pilihan D <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="option-d-${questionNumber}" name="questions[${questionNumber}][option_d]" required placeholder="Masukkan pilihan D">
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Jawaban Benar <span class="text-danger">*</span></label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[${questionNumber}][correct_answer]" id="correct-a-${questionNumber}" value="A" required>
                            <label class="form-check-label" for="correct-a-${questionNumber}">A</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[${questionNumber}][correct_answer]" id="correct-b-${questionNumber}" value="B" required>
                            <label class="form-check-label" for="correct-b-${questionNumber}">B</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[${questionNumber}][correct_answer]" id="correct-c-${questionNumber}" value="C" required>
                            <label class="form-check-label" for="correct-c-${questionNumber}">C</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[${questionNumber}][correct_answer]" id="correct-d-${questionNumber}" value="D" required>
                            <label class="form-check-label" for="correct-d-${questionNumber}">D</label>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        return card;
    }
    
    // Form validation before submission
    document.getElementById('final-quiz-form').addEventListener('submit', function(e) {
        const questions = document.querySelectorAll('[name*="[text]"]');
        const options = document.querySelectorAll('[name*="[option_"]');
        const correctAnswers = document.querySelectorAll('[name*="[correct_answer]"]:checked');
        
        let isValid = true;
        let errorMessage = '';
        
        // Check if all questions have text
        questions.forEach((question, index) => {
            if (!question.value.trim()) {
                isValid = false;
                errorMessage = `Harap isi teks untuk Soal ${index + 1}.`;
                return;
            }
        });
        
        // Check if all options are filled
        if (isValid) {
            options.forEach((option, index) => {
                if (!option.value.trim()) {
                    isValid = false;
                    const questionNum = Math.floor(index / 4) + 1;
                    const optionLetter = String.fromCharCode(65 + (index % 4));
                    errorMessage = `Harap isi Pilihan ${optionLetter} untuk Soal ${questionNum}.`;
                    return;
                }
            });
        }
        
        // Check if all questions have correct answers selected
        if (isValid && correctAnswers.length !== questions.length) {
            isValid = false;
            errorMessage = 'Harap pilih jawaban benar untuk semua soal.';
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

.alert-info {
    background-color: #d1ecf1;
    border-color: #b8daff;
    color: #0c5460;
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
</style>
@endsection