<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IBesarPengeluaran extends Model
{
    protected $table = 'i_besar_pengeluaran';
    protected $primaryKey = 'id_besar_pengeluaran';
    protected $fillable = ['id_besar_pengeluaran', 'besar_pengeluaran'];
    public $timestamps = false;

    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'besar_pengeluaran_id', 'id_besar_pengeluaran');     
    }
}
