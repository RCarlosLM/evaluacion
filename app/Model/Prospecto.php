<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Prospecto extends Model
{
    
    protected $table = 'prospectos';
    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'celular',
        'email',
        'estatus'
    ];

    public function llamadas(){
        return $this->hasMany(llamada::class);
    }

}
