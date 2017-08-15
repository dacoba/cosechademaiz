<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Terreno extends Model
{
    protected $table = 'terrenos';
    protected $fillable = [
        'area_parcela', 'tipo_suelo', 'tipo_relieve', 'productor_id',
    ];
    function productor(){
        return $this->belongsTo('App\User');
    }
}
