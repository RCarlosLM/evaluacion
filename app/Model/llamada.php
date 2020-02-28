<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class llamada extends Model
{
    
    protected $table = 'llamadas';
    protected $fillable = [
        'asunto',
        'fecha',
        'estatus',
        'prospecto_id'
    ];

}
