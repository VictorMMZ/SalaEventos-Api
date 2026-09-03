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

    public function reservaAdmin()
{
    return $this->hasOne(ReservaAdmin::class);
}

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_hora',
        'capacidad',   
    ];
}