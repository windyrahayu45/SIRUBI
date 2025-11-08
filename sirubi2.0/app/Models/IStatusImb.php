<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IStatusImb extends Model
{
    protected $table = 'i_status_imb';
    protected $primaryKey = 'id_status_imb';
    protected $fillable = ['id_status_imb', 'status_imb'];
    public $timestamps = false;

    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'status_imb_id', 'id_status_imb');
    }
}
