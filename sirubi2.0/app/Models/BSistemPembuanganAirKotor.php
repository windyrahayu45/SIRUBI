<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BSistemPembuanganAirKotor extends Model
{
    protected $table = 'b_sistem_pembuangan_air_kotor';
    protected $primaryKey = 'id_sistem_pembuangan_air_kotor';
    protected $fillable = ['id_sistem_pembuangan_air_kotor', 'sistem_pembuangan_air_kotor'];
    public $timestamps = false;

    // ==================================================================================
    public function sanitasiRumah()
    {
        return $this->hasMany(SanitasiRumah::class, 'sistem_pembuangan_air_kotor_id', 'id_sistem_pembuangan_air_kotor');
    }
}
