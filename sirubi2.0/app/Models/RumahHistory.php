<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RumahHistory extends Model
{
    protected $table = 'rumah_history';

    public $timestamps = false; // kita pakai changed_at, bukan created_at/updated_at

    protected $fillable = [
        'rumah_id',
        'kategori',
        'field',
        'old_value',
        'new_value',
        'changed_by',
        'changed_at',
    ];

    protected $casts = [
        'changed_at' => 'datetime',
    ];

    // ============================
    // 🔗 Relasi
    // ============================

    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'rumah_id', 'id_rumah');
    }

   public function user()
    {
        return $this->belongsTo(User::class, 'changed_by', 'id');
    }
}
