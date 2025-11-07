<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IStatusKepemilikanTanah extends Model
{
    protected $table = 'i_status_kepemilikan_tanah';
    protected $fillable = ['id_status_kepemilikan_tanah', 'status_kepemilikan_tanah'];
    public $timestamps = false;

     public function statusKepemilikanTanah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'status_kepemilikan_tanah_id', 'id_status_kepemilikan_tanah');
    }
}
