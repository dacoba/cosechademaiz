<?php

namespace App;

use Jenssegers\Date\Date;
use Illuminate\Database\Eloquent\Model;

class Planificacionfumigacion extends Model
{
    protected $table = 'planificacionfumigacions';
    protected $fillable = [
        'numero_alerta', 'fecha_planificacion', 'estado', 'preventivo_plagas', 'control_rutinario', 'control_malezas', 'control_insectos', 'control_enfermedades', 'comentario_fumigacion', 'fumigacion_id',
    ];
    function fumigacion(){
        return $this->belongsTo('App\Fumigacion');
    }
    function simulador()
    {
        return $this->hasOne('App\Simulador');
    }
    public function getFechaPlanificacionAttribute($date)
    {
        return new Date($date);
    }
}
