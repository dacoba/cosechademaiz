<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Riego extends Model
{
    protected $table = 'riegos';
    protected $fillable = [
        'siembra_id', 'estado',
    ];
    function siembra(){
        return $this->belongsTo('App\Siembra');
    }
}