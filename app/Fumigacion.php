<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fumigacion extends Model
{
    protected $table = 'fumigacions';
    protected $fillable = [
        'preventivo_plagas', 'control_rutinario', 'control_malezas', 'control_insectos', 'control_enfermedades', 'comentario_fumigacion', 'siembra_id',
    ];
    function siembra(){
        return $this->belongsTo('App\Siembra');
    }
}
