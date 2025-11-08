<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CTipeRumah extends Model
{
    protected $table = 'c_tipe_rumah';
    protected $primaryKey = 'id_tipe_rumah';
    protected $fillable = ['id_tipe_rumah', 'tipe_rumah'];
    public $timestamps = false;

    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'tipe_rumah_id', 'id_tipe_rumah');
    }
}
