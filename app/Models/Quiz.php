<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'judul_quiz',
        'deskripsi',
        'kode_quiz',
        'waktu_menit',
        'kategori_id',
        'mata_pelajaran_id',
        'user_id',
        'status_aktivasi',
        'tanggal_buat',
        'pengulangan_pekerjaan',
        'status',
    ];

    protected $casts = [
        'tanggal_buat' => 'datetime',
        'waktu_menit' => 'integer',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function soals()
    {
        return $this->hasMany(Soal::class);
    }

    public function hasilUjian()
    {
        return $this->hasMany(HasilUjian::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    // *** TAMBAHAN BARU: Relationships untuk sistem penilaian esai ***

    /**
     * Relationship ke HasilUjianDetail melalui HasilUjian
     */
    public function hasilUjianDetails()
    {
        return $this->hasManyThrough(HasilUjianDetail::class, HasilUjian::class);
    }

    // *** TAMBAHAN BARU: Scope methods ***

    /**
     * Scope untuk quiz yang memiliki soal esai
     */
    public function scopeWithEssayQuestions($query)
    {
        return $query->whereHas('soals', function($q) {
            $q->where('tipe', 'essay');
        });
    }

    /**
     * Scope untuk quiz milik user tertentu
     */
    public function scopeByOwner($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope untuk quiz yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status_aktivasi', 'aktif');
    }

    /**
     * Scope untuk quiz yang non-aktif
     */
    public function scopeInactive($query)
    {
        return $query->where('status_aktivasi', 'non aktif');
    }

    // *** TAMBAHAN BARU: Accessor methods ***

    /**
     * Accessor untuk mendapatkan info soal esai
     */
    public function getEssayInfoAttribute()
    {
        $essayQuestions = $this->soals()->where('tipe', 'essay')->get();
        $totalEssayQuestions = $essayQuestions->count();

        if ($totalEssayQuestions === 0) {
            return [
                'has_essays' => false,
                'total_questions' => 0,
                'total_answers' => 0,
                'pending_answers' => 0,
                'graded_answers' => 0,
                'progress_percentage' => 0,
            ];
        }

        // Hitung jawaban esai
        $essayAnswers = $this->hasilUjianDetails()
            ->whereHas('soal', function($q) {
                $q->where('tipe', 'essay');
            })
            ->get();

        $totalAnswers = $essayAnswers->count();
        $pendingAnswers = $essayAnswers->where('status_jawaban', 'pending')->count();
        $gradedAnswers = $totalAnswers - $pendingAnswers;
        $progressPercentage = $totalAnswers > 0 ? round(($gradedAnswers / $totalAnswers) * 100, 1) : 0;

        return [
            'has_essays' => true,
            'total_questions' => $totalEssayQuestions,
            'total_answers' => $totalAnswers,
            'pending_answers' => $pendingAnswers,
            'graded_answers' => $gradedAnswers,
            'progress_percentage' => $progressPercentage,
        ];
    }

    /**
     * Accessor untuk status aktivasi dengan badge
     */
    public function getStatusAktivasiBadgeAttribute()
    {
        $status = $this->status_aktivasi;
        $badgeClass = $status === 'aktif' ? 'bg-success' : 'bg-danger';
        $icon = $status === 'aktif' ? 'fas fa-check' : 'fas fa-times';
        
        return "<span class=\"badge {$badgeClass}\"><i class=\"{$icon}\"></i> " . ucfirst($status) . "</span>";
    }

    /**
     * Accessor untuk status dengan badge
     */
    public function getStatusBadgeAttribute()
    {
        $status = $this->status;
        $badgeClass = $status === 'Umum' ? 'bg-primary' : 'bg-secondary';
        $icon = $status === 'Umum' ? 'fas fa-globe' : 'fas fa-lock';
        
        return "<span class=\"badge {$badgeClass}\"><i class=\"{$icon}\"></i> {$status}</span>";
    }

    // *** TAMBAHAN BARU: Helper methods ***

    /**
     * Check apakah quiz memiliki soal esai
     */
    public function hasEssayQuestions()
    {
        return $this->essay_info['has_essays'];
    }

    /**
     * Get jumlah soal esai yang belum dinilai
     */
    public function getPendingEssayCount()
    {
        return $this->essay_info['pending_answers'];
    }

    /**
     * Get progress penilaian esai
     */
    public function getEssayGradingProgress()
    {
        return $this->essay_info['progress_percentage'];
    }

    /**
     * Check apakah quiz aktif
     */
    public function isActive()
    {
        return $this->status_aktivasi === 'aktif';
    }

    /**
     * Check apakah quiz adalah quiz umum
     */
    public function isPublic()
    {
        return $this->status === 'Umum';
    }

    /**
     * Get total soal
     */
    public function getTotalQuestions()
    {
        return $this->soals()->count();
    }

    /**
     * Get total peserta
     */
    public function getTotalParticipants()
    {
        return $this->hasilUjian()->count();
    }

    /**
     * Get soal esai yang belum dinilai untuk quiz ini
     */
    public function getPendingEssayDetails()
    {
        return $this->hasilUjianDetails()
            ->with(['hasilUjian.user', 'soal'])
            ->whereHas('soal', function($q) {
                $q->where('tipe', 'essay');
            })
            ->where('status_jawaban', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}