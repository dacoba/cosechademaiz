<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planificacionriego extends Model
{
    protected $table = 'planificacionriegos';
    protected $fillable = [
        'numero_alerta', 'fecha_planificacion', 'estado', 'riego_id',
    ];
    function riego(){
        return $this->belongsTo('App\Riego');
    }
}
