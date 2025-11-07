<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IStatusKepemilikanRumah extends Model
{
    protected $table = 'i_status_kepemilikan_rumah';
    protected $fillable = ['id_status_kepemilikan_rumah', 'status_kepemilikan_rumah'];
    public $timestamps = false;

     public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'status_kepemilikan_rumah_id', 'id_status_kepemilikan_rumah');
    }
}
