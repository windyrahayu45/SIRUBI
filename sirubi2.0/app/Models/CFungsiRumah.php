<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CFungsiRumah extends Model
{
    protected $table = 'c_fungsi_rumah';
    protected $fillable = ['id_fungsi_rumah', 'fungsi_rumah'];
    public $timestamps = false;

    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'fungsi_rumah_id', 'id_fungsi_rumah');
    }
}
