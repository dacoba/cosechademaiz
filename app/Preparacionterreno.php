<?php

namespace App;

use Jenssegers\Date\Date;
use Illuminate\Database\Eloquent\Model;

class Preparacionterreno extends Model
{
    protected $table = 'preparacionterrenos';
    protected $fillable = [
        'ph', 'plaga_suelo', 'drenage', 'erocion', 'maleza_preparacion', 'comentario_preparacion', 'estado', 'terreno_id', 'tecnico_id',
    ];
    function terreno(){
        return $this->belongsTo('App\Terreno');
    }
    function tecnico(){
        return $this->belongsTo('App\User');
    }
    function siembra()
    {
        return $this->hasOne('App\Siembra');
    }
    public function getCreatedAtAttribute($date)
    {
        return new Date($date);
    }
}
