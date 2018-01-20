<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siembra extends Model
{
    protected $table = 'siembras';
    protected $fillable = [
        'semilla', 'fertilizacion', 'distancia_surco', 'distancia_planta', 'comentario_siembra', 'preparacionterreno_id',
    ];
    function preparacionterreno(){
        return $this->belongsTo('App\Preparacionterreno');
    }
    function riego()
    {
        return $this->hasOne('App\Riego');
    }
}
