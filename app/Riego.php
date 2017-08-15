<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Riego extends Model
{
    protected $table = 'riegos';
    protected $fillable = [
        'metodos_riego', 'comportamiento_lluvia', 'problemas_drenaje', 'comentario_riego', 'siembra_id',
    ];
    function siembra(){
        return $this->belongsTo('App\Siembra');
    }
}