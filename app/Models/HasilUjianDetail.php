<?php

// ==============================================
// FILE: app/Models/HasilUjianDetail.php
// ==============================================

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilUjianDetail extends Model
{
    use HasFactory;

    protected $table = 'hasil_ujian_details';

    protected $fillable = [
        'hasil_ujian_id',
        'soal_id',
        'jawaban_peserta',
        'status_jawaban',
        'bobot_soal',
        'bobot_diperoleh',
        'feedback', // *** TAMBAHAN BARU: Kolom untuk feedback penilaian esai ***
    ];

    protected $casts = [
        'bobot_soal' => 'integer',
        'bobot_diperoleh' => 'decimal:2', // Ubah ke decimal untuk mendukung nilai pecahan
    ];

    /**
     * Relasi ke model HasilUjian
     */
    public function hasilUjian(): BelongsTo
    {
        return $this->belongsTo(HasilUjian::class);
    }

    /**
     * Relasi ke model Soal
     */
    public function soal(): BelongsTo
    {
        return $this->belongsTo(Soal::class);
    }

    /**
     * Scope untuk mencari detail berdasarkan hasil ujian
     */
    public function scopeByHasilUjian($query, $hasilUjianId)
    {
        return $query->where('hasil_ujian_id', $hasilUjianId);
    }

    /**
     * Scope untuk mencari detail berdasarkan status jawaban
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status_jawaban', $status);
    }

    /**
     * Scope untuk jawaban yang benar
     */
    public function scopeBenar($query)
    {
        return $query->where('status_jawaban', 'benar');
    }

    /**
     * Scope untuk jawaban yang salah
     */
    public function scopeSalah($query)
    {
        return $query->where('status_jawaban', 'salah');
    }

    /**
     * Scope untuk jawaban yang sebagian benar
     */
    public function scopeSebagian($query)
    {
        return $query->where('status_jawaban', 'sebagian');
    }

    /**
     * Scope untuk jawaban yang pending (essay)
     */
    public function scopePending($query)
    {
        return $query->where('status_jawaban', 'pending');
    }

    /**
     * Scope untuk jawaban yang tidak dijawab
     */
    public function scopeTidakDijawab($query)
    {
        return $query->where('status_jawaban', 'tidak dijawab');
    }

    // *** TAMBAHAN BARU: Scope methods untuk sistem penilaian esai ***

    /**
     * Scope untuk filter berdasarkan tipe soal
     */
    public function scopeByQuestionType($query, $type)
    {
        return $query->whereHas('soal', function($q) use ($type) {
            $q->where('tipe', $type);
        });
    }

    /**
     * Scope untuk filter soal esai yang belum dinilai
     */
    public function scopePendingEssays($query)
    {
        return $query->whereHas('soal', function($q) {
            $q->where('tipe', 'essay');
        })->where('status_jawaban', 'pending');
    }

    /**
     * Scope untuk filter berdasarkan quiz milik user tertentu
     */
    public function scopeByQuizOwner($query, $userId)
    {
        return $query->whereHas('hasilUjian.quiz', function($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    /**
     * Scope untuk jawaban yang sudah dinilai
     */
    public function scopeGraded($query)
    {
        return $query->whereIn('status_jawaban', ['benar', 'salah', 'sebagian']);
    }

    /**
     * Accessor untuk mendapatkan jawaban peserta dalam format yang mudah dibaca
     */
    public function getJawabanPesertaFormattedAttribute()
    {
        if (empty($this->jawaban_peserta)) {
            return 'Tidak dijawab';
        }

        // Jika jawaban berupa pilihan ganda yang dipisahkan koma (checkbox)
        if (strpos($this->jawaban_peserta, ',') !== false) {
            $jawaban = explode(',', $this->jawaban_peserta);
            return implode(', ', array_map('trim', $jawaban));
        }

        return $this->jawaban_peserta;
    }

    /**
     * Accessor untuk mendapatkan status jawaban dengan warna
     */
    public function getStatusJawabanBadgeAttribute()
    {
        switch ($this->status_jawaban) {
            case 'benar':
                return '<span class="badge bg-success"><i class="fas fa-check"></i> Benar</span>';
            case 'salah':
                return '<span class="badge bg-danger"><i class="fas fa-times"></i> Salah</span>';
            case 'sebagian':
                return '<span class="badge bg-warning"><i class="fas fa-minus"></i> Sebagian Benar</span>';
            case 'pending':
                return '<span class="badge bg-info"><i class="fas fa-clock"></i> Belum Dinilai</span>';
            case 'tidak dijawab':
                return '<span class="badge bg-secondary"><i class="fas fa-ban"></i> Tidak Dijawab</span>';
            default:
                return '<span class="badge bg-secondary">Unknown</span>';
        }
    }

    /**
     * Accessor untuk mendapatkan persentase bobot
     */
    public function getPersentaseBobotAttribute()
    {
        if ($this->bobot_soal == 0) {
            return 0;
        }
        return round(($this->bobot_diperoleh / $this->bobot_soal) * 100, 2);
    }

    // *** TAMBAHAN BARU: Accessor untuk sistem penilaian esai ***

    /**
     * Accessor untuk persentase skor (alias untuk konsistensi)
     */
    public function getPercentageAttribute()
    {
        return $this->persentase_bobot;
    }

    /**
     * Accessor untuk warna berdasarkan persentase
     */
    public function getPercentageColorAttribute()
    {
        $percentage = $this->percentage;
        
        if ($percentage >= 80) {
            return 'success';
        } elseif ($percentage >= 60) {
            return 'warning';
        } else {
            return 'danger';
        }
    }

    /**
     * Accessor untuk icon berdasarkan status
     */
    public function getStatusIconAttribute()
    {
        switch ($this->status_jawaban) {
            case 'benar':
                return 'fas fa-check-circle text-success';
            case 'salah':
                return 'fas fa-times-circle text-danger';
            case 'sebagian':
                return 'fas fa-minus-circle text-warning';
            case 'pending':
                return 'fas fa-clock text-info';
            case 'tidak dijawab':
                return 'fas fa-ban text-secondary';
            default:
                return 'fas fa-question-circle text-muted';
        }
    }

    /**
     * Get feedback dengan format yang aman untuk HTML
     */
    public function getSafeFeedbackAttribute()
    {
        return $this->feedback ? nl2br(e($this->feedback)) : null;
    }

    /**
     * Accessor untuk status badge dengan style Bootstrap 5
     */
    public function getStatusBadgeAttribute()
    {
        return $this->status_jawaban_badge; // Menggunakan accessor yang sudah ada
    }

    /**
     * Method untuk mengecek apakah jawaban benar
     */
    public function isCorrect()
    {
        return $this->status_jawaban === 'benar';
    }

    /**
     * Method untuk mengecek apakah jawaban salah
     */
    public function isIncorrect()
    {
        return $this->status_jawaban === 'salah';
    }

    /**
     * Method untuk mengecek apakah jawaban sebagian benar
     */
    public function isPartiallyCorrect()
    {
        return $this->status_jawaban === 'sebagian';
    }

    /**
     * Method untuk mengecek apakah jawaban pending
     */
    public function isPending()
    {
        return $this->status_jawaban === 'pending';
    }

    /**
     * Method untuk mengecek apakah tidak dijawab
     */
    public function isNotAnswered()
    {
        return $this->status_jawaban === 'tidak dijawab';
    }

    // *** TAMBAHAN BARU: Helper methods untuk sistem penilaian esai ***

    /**
     * Check apakah jawaban memiliki feedback
     */
    public function hasFeedback()
    {
        return !empty($this->feedback);
    }

    /**
     * Check apakah ini adalah soal esai
     */
    public function isEssayQuestion()
    {
        return $this->soal && $this->soal->tipe === 'essay';
    }

    /**
     * Get formatted feedback untuk tampilan
     */
    public function getFormattedFeedback()
    {
        if (!$this->hasFeedback()) {
            return null;
        }

        return [
            'text' => $this->feedback,
            'safe_html' => $this->safe_feedback,
            'has_content' => true
        ];
    }

    /**
     * Method untuk mendapatkan info lengkap jawaban
     */
    public function getAnswerInfo()
    {
        return [
            'jawaban' => $this->jawaban_peserta_formatted,
            'status' => $this->status_jawaban,
            'status_badge' => $this->status_badge,
            'status_icon' => $this->status_icon,
            'bobot_soal' => $this->bobot_soal,
            'bobot_diperoleh' => $this->bobot_diperoleh,
            'persentase' => $this->percentage,
            'persentase_color' => $this->percentage_color,
            'feedback' => $this->getFormattedFeedback(),
            'is_essay' => $this->isEssayQuestion(),
            'is_pending' => $this->isPending(),
        ];
    }
}