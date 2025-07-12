<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilUjianDetail extends Model
{
    protected $fillable = [
        'hasil_ujian_id', 'soal_id', 'jawaban_peserta', 'status_jawaban',
        'skor_essay', 'feedback'
    ];

    protected $casts = [
        'skor_essay' => 'decimal:2'
    ];

    public function hasilUjian(): BelongsTo
    {
        return $this->belongsTo(HasilUjian::class);
    }

    public function soal(): BelongsTo
    {
        return $this->belongsTo(Soal::class);
    }
}