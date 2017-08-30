<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planificacionfumigacion extends Model
{
    protected $table = 'planificacionfumigacions';
    protected $fillable = [
        'numero_alerta', 'fecha_planificacion', 'estado', 'fumigacion_id',
    ];
    function fumigacion(){
        return $this->belongsTo('App\Fumigacion');
    }
}
