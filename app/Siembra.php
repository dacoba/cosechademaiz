<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siembra extends Model
{
    protected $table = 'siembras';
    protected $fillable = [
        'semilla', 'fertilizacion', 'densidad_siembra', 'comentario_siembra', 'preparacionterreno_id',
    ];
    function preparacionterreno(){
        return $this->belongsTo('App\Preparacionterreno');
    }
}
