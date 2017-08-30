<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siembra extends Model
{
    protected $table = 'cosechas';
    protected $fillable = [
        'problemas_produccion', 'altura_tallo', 'humedad_terreno', 'rendimiento_produccion', 'comentario_cosecha', 'siembra_id',
    ];
    function siembra(){
        return $this->belongsTo('App\Siembra');
    }
}
