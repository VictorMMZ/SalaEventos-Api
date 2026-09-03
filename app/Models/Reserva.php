<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;
    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }
        public function reservaAdmin()
{
    return $this->hasOne(ReservaAdmin::class);
}

    protected $fillable=[
        'sala_id',
        'nombre_completo',
        'email',
        'telefono',
        'fecha_evento',
        'hora_entrada',
        'hora_salida',
        'numero_ninos',
        'mensaje_adicional'
    ];
}