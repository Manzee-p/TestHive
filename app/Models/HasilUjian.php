<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HasilUjian extends Model
{
    use HasFactory;

    protected $table = 'hasil_ujians';

    protected $fillable = [
        'user_id',
        'quiz_id',
        'skor',
        'jumlah_benar',
        'jumlah_salah',
        'total_bobot',
        'bobot_diperoleh',
        'waktu_pengerjaan',
        'tanggal_ujian',
    ];

    protected $casts = [
        'skor' => 'decimal:2',
        'waktu_pengerjaan' => 'decimal:2',
        'tanggal_ujian' => 'date',
        'jumlah_benar' => 'integer',
        'jumlah_salah' => 'integer',
        'total_bobot' => 'integer',
        'bobot_diperoleh' => 'decimal:2', // *** UBAH: Support decimal untuk essay grading ***
    ];

    /**
     * Relasi ke model User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Quiz
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Relasi ke model HasilUjianDetail
     */
    public function detail(): HasMany
    {
        return $this->hasMany(HasilUjianDetail::class);
    }

    /**
     * Scope untuk mencari hasil ujian berdasarkan quiz
     */
    public function scopeByQuiz($query, $quizId)
    {
        return $query->where('quiz_id', $quizId);
    }

    /**
     * Scope untuk mencari hasil ujian berdasarkan user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope untuk mengurutkan berdasarkan ranking (bobot tertinggi, waktu tercepat)
     */
    public function scopeRanking($query)
    {
        return $query->orderBy('bobot_diperoleh', 'desc')
                    ->orderBy('waktu_pengerjaan', 'asc');
    }

    // *** TAMBAHAN BARU: Scope methods untuk sistem penilaian esai ***

    /**
     * Scope untuk hasil ujian yang memiliki soal esai
     */
    public function scopeWithEssayQuestions($query)
    {
        return $query->whereHas('quiz.soals', function($q) {
            $q->where('tipe', 'essay');
        });
    }

    /**
     * Scope untuk hasil ujian dengan esai yang belum dinilai
     */
    public function scopeWithPendingEssays($query)
    {
        return $query->whereHas('detail', function($q) {
            $q->whereHas('soal', function($subQ) {
                $subQ->where('tipe', 'essay');
            })->where('status_jawaban', 'pending');
        });
    }

    /**
     * Scope untuk hasil ujian dari quiz milik user tertentu
     */
    public function scopeByQuizOwner($query, $userId)
    {
        return $query->whereHas('quiz', function($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    /**
     * Accessor untuk mendapatkan persentase skor
     */
    public function getPersentaseSkorAttribute()
    {
        return $this->skor . '%';
    }

    /**
     * Accessor untuk mendapatkan waktu pengerjaan dalam format yang mudah dibaca
     */
    public function getWaktuPengerjaanFormattedAttribute()
    {
        $menit = floor($this->waktu_pengerjaan);
        $detik = round(($this->waktu_pengerjaan - $menit) * 60);
        
        return $menit . ' menit ' . $detik . ' detik';
    }

    /**
     * Accessor untuk mendapatkan status lulus/tidak lulus
     * (Anda bisa menyesuaikan batas kelulusan sesuai kebutuhan)
     */
    public function getStatusKelulusanAttribute()
    {
        $batasLulus = 60; // Batas kelulusan 60%
        return $this->skor >= $batasLulus ? 'Lulus' : 'Tidak Lulus';
    }

    // *** TAMBAHAN BARU: Accessor untuk sistem penilaian esai ***

    /**
     * Accessor untuk status kelulusan dengan badge
     */
    public function getStatusKelulusanBadgeAttribute()
    {
        $status = $this->status_kelulusan;
        $badgeClass = $status === 'Lulus' ? 'bg-success' : 'bg-danger';
        $icon = $status === 'Lulus' ? 'fas fa-check' : 'fas fa-times';
        
        return "<span class=\"badge {$badgeClass}\"><i class=\"{$icon}\"></i> {$status}</span>";
    }

    /**
     * Accessor untuk mendapatkan info esai
     */
    public function getEssayInfoAttribute()
    {
        $essayDetails = $this->detail()->whereHas('soal', function($q) {
            $q->where('tipe', 'essay');
        })->get();

        $total = $essayDetails->count();
        $graded = $essayDetails->where('status_jawaban', '!=', 'pending')->count();
        $pending = $total - $graded;

        return [
            'total' => $total,
            'graded' => $graded,
            'pending' => $pending,
            'has_essays' => $total > 0,
            'all_graded' => $pending === 0,
            'progress_percentage' => $total > 0 ? round(($graded / $total) * 100, 1) : 0
        ];
    }

    /**
     * Method untuk mendapatkan ranking peserta dalam quiz tertentu
     */
    public function getRanking()
    {
        return self::where('quiz_id', $this->quiz_id)
            ->where(function($query) {
                $query->where('bobot_diperoleh', '>', $this->bobot_diperoleh)
                    ->orWhere(function($subQuery) {
                        $subQuery->where('bobot_diperoleh', '=', $this->bobot_diperoleh)
                                ->where('waktu_pengerjaan', '<', $this->waktu_pengerjaan);
                    });
            })
            ->count() + 1;
    }

    /**
     * Method untuk mendapatkan total peserta dalam quiz
     */
    public function getTotalPeserta()
    {
        return self::where('quiz_id', $this->quiz_id)->count();
    }

    /**
     * Method untuk mendapatkan top performers dalam quiz
     */
    public static function getTopPerformers($quizId, $limit = 10)
    {
        return self::with('user')
            ->where('quiz_id', $quizId)
            ->ranking()
            ->take($limit)
            ->get();
    }

    // *** TAMBAHAN BARU: Helper methods untuk sistem penilaian esai ***

    /**
     * Check apakah hasil ujian ini memiliki soal esai
     */
    public function hasEssayQuestions()
    {
        return $this->essay_info['has_essays'];
    }

    /**
     * Check apakah semua esai sudah dinilai
     */
    public function allEssaysGraded()
    {
        return $this->essay_info['all_graded'];
    }

    /**
     * Get jumlah esai yang belum dinilai
     */
    public function getPendingEssayCount()
    {
        return $this->essay_info['pending'];
    }

    /**
     * Get progress penilaian esai dalam persentase
     */
    public function getEssayGradingProgress()
    {
        return $this->essay_info['progress_percentage'];
    }

    /**
     * Method untuk mendapatkan detail esai yang belum dinilai
     */
    public function getPendingEssayDetails()
    {
        return $this->detail()
            ->with(['soal'])
            ->whereHas('soal', function($q) {
                $q->where('tipe', 'essay');
            })
            ->where('status_jawaban', 'pending')
            ->get();
    }

    /**
     * Method untuk mendapatkan semua detail esai
     */
    public function getAllEssayDetails()
    {
        return $this->detail()
            ->with(['soal'])
            ->whereHas('soal', function($q) {
                $q->where('tipe', 'essay');
            })
            ->get();
    }

    /**
     * Method untuk recalculate skor setelah penilaian esai
     */
    public function recalculateScore()
    {
        $details = $this->detail()->get();
        
        $totalBobot = 0;
        $bobotDiperoleh = 0;
        $jawabanBenar = 0;
        $jawabanSalah = 0;

        foreach ($details as $detail) {
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
        $this->update([
            'skor' => $skor,
            'jumlah_benar' => $jawabanBenar,
            'jumlah_salah' => $jawabanSalah,
            'total_bobot' => $totalBobot,
            'bobot_diperoleh' => round($bobotDiperoleh, 2),
        ]);

        return $this->fresh();
    }

    /**
     * Method untuk mendapatkan statistik lengkap hasil ujian
     */
    public function getFullStats()
    {
        $essayInfo = $this->essay_info;
        
        return [
            'basic' => [
                'skor' => $this->skor,
                'persentase_skor' => $this->persentase_skor,
                'status_kelulusan' => $this->status_kelulusan,
                'status_kelulusan_badge' => $this->status_kelulusan_badge,
                'waktu_pengerjaan' => $this->waktu_pengerjaan_formatted,
                'ranking' => $this->getRanking(),
                'total_peserta' => $this->getTotalPeserta(),
            ],
            'scoring' => [
                'jumlah_benar' => $this->jumlah_benar,
                'jumlah_salah' => $this->jumlah_salah,
                'total_bobot' => $this->total_bobot,
                'bobot_diperoleh' => $this->bobot_diperoleh,
            ],
            'essay' => $essayInfo,
            'quiz_info' => [
                'id' => $this->quiz_id,
                'judul' => $this->quiz->judul_quiz ?? null,
                'kode' => $this->quiz->kode_quiz ?? null,
            ]
        ];
    }
}