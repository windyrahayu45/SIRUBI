<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DMaterialLantaiTerluas extends Model
{
    protected $table = 'd_material_lantai_terluas';
    protected $fillable = ['id_material_lantai_terluas', 'material_lantai_terluas'];
    public $timestamps = false;

    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'material_lantai_terluas_id', 'id_material_lantai_terluas');
    }
}
