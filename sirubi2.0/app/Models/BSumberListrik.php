<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BSumberListrik extends Model
{
    protected $table = 'b_sumber_listrik';
    protected $fillable = ['id_sumber_listrik', 'sumber_listrik'];
    public $timestamps = false;

     public function sanitasiRumah()
    {
        return $this->hasMany(SanitasiRumah::class, 'sumber_listrik_id', 'id_sumber_listrik');
    }
}
