<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IBuktiKepemilikanTanah extends Model
{
    protected $table = 'i_bukti_kepemilikan_tanah';
    protected $primaryKey = 'id_bukti_kepemilikan_tanah';
    protected $fillable = ['id_bukti_kepemilikan_tanah', 'bukti_kepemilikan_tanah'];
    public $timestamps = false;

    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'bukti_kepemilikan_tanah_id', 'id_bukti_kepemilikan_tanah');
    }
}
