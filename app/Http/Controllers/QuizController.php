<?php

namespace App\Http\Controllers;

use App\Models\HasilUjian;
use App\Models\HasilUjianDetail;
use App\Models\Kategori;
use App\Models\MataPelajaran;
use App\Models\Quiz;
use App\Models\Soal;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->isAdmin === 1) {
            $quizzes = Quiz::with(['user', 'soals'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        } else {
            $quizzes = Quiz::with('soals')
            ->orderBy('created_at', 'desc')
            ->get();
        }

        return view('backend.quiz.index', compact('quizzes'));
    }

    public function toggleAktivasi($id)
    {
        $quiz = Quiz::findOrFail($id);

        // Toggle status
        $quiz->status_aktivasi = $quiz->status_aktivasi === 'aktif' ? 'non aktif' : 'aktif';
        $quiz->save();

        return redirect()->back()->with('success', 'Status aktivasi kuis berhasil diperbarui.');
    }

    public function create()
    {
        $categories = Kategori::all();
        $mataPelajaran = MataPelajaran::all();

        return view('backend.quiz.create', compact('categories', 'mataPelajaran'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'quiz_title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'visibility' => 'required|in:Privat,Umum',
            'duration' => 'required|integer|min:1|max:300',
            'categories' => 'required',
            'mapel' => 'required',
            'num_questions' => 'required|integer|min:1|max:50',
            'questions' => 'required|array',
            'questions.*.text' => 'required|string|max:1000',
            'questions.*.type' => 'required|in:pilihan_ganda,essay,benar_salah,checkbox',
            'questions.*.weight' => 'required|integer|min:1|max:100',
            'aktivasi' => 'required|in:aktif,non aktif',
            'pengulangan' => 'required|in:Boleh,Tidak',
            // Multiple choice fields
            'questions.*.option_a' => 'nullable|string|max:255',
            'questions.*.option_b' => 'nullable|string|max:255',
            'questions.*.option_c' => 'nullable|string|max:255',
            'questions.*.option_d' => 'nullable|string|max:255',
            'questions.*.option_e' => 'nullable|string|max:255',
            'questions.*.option_f' => 'nullable|string|max:255',
            'questions.*.option_g' => 'nullable|string|max:255',
            'questions.*.option_h' => 'nullable|string|max:255',
            'questions.*.option_i' => 'nullable|string|max:255',
            'questions.*.option_j' => 'nullable|string|max:255',
            'questions.*.correct_answer' => 'nullable|string',

        ], [
            'quiz_title.required' => 'Judul quiz wajib diisi.',
            'quiz_title.max' => 'Judul quiz maksimal 255 karakter.',
            'description.max' => 'Deskripsi quiz maksimal 1000 karakter.',
            'visibility.required' => 'Status visibilitas quiz wajib dipilih.',
            'visibility.in' => 'Status visibilitas harus Privat atau Umum.',
            'duration.required' => 'Durasi quiz wajib diisi.',
            'duration.integer' => 'Durasi harus berupa angka.',
            'duration.min' => 'Durasi minimal 1 menit.',
            'duration.max' => 'Durasi maksimal 300 menit.',
            'num_questions.required' => 'Jumlah soal wajib diisi.',
            'num_questions.integer' => 'Jumlah soal harus berupa angka.',
            'num_questions.min' => 'Minimal 1 soal.',
            'num_questions.max' => 'Maksimal 50 soal.',
            'questions.required' => 'Soal quiz wajib diisi.',
            'aktivasi.required' => 'Status aktivasi wajib dipilih.',
            'aktivasi.in' => 'Status aktivasi harus aktif atau non aktif.',
            'pengulangan.required' => 'Pengulangan pekerjaan wajib dipilih.',
            'pengulangan.in' => 'Pengulangan pekerjaan harus Boleh atau Tidak.',
            'questions.*.text.required' => 'Teks soal wajib diisi.',
            'questions.*.text.max' => 'Teks soal maksimal 1000 karakter.',
            'questions.*.type.required' => 'Tipe soal wajib dipilih.',
            'questions.*.type.in' => 'Tipe soal tidak valid.',
            'questions.*.weight.required' => 'Bobot soal wajib diisi.',
            'questions.*.weight.integer' => 'Bobot soal harus berupa angka.',
            'questions.*.weight.min' => 'Bobot soal minimal 1.',
            'questions.*.weight.max' => 'Bobot soal maksimal 100.',
            'questions.*.option_a.max' => 'Pilihan A maksimal 255 karakter.',
            'questions.*.option_b.max' => 'Pilihan B maksimal 255 karakter.',
            'questions.*.option_c.max' => 'Pilihan C maksimal 255 karakter.',
            'questions.*.option_d.max' => 'Pilihan D maksimal 255 karakter.',
            'questions.*.option_e.max' => 'Pilihan E maksimal 255 karakter.',
            'questions.*.option_f.max' => 'Pilihan F maksimal 255 karakter.',
            'questions.*.option_g.max' => 'Pilihan G maksimal 255 karakter.',
            'questions.*.option_h.max' => 'Pilihan H maksimal 255 karakter.',
            'questions.*.option_i.max' => 'Pilihan I maksimal 255 karakter.',
            'questions.*.option_j.max' => 'Pilihan J maksimal 255 karakter.',
        ]);

        // Custom validation for question types
        foreach ($validatedData['questions'] as $index => $question) {
            $questionType = $question['type'];
            $questionIndex = $index + 1;

            if ($questionType === 'pilihan_ganda') {
                if (empty($question['option_a']) || empty($question['option_b']) ||
                    empty($question['option_c']) || empty($question['option_d'])) {
                    return back()->withErrors([
                        'questions' => "Semua pilihan (A, B, C, D) wajib diisi untuk soal pilihan ganda nomor {$questionIndex}.",
                    ])->withInput();
                }
                if (empty($question['correct_answer']) || ! in_array($question['correct_answer'], ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'])) {
                    return back()->withErrors([
                        'questions' => "Jawaban benar wajib dipilih untuk soal pilihan ganda nomor {$questionIndex}.",
                    ])->withInput();
                }
            } elseif ($questionType === 'benar_salah') {
                if (empty($question['correct_answer']) || ! in_array($question['correct_answer'], ['Benar', 'Salah'])) {
                    return back()->withErrors([
                        'questions' => "Jawaban benar wajib dipilih untuk soal benar/salah nomor {$questionIndex}.",
                    ])->withInput();
                }
            } 
        }

        if (count($validatedData['questions']) != $validatedData['num_questions']) {
            return back()->withErrors(['questions' => 'Jumlah soal tidak sesuai dengan yang diinputkan.'])
                ->withInput();
        }

        try {
            $kodeQuiz = $this->generateUniqueQuizCode();

            DB::beginTransaction();

            $quiz = Quiz::create([
                'judul_quiz' => $validatedData['quiz_title'],
                'deskripsi' => $validatedData['description'] ?? '',
                'kode_quiz' => $kodeQuiz,
                'waktu_menit' => $validatedData['duration'],
                'kategori_id' => $validatedData['categories'],
                'mata_pelajaran_id' => $validatedData['mapel'],
                'user_id' => Auth::id(),
                'status' => $validatedData['visibility'],
                'status_aktivasi' => $validatedData['aktivasi'],
                'pengulangan_pekerjaan' => $validatedData['pengulangan'],
                'tanggal_buat' => Carbon::now(),
            ]);

            foreach ($validatedData['questions'] as $questionData) {
                $soalData = [
                    'quiz_id' => $quiz->id,
                    'tipe' => $questionData['type'],
                    'pertanyaan' => $questionData['text'],
                    'bobot' => $questionData['weight'],
                    'pilihan_a' => null,
                    'pilihan_b' => null,
                    'pilihan_c' => null,
                    'pilihan_d' => null,
                    'pilihan_e' => null,
                    'pilihan_f' => null,
                    'pilihan_g' => null,
                    'pilihan_h' => null,
                    'pilihan_i' => null,
                    'pilihan_j' => null,
                    'jawaban_benar' => null,
                ];

                // Handle different question types
                switch ($questionData['type']) {
                    case 'pilihan_ganda':
                        $soalData['pilihan_a'] = $questionData['option_a'] ?? null;
                        $soalData['pilihan_b'] = $questionData['option_b'] ?? null;
                        $soalData['pilihan_c'] = $questionData['option_c'] ?? null;
                        $soalData['pilihan_d'] = $questionData['option_d'] ?? null;
                        $soalData['pilihan_e'] = $questionData['option_e'] ?? null;
                        $soalData['pilihan_f'] = $questionData['option_f'] ?? null;
                        $soalData['pilihan_g'] = $questionData['option_g'] ?? null;
                        $soalData['pilihan_h'] = $questionData['option_h'] ?? null;
                        $soalData['pilihan_i'] = $questionData['option_i'] ?? null;
                        $soalData['pilihan_j'] = $questionData['option_j'] ?? null;
                        $soalData['jawaban_benar'] = $questionData['correct_answer'];
                        break;

                    case 'essay':
                        // For essay, we might store model answer or keep it null for manual grading
                        $soalData['jawaban_benar'] = $questionData['correct_answer'] ?? null;
                        break;

                    case 'benar_salah':
                        $soalData['jawaban_benar'] = $questionData['correct_answer'];
                        break;
                }

                Soal::create($soalData);
            }

            DB::commit();

            $statusMessage = $validatedData['visibility'] === 'Umum' ? 'dibuat sebagai umum' : 'dibuat sebagai privat';

            return redirect()->route('quiz.index')
                ->with('success', "Quiz berhasil {$statusMessage} dengan kode: {$kodeQuiz}");

        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error creating quiz: '.$e->getMessage());

            return back()->withErrors(['error' => 'Terjadi kesalahan saat membuat quiz. Silakan coba lagi.'])
                ->withInput();
        }
    }

    private function generateUniqueQuizCode()
    {
        do {
            $code = strtoupper(Str::random(6));
        } while (Quiz::where('kode_quiz', $code)->exists());

        return $code;
    }

    public function show(Quiz $quiz)
    {
        $quiz->load('soals');

        return view('backend.quiz.show', compact('quiz'));
    }

    public function edit($id)
    {
        try {
            $quiz = Quiz::with(['soals', 'kategori'])->findOrFail($id);

            $categories = Kategori::all();
            $mataPelajaran = MataPelajaran::all();

            return view('backend.quiz.edit', compact('quiz', 'categories', 'mataPelajaran'));

        } catch (\Exception $e) {
            return redirect()->route('quiz.index')
                ->with('error', 'Quiz tidak ditemukan atau terjadi kesalahan.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $quiz = Quiz::with('soals')->findOrFail($id);

            $validator = Validator::make($request->all(), [
                'judul_quiz' => 'required|string|max:255',
                'deskripsi' => 'nullable|string|max:1000',
                'waktu_menit' => 'required|integer|min:1|max:300',
                'status' => 'required|in:Privat,Umum',
                'categories' => 'required',
                'mapel' => 'required',
                'questions' => 'required|array|min:1|max:50',
                'questions.*.text' => 'required|string|max:1000',
                'questions.*.type' => 'required|in:pilihan_ganda,essay,benar_salah,checkbox',
                'questions.*.weight' => 'required|integer|min:1|max:100',
                // Multiple choice fields
                'questions.*.option_a' => 'nullable|string|max:255',
                'questions.*.option_b' => 'nullable|string|max:255',
                'questions.*.option_c' => 'nullable|string|max:255',
                'questions.*.option_d' => 'nullable|string|max:255',
                'questions.*.option_e' => 'nullable|string|max:255',
                'questions.*.option_f' => 'nullable|string|max:255',
                'questions.*.option_g' => 'nullable|string|max:255',
                'questions.*.option_h' => 'nullable|string|max:255',
                'questions.*.option_i' => 'nullable|string|max:255',
                'questions.*.option_j' => 'nullable|string|max:255',
                'questions.*.correct_answer' => 'nullable|string',
                'questions.*.id' => 'nullable|integer|exists:soals,id',
            ], [
                'judul_quiz.required' => 'Judul quiz wajib diisi.',
                'judul_quiz.max' => 'Judul quiz tidak boleh lebih dari 255 karakter.',
                'waktu_menit.required' => 'Durasi quiz wajib diisi.',
                'waktu_menit.min' => 'Durasi quiz minimal 1 menit.',
                'waktu_menit.max' => 'Durasi quiz maksimal 300 menit.',
                'status.required' => 'Status quiz wajib dipilih.',
                'status.in' => 'Status quiz harus Privat atau Umum.',
                'questions.required' => 'Quiz harus memiliki minimal satu soal.',
                'questions.min' => 'Quiz harus memiliki minimal satu soal.',
                'questions.max' => 'Quiz maksimal memiliki 50 soal.',
                'questions.*.text.required' => 'Teks soal wajib diisi.',
                'questions.*.text.max' => 'Teks soal tidak boleh lebih dari 1000 karakter.',
                'questions.*.type.required' => 'Tipe soal wajib dipilih.',
                'questions.*.type.in' => 'Tipe soal tidak valid.',
                'questions.*.weight.required' => 'Bobot soal wajib diisi.',
                'questions.*.weight.integer' => 'Bobot soal harus berupa angka.',
                'questions.*.weight.min' => 'Bobot soal minimal 1.',
                'questions.*.weight.max' => 'Bobot soal maksimal 100.',
            ]);

            // Custom validation for question types
            foreach ($request->questions as $index => $question) {
                $questionType = $question['type'];
                $questionIndex = $index + 1;

                if ($questionType === 'pilihan_ganda') {
                    if (empty($question['option_a']) || empty($question['option_b']) ||
                        empty($question['option_c']) || empty($question['option_d'])) {
                        return back()->withErrors([
                            'questions' => "Semua pilihan (A, B, C, D) wajib diisi untuk soal pilihan ganda nomor {$questionIndex}.",
                        ])->withInput();
                    }
                    if (empty($question['correct_answer']) || !in_array($question['correct_answer'], ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'])) {
                        return back()->withErrors([
                            'questions' => "Jawaban benar wajib dipilih untuk soal pilihan ganda nomor {$questionIndex}.",
                        ])->withInput();
                    }
                } elseif ($questionType === 'benar_salah') {
                    if (empty($question['correct_answer']) || !in_array($question['correct_answer'], ['Benar', 'Salah'])) {
                        return back()->withErrors([
                            'questions' => "Jawaban benar wajib dipilih untuk soal benar/salah nomor {$questionIndex}.",
                        ])->withInput();
                    }
                } 
            }

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.');
            }

            DB::beginTransaction();

            try {
                $quiz->update([
                    'judul_quiz' => $request->judul_quiz,
                    'deskripsi' => $request->deskripsi,
                    'waktu_menit' => $request->waktu_menit,
                    'status' => $request->status,
                    'user_id' => $quiz->user_id,
                    'kategori_id' => $request->categories,
                    'mata_pelajaran_id' => $request->mapel,
                    'kode_quiz' => $quiz->kode_quiz,
                    'tanggal_buat' => $quiz->tanggal_buat,
                ]);

                $existingQuestionIds = $quiz->soals->pluck('id')->toArray();
                $updatedQuestionIds = [];

                foreach ($request->questions as $index => $questionData) {
                    $soalData = [
                        'tipe' => $questionData['type'],
                        'pertanyaan' => $questionData['text'],
                        'bobot' => $questionData['weight'],
                        'pilihan_a' => null,
                        'pilihan_b' => null,
                        'pilihan_c' => null,
                        'pilihan_d' => null,
                        'pilihan_e' => null,
                        'pilihan_f' => null,
                        'pilihan_g' => null,
                        'pilihan_h' => null,
                        'pilihan_i' => null,
                        'pilihan_j' => null,
                        'jawaban_benar' => null,
                    ];

                    // Handle different question types
                    switch ($questionData['type']) {
                        case 'pilihan_ganda':
                            $soalData['pilihan_a'] = $questionData['option_a'] ?? null;
                            $soalData['pilihan_b'] = $questionData['option_b'] ?? null;
                            $soalData['pilihan_c'] = $questionData['option_c'] ?? null;
                            $soalData['pilihan_d'] = $questionData['option_d'] ?? null;
                            $soalData['pilihan_e'] = $questionData['option_e'] ?? null;
                            $soalData['pilihan_f'] = $questionData['option_f'] ?? null;
                            $soalData['pilihan_g'] = $questionData['option_g'] ?? null;
                            $soalData['pilihan_h'] = $questionData['option_h'] ?? null;
                            $soalData['pilihan_i'] = $questionData['option_i'] ?? null;
                            $soalData['pilihan_j'] = $questionData['option_j'] ?? null;
                            $soalData['jawaban_benar'] = $questionData['correct_answer'];
                            break;

                        case 'essay':
                            $soalData['jawaban_benar'] = $questionData['correct_answer'] ?? null;
                            break;

                        case 'benar_salah':
                            $soalData['jawaban_benar'] = $questionData['correct_answer'];
                            break;
                            
                    }

                    if (isset($questionData['id']) && !empty($questionData['id'])) {
                        $question = Soal::findOrFail($questionData['id']);

                        if ($question->quiz_id !== $quiz->id) {
                            throw new \Exception('Invalid question ID provided.');
                        }

                        $question->update($soalData);
                        $updatedQuestionIds[] = $question->id;

                    } else {
                        $soalData['quiz_id'] = $quiz->id;
                        $newQuestion = Soal::create($soalData);
                        $updatedQuestionIds[] = $newQuestion->id;
                    }
                }

                $questionsToDelete = array_diff($existingQuestionIds, $updatedQuestionIds);
                if (!empty($questionsToDelete)) {
                    Soal::whereIn('id', $questionsToDelete)->delete();
                }

                DB::commit();

                return redirect()->route('quiz.index')
                    ->with('success', 'Quiz berhasil diperbarui!');

            } catch (\Exception $e) {
                DB::rollback();

                return redirect()->back()
                    ->withInput()   
                    ->with('error', 'Terjadi kesalahan saat memperbarui quiz: '.$e->getMessage());
            }

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('quiz.index')
                ->with('error', 'Quiz tidak ditemukan.');

        } catch (\Exception $e) {
            return redirect()->route('quiz.index')
                ->with('error', 'Terjadi kesalahan yang tidak terduga.');
        }
    }

    private function generateQuizCode()
    {
        do {
            $code = 'QZ'.strtoupper(substr(md5(uniqid(rand(), true)), 0, 6));
        } while (Quiz::where('kode_quiz', $code)->exists());

        return $code;
    }

    public function destroy(Quiz $quiz)
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus quiz ini.');
        }
        try {
            DB::beginTransaction();

            $quiz->soals()->delete();
            $quiz->delete();
            DB::commit();

            return redirect()->route('quiz.index')
                ->with('success', 'Quiz berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error deleting quiz: '.$e->getMessage());

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus quiz.']);
        }
    }

    public function start($id)
    {
        $quiz = Quiz::with('soals')->findOrFail($id);
        $startTime = now()->timestamp;

        if ($quiz->status_aktivasi === 'non aktif') {
            return redirect()->back()->with('error', 'Quiz sedang tidak dapat dikerjakan');
        }

        // Cek apakah pengulangan tidak diperbolehkan
        if ($quiz->pengulangan_pekerjaan === 'Tidak') {
            $sudahMengerjakan = HasilUjian::where('user_id', Auth::id())
                ->where('quiz_id', $quiz->id)
                ->exists();

            if ($sudahMengerjakan) {
                return redirect()->back()->with('error', 'Anda sudah mengerjakan quiz ini sebelumnya');
            }
        }

        return view('frontend.quiz_start', compact('quiz', 'startTime'));
    }

    public function submit(Request $request, $id)
    {
        $quiz = Quiz::with('soals')->findOrFail($id);
        $soals = $quiz->soals;
        
        // Initialize scoring variables
        $totalBobot = 0;
        $bobotBenar = 0;
        $jawabanBenar = 0;
        $jumlahSalah = 0;
        $detailJawaban = [];

        // Process each question based on its type
        foreach ($soals as $soal) {
            $totalBobot += $soal->bobot;
            $jawabanUser = null;
            $statusJawaban = 'salah';
            $bobotDiperoleh = 0;

            switch ($soal->tipe) {
                case 'pilihan_ganda':
                    $jawabanUser = $request->input('jawaban_' . $soal->id);
                    if ($jawabanUser === $soal->jawaban_benar) {
                        $bobotDiperoleh = $soal->bobot;
                        $bobotBenar += $soal->bobot;
                        $jawabanBenar++;
                        $statusJawaban = 'benar';
                    } else {
                        $jumlahSalah++;
                        $statusJawaban = 'salah';
                    }
                    break;

                case 'benar_salah':
                    $jawabanUser = $request->input('jawaban_' . $soal->id);
                    if ($jawabanUser === $soal->jawaban_benar) {
                        $bobotDiperoleh = $soal->bobot;
                        $bobotBenar += $soal->bobot;
                        $jawabanBenar++;
                        $statusJawaban = 'benar';
                    } else {
                        $jumlahSalah++;
                        $statusJawaban = 'salah';
                    }
                    break;
                    
                    if ($totalJawabanBenar > 0) {
                        $bobotPerJawaban = $soal->bobot / $totalJawabanBenar;

                        // Hitung nilai akhir (penalti = 50% dari nilai benar)
                        $nilaiBenar = $jumlahBenarDipilih * $bobotPerJawaban;
                        $penalti = $jumlahSalahDipilih * ($bobotPerJawaban / 2);
                        $bobotDiperoleh = max(0, $nilaiBenar - $penalti);

                        $bobotBenar += $bobotDiperoleh;

                        // Status
                        if ($jumlahBenarDipilih === $totalJawabanBenar && $jumlahSalahDipilih === 0) {
                            $jawabanBenar++;
                            $statusJawaban = 'benar';
                        } elseif ($bobotDiperoleh > 0) {
                            $statusJawaban = 'sebagian';
                        } else {
                            $jumlahSalah++;
                            $statusJawaban = 'salah';
                        }
                    } else {
                        $jumlahSalah++;
                        $statusJawaban = 'salah';
                    }
                    break;

                case 'essay':
                    $jawabanUser = $request->input('jawaban_' . $soal->id);
                    $statusJawaban = 'pending';
                    $bobotDiperoleh = 0;
                    // Essay tidak dihitung dalam jawaban benar/salah sampai dinilai manual
                    break;

                default:
                    $jumlahSalah++;
                    $statusJawaban = 'salah';
                    $bobotDiperoleh = 0;
                    break;
            }

            // *** PERBAIKAN: SELALU SIMPAN DETAIL JAWABAN ***
            // Store detail for later insertion - untuk semua jenis quiz
            $detailJawaban[] = [
                'soal_id' => $soal->id,
                'jawaban_peserta' => $jawabanUser ?? '',
                'status_jawaban' => $statusJawaban,
                'bobot_soal' => (int) $soal->bobot,
                'bobot_diperoleh' => round($bobotDiperoleh, 2),
            ];
        }

        // Calculate final score based on weights
        $skor = $totalBobot > 0 ? round(($bobotBenar / $totalBobot) * 100, 2) : 0;

        // Calculate time taken
        $startTimestamp = (int) $request->input('start_time');
        $nowTimestamp = now()->timestamp;
        $waktuPengerjaan = max(0, $nowTimestamp - $startTimestamp);
        $waktuPengerjaanMenitDecimal = round($waktuPengerjaan / 60, 2);

        // Check if exam result already exists
        $hasil = HasilUjian::where('user_id', Auth::id())
            ->where('quiz_id', $quiz->id)
            ->first();

        try {
            DB::beginTransaction();

            if ($hasil) {
                // Update existing result
                $hasil->update([
                    'skor' => $skor,
                    'jumlah_benar' => $jawabanBenar,
                    'jumlah_salah' => $jumlahSalah,
                    'total_bobot' => $totalBobot,
                    'bobot_diperoleh' => round($bobotBenar, 2),
                    'waktu_pengerjaan' => $waktuPengerjaanMenitDecimal,
                    'tanggal_ujian' => Carbon::now()->toDateString(),
                ]);

                // *** PERBAIKAN: SELALU SIMPAN DETAIL JAWABAN ***
                // Delete old details and insert new ones
                $hasil->detail()->delete();

                foreach ($detailJawaban as $detail) {
                    HasilUjianDetail::create([
                        'hasil_ujian_id' => $hasil->id,
                        'soal_id' => $detail['soal_id'],
                        'jawaban_peserta' => $detail['jawaban_peserta'],
                        'status_jawaban' => $detail['status_jawaban'],
                        'bobot_soal' => $detail['bobot_soal'],
                        'bobot_diperoleh' => $detail['bobot_diperoleh'],
                    ]);
                }
            } else {
                // Create new result
                $hasil = HasilUjian::create([
                    'user_id' => Auth::id(),
                    'quiz_id' => $quiz->id,
                    'skor' => $skor,
                    'jumlah_benar' => $jawabanBenar,
                    'jumlah_salah' => $jumlahSalah,
                    'total_bobot' => $totalBobot,
                    'bobot_diperoleh' => round($bobotBenar, 2),
                    'waktu_pengerjaan' => $waktuPengerjaanMenitDecimal,
                    'tanggal_ujian' => Carbon::now()->toDateString(),
                ]);

                // *** PERBAIKAN: SELALU SIMPAN DETAIL JAWABAN ***
                // Insert answer details untuk semua jenis quiz
                foreach ($detailJawaban as $detail) {
                    HasilUjianDetail::create([
                        'hasil_ujian_id' => $hasil->id,
                        'soal_id' => $detail['soal_id'],
                        'jawaban_peserta' => $detail['jawaban_peserta'],
                        'status_jawaban' => $detail['status_jawaban'],
                        'bobot_soal' => $detail['bobot_soal'],
                        'bobot_diperoleh' => $detail['bobot_diperoleh'],
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('quiz.hasil', $hasil->id)
                ->with('success', 'Quiz berhasil disubmit. Skor Anda: ' . $skor . ' (Bobot: ' . round($bobotBenar, 2) . '/' . $totalBobot . ')');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error submitting quiz: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan hasil quiz. Silakan coba lagi.']);
        }
    }

    public function hasil($id)
    {
        try {
            // Get exam result with quiz and related data
            $hasil = HasilUjian::with(['quiz.mataPelajaran', 'detail.soal', 'user'])->findOrFail($id);

            // Pastikan user hanya bisa melihat hasil mereka sendiri (kecuali admin)
            $user = Auth::user();
            if ($hasil->user_id !== Auth::id() && (!$user || ($user->isAdmin != 1 && $user->isAdmin != 2))) {
                abort(403, 'Anda tidak memiliki akses untuk melihat hasil ini.');
            }

            // Calculate ranking based on weighted score
            $ranking = HasilUjian::where('quiz_id', $hasil->quiz_id)
                ->where(function($query) use ($hasil) {
                    $query->where('bobot_diperoleh', '>', $hasil->bobot_diperoleh)
                        ->orWhere(function($subQuery) use ($hasil) {
                            $subQuery->where('bobot_diperoleh', '=', $hasil->bobot_diperoleh)
                                    ->where('waktu_pengerjaan', '<', $hasil->waktu_pengerjaan);
                        });
                })
                ->count() + 1;

            // Get total participants for the same quiz
            $total_peserta = HasilUjian::where('quiz_id', $hasil->quiz_id)->count();

            // Get top 10 performers based on weighted score and time
            $top_performers = HasilUjian::with('user')
                ->where('quiz_id', $hasil->quiz_id)
                ->orderBy('bobot_diperoleh', 'desc')
                ->orderBy('waktu_pengerjaan', 'asc')
                ->take(10)
                ->get();

            // *** PERBAIKAN: SELALU AMBIL DETAIL JAWABAN ***
            // Get detail results - sekarang selalu ada karena selalu disimpan
            $hasil_detail = $hasil->detail()->with('soal')->get();
            
            // Jika detail kosong (untuk backward compatibility), buat detail dummy
            if ($hasil_detail->isEmpty() && $hasil->quiz->soals->count() > 0) {
                // Buat detail dummy untuk quiz lama yang tidak memiliki detail
                $dummyDetails = collect();
                foreach ($hasil->quiz->soals as $index => $soal) {
                    $dummyDetail = (object) [
                        'id' => 'dummy_' . $soal->id,
                        'soal_id' => $soal->id,
                        'jawaban_peserta' => 'Data tidak tersedia',
                        'status_jawaban' => 'unknown',
                        'bobot_soal' => $soal->bobot,
                        'bobot_diperoleh' => 0,
                        'feedback' => null,
                        'soal' => $soal,
                        'hasil_ujian_id' => $hasil->id,
                        'created_at' => $hasil->created_at,
                        'updated_at' => $hasil->updated_at,
                    ];
                    $dummyDetails->push($dummyDetail);
                }
                $hasil_detail = $dummyDetails;
            }

            return view('frontend.quiz_hasil_pengerjaan', compact(
                'hasil',
                'ranking',
                'total_peserta',
                'top_performers',
                'hasil_detail'
            ));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('dashboard')
                ->with('error', 'Hasil quiz tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error viewing quiz result: ' . $e->getMessage());
            return redirect()->route('dashboard')
                ->with('error', 'Terjadi kesalahan saat menampilkan hasil quiz.');
        }
    }

    /**
     * Tampilkan daftar jawaban esai yang perlu dinilai - FIXED VERSION
     */
    public function essayGrading()
    {
        $user = Auth::user();
        
        // Validasi admin yang lebih fleksibel
        if (!$user || ($user->isAdmin != 1 && $user->isAdmin != 2)) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda perlu login sebagai admin untuk mengakses fitur penilaian esai.');
        }

        try {
            // Ambil semua hasil ujian dengan soal esai yang belum dinilai
            $essayAnswers = HasilUjianDetail::with(['hasilUjian.user', 'hasilUjian.quiz', 'soal'])
                ->whereHas('soal', function($query) {
                    $query->where('tipe', 'essay');
                })
                ->whereHas('hasilUjian.quiz', function($query) {
                    $query->where('user_id', Auth::id()); // Hanya quiz milik admin yang login
                })
                ->where('status_jawaban', 'pending')
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            // *** PERBAIKAN: Hitung statistik dengan benar ***
            
            // 1. Total esai yang perlu dinilai (pending)
            $pendingCount = HasilUjianDetail::whereHas('soal', function($query) {
                    $query->where('tipe', 'essay');
                })
                ->whereHas('hasilUjian.quiz', function($query) {
                    $query->where('user_id', Auth::id());
                })
                ->where('status_jawaban', 'pending')
                ->count();
                
            // 2. Total esai yang sudah dinilai
            $gradedCount = HasilUjianDetail::whereHas('soal', function($query) {
                    $query->where('tipe', 'essay');
                })
                ->whereHas('hasilUjian.quiz', function($query) {
                    $query->where('user_id', Auth::id());
                })
                ->whereIn('status_jawaban', ['benar', 'salah', 'sebagian'])
                ->count();
                
            // 3. Total SEMUA esai (pending + graded)
            $totalEssays = HasilUjianDetail::whereHas('soal', function($query) {
                    $query->where('tipe', 'essay');
                })
                ->whereHas('hasilUjian.quiz', function($query) {
                    $query->where('user_id', Auth::id());
                })
                ->count();
            
            // 4. Hitung progress percentage
            $progressPercent = $totalEssays > 0 ? round(($gradedCount / $totalEssays) * 100, 1) : 0;
            
            // 5. Group by user untuk card display
            $groupedByUser = $essayAnswers->groupBy('hasilUjian.user_id');
            $totalUsers = $groupedByUser->count();
            
            // 6. Hitung user yang sudah selesai dinilai semua esainya
            $gradedUsers = HasilUjianDetail::whereHas('soal', function($query) {
                    $query->where('tipe', 'essay');
                })
                ->whereHas('hasilUjian.quiz', function($query) {
                    $query->where('user_id', Auth::id());
                })
                ->whereIn('status_jawaban', ['benar', 'salah', 'sebagian'])
                ->with('hasilUjian.user')
                ->get()
                ->groupBy('hasilUjian.user_id')
                ->count();

            // Debug log untuk troubleshooting
            Log::info('Essay Grading Stats', [
                'pending_count' => $pendingCount,
                'graded_count' => $gradedCount,
                'total_essays' => $totalEssays,
                'progress_percent' => $progressPercent,
                'total_users' => $totalUsers,
                'graded_users' => $gradedUsers,
                'essay_answers_count' => $essayAnswers->count()
            ]);

            // PASTIKAN semua variable dikirim ke view
            return view('backend.penilaianesai.essay_grading', compact(
                'essayAnswers',      // Variable utama yang berisi data essay
                'pendingCount',
                'gradedCount', 
                'totalEssays',
                'progressPercent',
                'totalUsers',
                'gradedUsers'
            ));
            
        } catch (\Exception $e) {
            Log::error('Error in essayGrading: ' . $e->getMessage());
            
            // Jika terjadi error, buat variable kosong untuk menghindari undefined variable
            $essayAnswers = collect();
            $pendingCount = 0;
            $gradedCount = 0;
            $totalEssays = 0;
            $progressPercent = 0;
            $totalUsers = 0;
            $gradedUsers = 0;
            
            return view('backend.penilaianesai.essay_grading', compact(
                'essayAnswers',
                'pendingCount',
                'gradedCount', 
                'totalEssays',
                'progressPercent',
                'totalUsers',
                'gradedUsers'
            ))->with('error', 'Terjadi kesalahan saat memuat halaman penilaian esai.');
        }
    }

    /**
     * Simpan penilaian esai
     */
    public function storeEssayGrade(Request $request, $detailId)
    {
        $user = Auth::user();
        
        if (!$user || ($user->isAdmin != 1 && $user->isAdmin != 2)) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda perlu login sebagai admin untuk menyimpan penilaian esai.');
        }

        try {
            $essayDetail = HasilUjianDetail::with(['hasilUjian.user', 'hasilUjian.quiz', 'soal'])
                ->whereHas('hasilUjian.quiz', function($query) {
                    $query->where('user_id', Auth::id());
                })
                ->findOrFail($detailId);

            // Validasi input
            $validated = $request->validate([
                'bobot_diperoleh' => 'required|numeric|min:0|max:' . $essayDetail->bobot_soal,
                'feedback' => 'nullable|string|max:1000',
                'status_jawaban' => 'required|in:benar,salah,sebagian'
            ], [
                'bobot_diperoleh.required' => 'Bobot yang diperoleh wajib diisi.',
                'bobot_diperoleh.numeric' => 'Bobot harus berupa angka.',
                'bobot_diperoleh.min' => 'Bobot tidak boleh kurang dari 0.',
                'bobot_diperoleh.max' => 'Bobot tidak boleh lebih dari ' . $essayDetail->bobot_soal,
                'feedback.max' => 'Feedback maksimal 1000 karakter.',
                'status_jawaban.required' => 'Status jawaban wajib dipilih.',
                'status_jawaban.in' => 'Status jawaban tidak valid.'
            ]);

            DB::beginTransaction();

            // *** PERBAIKAN: Simpan ke bobot_diperoleh, bukan nilai_esai ***
            $essayDetail->update([
                'bobot_diperoleh' => $validated['bobot_diperoleh'],
                'status_jawaban' => $validated['status_jawaban'],
                'feedback' => $validated['feedback'] ?? null,
            ]);

            // Recalculate total score untuk hasil ujian ini
            $this->recalculateExamScore($essayDetail->hasil_ujian_id);

            DB::commit();

            return redirect()->route('quiz.essay.grading')
                ->with('success', 'Penilaian esai berhasil disimpan dan skor total telah diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error grading essay: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan penilaian.');
        }
    }

    /**
     * Hitung ulang skor total setelah penilaian esai
     */
    private function recalculateExamScore($hasilUjianId)
    {
        try {
            $hasilUjian = HasilUjian::with('detail')->findOrFail($hasilUjianId);
            
            $totalBobot = 0;
            $bobotDiperoleh = 0;
            $jawabanBenar = 0;
            $jawabanSalah = 0;

            foreach ($hasilUjian->detail as $detail) {
                $totalBobot += $detail->bobot_soal;
                $bobotDiperoleh += $detail->bobot_diperoleh;

                if ($detail->status_jawaban === 'benar') {
                    $jawabanBenar++;
                } elseif ($detail->status_jawaban === 'salah') {
                    $jawabanSalah++;
                }
                // 'sebagian' dan 'pending' tidak dihitung sebagai benar atau salah
            }

            // Hitung skor persentase
            $skor = $totalBobot > 0 ? round(($bobotDiperoleh / $totalBobot) * 100, 2) : 0;

            // Update hasil ujian
            $hasilUjian->update([
                'skor' => $skor,
                'jumlah_benar' => $jawabanBenar,
                'jumlah_salah' => $jawabanSalah,
                'total_bobot' => $totalBobot,
                'bobot_diperoleh' => round($bobotDiperoleh, 2),
            ]);

        } catch (\Exception $e) {
            Log::error('Error recalculating exam score: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Bulk grading - untuk menilai beberapa esai sekaligus
     */
        public function bulkGradeEssay(Request $request)
        {
            $user = Auth::user();
            
            if (!$user || ($user->isAdmin != 1 && $user->isAdmin != 2)) {
                return redirect()->route('dashboard')
                    ->with('error', 'Anda perlu login sebagai admin untuk melakukan bulk grading.');
            }

            try {
                $validated = $request->validate([
                    'grades' => 'required|array',
                    'grades.*.detail_id' => 'required|integer|exists:hasil_ujian_details,id',
                    'grades.*.bobot_diperoleh' => 'required|numeric|min:0',
                    'grades.*.status_jawaban' => 'required|in:benar,salah,sebagian',
                    'grades.*.feedback' => 'nullable|string|max:1000',
                ]);

                DB::beginTransaction();

                $updatedExams = [];

                foreach ($validated['grades'] as $gradeData) {
                    $essayDetail = HasilUjianDetail::with('hasilUjian.quiz')
                        ->whereHas('hasilUjian.quiz', function($query) {
                            $query->where('user_id', Auth::id());
                        })
                        ->findOrFail($gradeData['detail_id']);

                    // Validasi bobot maksimal
                    if ($gradeData['bobot_diperoleh'] > $essayDetail->bobot_soal) {
                        throw new \Exception("Bobot untuk detail ID {$gradeData['detail_id']} melebihi bobot soal.");
                    }

                    $essayDetail->update([
                        'bobot_diperoleh' => $gradeData['bobot_diperoleh'],
                        'status_jawaban' => $gradeData['status_jawaban'],
                        'feedback' => $gradeData['feedback'] ?? null,
                    ]);

                    // Kumpulkan ID hasil ujian yang perlu dihitung ulang
                    $updatedExams[] = $essayDetail->hasil_ujian_id;
                }

                // Hitung ulang skor untuk setiap hasil ujian yang terpengaruh
                foreach (array_unique($updatedExams) as $examId) {
                    $this->recalculateExamScore($examId);
                }

                DB::commit();

                return redirect()->route('quiz.essay.grading')
                    ->with('success', count($validated['grades']) . ' jawaban esai berhasil dinilai dan skor telah diperbarui.');

            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Error bulk grading essays: ' . $e->getMessage());

                return back()->withInput()
                    ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }

        /**
         * Tampilkan statistik penilaian esai
         */
        public function essayGradingStats()
        {
            $user = Auth::user();
            
            if (!$user || ($user->isAdmin != 1 && $user->isAdmin != 2)) {
                return redirect()->route('dashboard')
                    ->with('error', 'Anda perlu login sebagai admin untuk melihat statistik penilaian.');
            }

            try {
                // Total esai yang perlu dinilai
                $pendingCount = HasilUjianDetail::whereHas('soal', function($query) {
                        $query->where('tipe', 'essay');
                    })
                    ->whereHas('hasilUjian.quiz', function($query) {
                        $query->where('user_id', Auth::id());
                    })
                    ->where('status_jawaban', 'pending')
                    ->count();

                // Total esai yang sudah dinilai
                $gradedCount = HasilUjianDetail::whereHas('soal', function($query) {
                        $query->where('tipe', 'essay');
                    })
                    ->whereHas('hasilUjian.quiz', function($query) {
                        $query->where('user_id', Auth::id());
                    })
                    ->whereIn('status_jawaban', ['benar', 'salah', 'sebagian'])
                    ->count();

                // Quiz dengan esai terbanyak yang belum dinilai
                $quizWithMostPending = DB::table('hasil_ujian_details')
                    ->join('soals', 'hasil_ujian_details.soal_id', '=', 'soals.id')
                    ->join('hasil_ujians', 'hasil_ujian_details.hasil_ujian_id', '=', 'hasil_ujians.id')
                    ->join('quizzes', 'hasil_ujians.quiz_id', '=', 'quizzes.id')
                    ->where('soals.tipe', 'essay')
                    ->where('quizzes.user_id', Auth::id())
                    ->where('hasil_ujian_details.status_jawaban', 'pending')
                    ->select('quizzes.judul_quiz', DB::raw('COUNT(*) as pending_count'))
                    ->groupBy('quizzes.id', 'quizzes.judul_quiz')
                    ->orderBy('pending_count', 'desc')
                    ->limit(5)
                    ->get();

                return view('backend.penilaianesai.essay_stats', compact(
                    'pendingCount',
                    'gradedCount', 
                    'quizWithMostPending'
                ));
                
            } catch (\Exception $e) {
                Log::error('Error in essayGradingStats: ' . $e->getMessage());
                
                return redirect()->route('dashboard')
                    ->with('error', 'Terjadi kesalahan saat memuat statistik penilaian esai.');
            }
        }

    /**
     * Tampilkan detail soal dengan semua jawaban peserta untuk grading massal
     */
    public function hasilKeseluruhan(Request $request)
    {
        $user = Auth::user();
        
        // Cek apakah user adalah admin
        if (!$user || ($user->isAdmin != 1 && $user->isAdmin != 2)) {
            return redirect()->route('dashboard')
                ->with('error', 'Akses ditolak. Hanya admin yang dapat melihat hasil keseluruhan.');
        }

        try {
            // Ambil semua quiz milik admin untuk dropdown filter
            $quizList = Quiz::where('user_id', Auth::id())
                ->select('id', 'judul_quiz', 'kode_quiz')
                ->orderBy('judul_quiz')
                ->get();

            // Query builder untuk hasil ujian
            $query = HasilUjian::with(['quiz', 'user', 'detail'])
                ->whereHas('quiz', function($q) {
                    $q->where('user_id', Auth::id());
                });

            // Filter berdasarkan quiz
            if ($request->filled('quiz_id')) {
                $query->where('quiz_id', $request->quiz_id);
            }

            // Filter berdasarkan tanggal
            if ($request->filled('tanggal_dari')) {
                $query->where('tanggal_ujian', '>=', $request->tanggal_dari);
            }

            if ($request->filled('tanggal_sampai')) {
                $query->where('tanggal_ujian', '<=', $request->tanggal_sampai);
            }

            // Filter berdasarkan skor minimal
            if ($request->filled('skor_minimal')) {
                $query->where('skor', '>=', $request->skor_minimal);
            }

            // Sorting
            $sortBy = $request->get('sort_by', 'tanggal_ujian');
            $sortOrder = $request->get('sort_order', 'desc');
            
            $allowedSortFields = ['tanggal_ujian', 'skor', 'bobot_diperoleh', 'waktu_pengerjaan', 'jumlah_benar'];
            if (!in_array($sortBy, $allowedSortFields)) {
                $sortBy = 'tanggal_ujian';
            }
            
            $query->orderBy($sortBy, $sortOrder);

            // Pagination
            $hasilUjian = $query->paginate(15)->appends($request->query());

            // Statistik untuk quiz tertentu (jika dipilih)
            $statistik = null;
            if ($request->filled('quiz_id')) {
                $selectedQuiz = Quiz::find($request->quiz_id);
                if ($selectedQuiz) {
                    $statsQuery = HasilUjian::where('quiz_id', $request->quiz_id);
                    
                    $statistik = [
                        'quiz_title' => $selectedQuiz->judul_quiz,
                        'quiz_code' => $selectedQuiz->kode_quiz,
                        'total_peserta' => $statsQuery->count(),
                        'rata_rata_skor' => $statsQuery->avg('skor') ?? 0,
                        'skor_tertinggi' => $statsQuery->max('skor') ?? 0,
                        'skor_terendah' => $statsQuery->min('skor') ?? 0,
                        'rata_rata_waktu' => $statsQuery->avg('waktu_pengerjaan') ?? 0,
                    ];
                }
            }

            // PERBAIKAN: Path view yang benar
            return view('backend.hasil.hasil_keseluruhan', compact(
                'hasilUjian', 
                'quizList', 
                'statistik'
            ));
            
        } catch (\Exception $e) {
            Log::error('Error in hasilKeseluruhan: ' . $e->getMessage());
            
            return redirect()->route('quiz.index')
                ->with('error', 'Terjadi kesalahan saat memuat hasil quiz: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan detail hasil quiz untuk admin
    */
    public function detailHasilAdmin($hasilId)
    {
        $user = Auth::user();
        
        // Cek apakah user adalah admin
        if (!$user || ($user->isAdmin != 1 && $user->isAdmin != 2)) {
            return redirect()->route('dashboard')
                ->with('error', 'Akses ditolak. Hanya admin yang dapat melihat detail hasil.');
        }

        try {
            // Ambil hasil ujian dengan memastikan quiz milik admin yang login
            $hasil = HasilUjian::with(['quiz.mataPelajaran', 'quiz.kategori', 'detail.soal', 'user'])
                ->whereHas('quiz', function($query) {
                    $query->where('user_id', Auth::id());
                })
                ->findOrFail($hasilId);

            // Hitung ranking peserta dalam quiz ini
            $ranking = HasilUjian::where('quiz_id', $hasil->quiz_id)
                ->where(function($query) use ($hasil) {
                    $query->where('bobot_diperoleh', '>', $hasil->bobot_diperoleh)
                        ->orWhere(function($subQuery) use ($hasil) {
                            $subQuery->where('bobot_diperoleh', '=', $hasil->bobot_diperoleh)
                                    ->where('waktu_pengerjaan', '<', $hasil->waktu_pengerjaan);
                        });
                })
                ->count() + 1;

            // Total peserta
            $totalPeserta = HasilUjian::where('quiz_id', $hasil->quiz_id)->count();

            // Grup detail berdasarkan tipe soal untuk analisis
            $detailByType = $hasil->detail->groupBy(function($item) {
                return $item->soal->tipe;
            });

            return view('backend.hasil.detail_admin', compact(
                'hasil', 
                'ranking', 
                'totalPeserta', 
                'detailByType'
            ));
            
        } catch (\Exception $e) {
            Log::error('Error in detailHasilAdmin: ' . $e->getMessage());
            
            return redirect()->route('quiz.hasil.keseluruhan')
                ->with('error', 'Hasil quiz tidak ditemukan atau terjadi kesalahan.');
        }
    }
   
    /**
    * Hapus hasil quiz dan semua detail jawaban terkait
    */
    public function hapusHasil($hasilId)
    {
        $user = Auth::user();
        
        // Debug log
        Log::info('hapusHasil called', [
            'hasil_id' => $hasilId,
            'user_id' => $user ? $user->id : 'null',
            'user_admin' => $user ? $user->isAdmin : 'null'
        ]);
        
        // Cek apakah user adalah admin
        if (!$user || ($user->isAdmin != 1 && $user->isAdmin != 2)) {
            Log::warning('Access denied in hapusHasil', ['user_id' => $user ? $user->id : 'null']);
            
            return redirect()->route('dashboard')
                ->with('error', 'Akses ditolak. Hanya admin yang dapat menghapus hasil quiz.');
        }

        try {
            // Ambil hasil ujian dengan memastikan quiz milik admin yang login
            $hasil = HasilUjian::with(['quiz', 'user', 'detail'])
                ->whereHas('quiz', function($query) {
                    $query->where('user_id', Auth::id());
                })
                ->findOrFail($hasilId);

            Log::info('Found hasil ujian', [
                'hasil_id' => $hasil->id,
                'quiz_title' => $hasil->quiz->judul_quiz,
                'user_name' => $hasil->user->name,
                'detail_count' => $hasil->detail->count()
            ]);

            DB::beginTransaction();

            // Simpan info untuk pesan sukses
            $pesertaNama = $hasil->user->name;
            $quizJudul = $hasil->quiz->judul_quiz;

            // Hapus semua detail jawaban terlebih dahulu
            $deletedDetails = $hasil->detail()->delete();
            Log::info('Deleted detail count', ['count' => $deletedDetails]);

            // Hapus hasil ujian
            $hasil->delete();
            Log::info('Deleted hasil ujian', ['hasil_id' => $hasilId]);

            DB::commit();

            Log::info('Successfully deleted quiz result', [
                'hasil_id' => $hasilId,
                'peserta' => $pesertaNama,
                'quiz' => $quizJudul
            ]);

            // Redirect dengan session success
            return redirect()->route('quiz.hasil.keseluruhan')
                ->with('success', "Hasil quiz '{$quizJudul}' dari peserta '{$pesertaNama}' berhasil dihapus.")
                ->with('alert_type', 'success'); // Extra session untuk debugging

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Quiz result not found', [
                'hasil_id' => $hasilId,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);
            
            return redirect()->route('quiz.hasil.keseluruhan')
                ->with('error', 'Hasil quiz tidak ditemukan atau Anda tidak memiliki akses untuk menghapusnya.')
                ->with('alert_type', 'error');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('Error deleting quiz result', [
                'hasil_id' => $hasilId,
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('quiz.hasil.keseluruhan')
                ->with('error', 'Terjadi kesalahan saat menghapus hasil quiz: ' . $e->getMessage())
                ->with('alert_type', 'error');
        }
    }

        /**
    * Tampilkan form penilaian untuk multiple essays dari satu user
    */
    public function gradeUserEssays($userId)
    {
        $user = Auth::user();
        
        if (!$user || ($user->isAdmin != 1 && $user->isAdmin != 2)) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda perlu login sebagai admin.');
        }

        try {
            // Get all pending essays from the specified user
            $userEssays = HasilUjianDetail::with(['hasilUjian.user', 'hasilUjian.quiz', 'soal'])
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

            if ($userEssays->isEmpty()) {
                return redirect()->route('quiz.essay.grading')
                    ->with('info', 'Tidak ada esai yang perlu dinilai untuk user ini.');
            }

            // Get the first essay for the view
            $essayDetail = $userEssays->first();
            
            return view('backend.penilaianesai.grade_multiple', compact('userEssays', 'essayDetail'));
            
        } catch (\Exception $e) {
            Log::error('Error in gradeUserEssays: ' . $e->getMessage());
            
            return redirect()->route('quiz.essay.grading')
                ->with('error', 'Terjadi kesalahan saat memuat halaman penilaian.');
        }
    }

    /**
     * Simpan penilaian untuk multiple essays
     */
    public function gradeMultipleEssay(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || ($user->isAdmin != 1 && $user->isAdmin != 2)) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda perlu login sebagai admin untuk melakukan penilaian.');
        }

        try {
            $validated = $request->validate([
                'grades' => 'required|array',
                'grades.*.detail_id' => 'required|integer|exists:hasil_ujian_details,id',
                'grades.*.bobot_diperoleh' => 'required|numeric|min:0',
                'grades.*.status_jawaban' => 'required|in:benar,salah,sebagian',
                'grades.*.feedback' => 'nullable|string|max:1000',
            ]);

            DB::beginTransaction();

            $updatedExams = [];

            foreach ($validated['grades'] as $gradeData) {
                $essayDetail = HasilUjianDetail::with('hasilUjian.quiz')
                    ->whereHas('hasilUjian.quiz', function($query) {
                        $query->where('user_id', Auth::id());
                    })
                    ->findOrFail($gradeData['detail_id']);

                // Validasi bobot maksimal
                if ($gradeData['bobot_diperoleh'] > $essayDetail->bobot_soal) {
                    throw new \Exception("Bobot untuk detail ID {$gradeData['detail_id']} melebihi bobot soal.");
                }

                $essayDetail->update([
                    'bobot_diperoleh' => $gradeData['bobot_diperoleh'],
                    'status_jawaban' => $gradeData['status_jawaban'],
                    'feedback' => $gradeData['feedback'] ?? null,
                ]);

                // Kumpulkan ID hasil ujian yang perlu dihitung ulang
                $updatedExams[] = $essayDetail->hasil_ujian_id;
            }

            // Hitung ulang skor untuk setiap hasil ujian yang terpengaruh
            foreach (array_unique($updatedExams) as $examId) {
                $this->recalculateExamScore($examId);
            }

            DB::commit();

            return redirect()->route('quiz.essay.grading')
                ->with('success', count($validated['grades']) . ' jawaban esai berhasil dinilai dan skor telah diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error grading multiple essays: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan form penilaian untuk single essay
     */
    public function gradeEssay($detailId)
    {
        $user = Auth::user();
        
        if (!$user || ($user->isAdmin != 1 && $user->isAdmin != 2)) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda perlu login sebagai admin.');
        }

        try {
            $essayDetail = HasilUjianDetail::with(['hasilUjian.user', 'hasilUjian.quiz', 'soal'])
                ->whereHas('hasilUjian.quiz', function($query) {
                    $query->where('user_id', Auth::id());
                })
                ->findOrFail($detailId);

            // Pastikan ini adalah soal essay yang pending
            if ($essayDetail->soal->tipe !== 'essay') {
                return redirect()->route('quiz.essay.grading')
                    ->with('error', 'Soal yang dipilih bukan tipe essay.');
            }

            if ($essayDetail->status_jawaban !== 'pending') {
                return redirect()->route('quiz.essay.grading')
                    ->with('info', 'Esai ini sudah dinilai sebelumnya.');
            }

            return view('backend.penilaianesai.grade_single', compact('essayDetail'));
            
        } catch (\Exception $e) {
            Log::error('Error in gradeEssay: ' . $e->getMessage());
            
            return redirect()->route('quiz.essay.grading')
                ->with('error', 'Esai tidak ditemukan atau terjadi kesalahan.');
        }
    }

    /**
     * Mass grading untuk soal tertentu (optional - untuk future use)
     */
    public function massGradeEssay($soalId)
    {
        $user = Auth::user();
        
        if (!$user || ($user->isAdmin != 1 && $user->isAdmin != 2)) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda perlu login sebagai admin.');
        }

        try {
            $soal = \App\Models\Soal::with('quiz')->findOrFail($soalId);
            
            // Pastikan soal milik admin yang login
            if ($soal->quiz->user_id !== Auth::id()) {
                return redirect()->route('quiz.essay.grading')
                    ->with('error', 'Anda tidak memiliki akses untuk menilai soal ini.');
            }

            // Get all pending answers for this question
            $essayAnswers = HasilUjianDetail::with(['hasilUjian.user', 'hasilUjian.quiz'])
                ->where('soal_id', $soalId)
                ->where('status_jawaban', 'pending')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('backend.penilaianesai.mass_grade', compact('soal', 'essayAnswers'));
            
        } catch (\Exception $e) {
            Log::error('Error in massGradeEssay: ' . $e->getMessage());
            
            return redirect()->route('quiz.essay.grading')
                ->with('error', 'Soal tidak ditemukan atau terjadi kesalahan.');
        }
    }
}