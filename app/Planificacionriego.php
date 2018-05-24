<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planificacionriego extends Model
{
    protected $table = 'planificacionriegos';
    protected $fillable = [
        'numero_alerta', 'fecha_planificacion', 'estado', 'metodos_riego', 'comportamiento_lluvia', 'problemas_drenaje', 'comentario_riego',  'riego_id',
    ];
    function riego(){
        return $this->belongsTo('App\Riego');
    }
    function simulador()
    {
        return $this->hasOne('App\Simulador');
    }
}
