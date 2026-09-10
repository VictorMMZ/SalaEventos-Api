<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservaAdmin extends Model
{
    use HasFactory;
    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }

    protected $fillable = [
        'reserva_id',
        'precio',
        'descuento',
        'fianza',
        'metodo_pago',
        'estado',
        'total',
    ];
}