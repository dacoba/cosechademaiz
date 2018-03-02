<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fumigacion extends Model
{
    protected $table = 'fumigacions';
    protected $fillable = [
        'siembra_id', 'estado',
    ];
    function siembra(){
        return $this->belongsTo('App\Siembra');
    }
}
