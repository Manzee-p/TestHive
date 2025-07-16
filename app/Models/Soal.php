<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $fillable = [
        'quiz_id',
        'tipe',
        'pertanyaan',
        'pilihan_a',
        'pilihan_b',
        'pilihan_c',
        'pilihan_d',
        'pilihan_e',
        'pilihan_f',
        'pilihan_g',
        'pilihan_h',
        'pilihan_i',
        'pilihan_j',
        'jawaban_benar',
        'bobot',
    ];

    protected $casts = [
        'bobot' => 'integer',
    ];

    /**
     * Relationships
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // *** TAMBAHAN BARU: Relationship ke HasilUjianDetail ***
    public function hasilUjianDetails()
    {
        return $this->hasMany(HasilUjianDetail::class);
    }

    // *** TAMBAHAN BARU: Scope methods ***

    /**
     * Scope untuk soal berdasarkan tipe
     */
    public function scopeByType($query, $type)
    {
        return $query->where('tipe', $type);
    }

    /**
     * Scope untuk soal esai
     */
    public function scopeEssayQuestions($query)
    {
        return $query->where('tipe', 'essay');
    }

    /**
     * Scope untuk soal pilihan ganda
     */
    public function scopeMultipleChoiceQuestions($query)
    {
        return $query->where('tipe', 'pilihan_ganda');
    }

    /**
     * Scope untuk soal benar/salah
     */
    public function scopeTrueFalseQuestions($query)
    {
        return $query->where('tipe', 'benar_salah');
    }

    /**
     * Scope untuk soal checkbox
     */
    public function scopeCheckboxQuestions($query)
    {
        return $query->where('tipe', 'checkbox');
    }

    // *** TAMBAHAN BARU: Accessor methods ***

    /**
     * Accessor untuk tipe soal dengan badge
     */
    public function getTipeBadgeAttribute()
    {
        $badges = [
            'essay' => '<span class="badge bg-info"><i class="fas fa-edit"></i> Essay</span>',
            'pilihan_ganda' => '<span class="badge bg-primary"><i class="fas fa-list"></i> Pilihan Ganda</span>',
            'benar_salah' => '<span class="badge bg-warning"><i class="fas fa-check"></i> Benar/Salah</span>',
            'checkbox' => '<span class="badge bg-success"><i class="fas fa-check-square"></i> Checkbox</span>',
        ];

        return $badges[$this->tipe] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    /**
     * Accessor untuk info jawaban esai jika ini soal esai
     */
    public function getEssayAnswerInfoAttribute()
    {
        if ($this->tipe !== 'essay') {
            return null;
        }

        $answers = $this->hasilUjianDetails()->get();
        $totalAnswers = $answers->count();
        $pendingAnswers = $answers->where('status_jawaban', 'pending')->count();
        $gradedAnswers = $totalAnswers - $pendingAnswers;

        return [
            'total_answers' => $totalAnswers,
            'pending_answers' => $pendingAnswers,
            'graded_answers' => $gradedAnswers,
            'progress_percentage' => $totalAnswers > 0 ? round(($gradedAnswers / $totalAnswers) * 100, 1) : 0,
        ];
    }

    // *** TAMBAHAN BARU: Helper methods ***

    /**
     * Check apakah ini soal esai
     */
    public function isEssayQuestion()
    {
        return $this->tipe === 'essay';
    }

    /**
     * Check apakah ini soal pilihan ganda
     */
    public function isMultipleChoiceQuestion()
    {
        return $this->tipe === 'pilihan_ganda';
    }

    /**
     * Check apakah ini soal benar/salah
     */
    public function isTrueFalseQuestion()
    {
        return $this->tipe === 'benar_salah';
    }

    /**
     * Check apakah ini soal checkbox
     */
    public function isCheckboxQuestion()
    {
        return $this->tipe === 'checkbox';
    }

    /**
     * Get pilihan jawaban untuk soal pilihan ganda
     */
    public function getChoiceOptions()
    {
        if (!$this->isMultipleChoiceQuestion()) {
            return [];
        }

        $options = [];
        $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        
        foreach ($letters as $letter) {
            $field = 'pilihan_' . strtolower($letter);
            if (!empty($this->$field)) {
                $options[$letter] = $this->$field;
            }
        }

        return $options;
    }

    /**
     * Get jumlah jawaban yang belum dinilai untuk soal esai ini
     */
    public function getPendingEssayAnswersCount()
    {
        if (!$this->isEssayQuestion()) {
            return 0;
        }

        return $this->hasilUjianDetails()
            ->where('status_jawaban', 'pending')
            ->count();
    }

    /**
     * Get detail jawaban esai yang belum dinilai
     */
    public function getPendingEssayAnswers()
    {
        if (!$this->isEssayQuestion()) {
            return collect();
        }

        return $this->hasilUjianDetails()
            ->with(['hasilUjian.user'])
            ->where('status_jawaban', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Check apakah soal ini memiliki kunci jawaban
     */
    public function hasAnswerKey()
    {
        return !empty($this->jawaban_benar);
    }

    /**
     * Get formatted answer key
     */
    public function getFormattedAnswerKey()
    {
        if (!$this->hasAnswerKey()) {
            return null;
        }

        switch ($this->tipe) {
            case 'pilihan_ganda':
            case 'benar_salah':
                return $this->jawaban_benar;
            
            case 'checkbox':
                return explode(',', $this->jawaban_benar);
            
            case 'essay':
                return $this->jawaban_benar; // Bisa berupa rubrik atau contoh jawaban
            
            default:
                return $this->jawaban_benar;
        }
    }
}