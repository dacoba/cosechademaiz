<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fumigacion extends Model
{
    protected $table = 'fumigacions';
    protected $fillable = [
        'siembra_id',
    ];
    function siembra(){
        return $this->belongsTo('App\Siembra');
    }
}
