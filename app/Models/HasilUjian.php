<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HasilUjian extends Model
{
    protected $fillable = [
        'user_id', 'quiz_id', 'skor', 'jumlah_benar', 'jumlah_salah',
        'total_bobot', 'bobot_diperoleh', 'waktu_pengerjaan', 'tanggal_ujian'
    ];

    protected $casts = [
        'tanggal_ujian' => 'date',
        'skor' => 'decimal:2',
        'waktu_pengerjaan' => 'decimal:2',
        'bobot_diperoleh' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function detail(): HasMany
    {
        return $this->hasMany(HasilUjianDetail::class);
    }
}