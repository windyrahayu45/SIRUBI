<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DMaterialDindingTerluas extends Model
{
    protected $table = 'd_material_dinding_terluas';
    protected $primaryKey = 'id_material_dinding_terluas';
    protected $fillable = ['id_material_dinding_terluas', 'material_dinding_terluas'];
    public $timestamps = false;
    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'material_dinding_terluas_id', 'id_material_dinding_terluas');
    }
}
