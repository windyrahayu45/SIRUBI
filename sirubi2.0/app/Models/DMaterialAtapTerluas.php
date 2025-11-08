<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DMaterialAtapTerluas extends Model
{
    protected $table = 'd_material_atap_terluas';
    protected $primaryKey ='id_material_atap_terluas';
    protected $fillable = ['id_material_atap_terluas', 'material_atap_terluas'];
    public $timestamps = false;
    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'material_atap_terluas_id', 'id_material_atap_terluas');
    }
}
