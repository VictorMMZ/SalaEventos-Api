<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    use HasFactory;

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }


    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_hora',
        'capacidad',   
    ];
}