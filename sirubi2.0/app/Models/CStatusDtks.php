<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CStatusDtks extends Model
{
    protected $table = 'c_status_dtks';
    protected $primaryKey = 'id_status_dtks';
    protected $fillable = ['id_status_dtks', 'status_dtks'];
    public $timestamps = false;

    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'status_dtks_id', 'id_status_dtks');
    }
}
