<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Simulador extends Model
{
    protected $table = 'simuladors';
    protected $fillable = [
        'numero_simulacion', 'problemas', 'altura', 'humedad', 'rendimiento', 'tipo', 'siembra_id', 'planificacionriego_id', 'planificacionfumigacion_id', 'preparacionterreno_id',
    ];
    function siembra(){
        return $this->belongsTo('App\Siembra');
    }
    function planificacionriego(){
        return $this->belongsTo('App\Planificacionriego');
    }
    function planificacionfumigacion(){
        return $this->belongsTo('App\Planificacionfumigacion');
    }
    function preparacionterreno(){
        return $this->belongsTo('App\Preparacionterreno');
    }
}
