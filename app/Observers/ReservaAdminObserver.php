<?php

namespace App\Observers;

use App\Models\ReservaAdmin;
use App\Notifications\ReservaEstadoCambiado;
use Illuminate\Support\Facades\Notification;

class ReservaAdminObserver
{
    /**
     * Handle the ReservaAdmin "created" event.
     */
    public function created(ReservaAdmin  $reservaAdmin): void
    {
        

        
            Notification::route('mail', $reservaAdmin->reserva->email)
                ->notify(
                    new \App\Notifications\ReservaEnviada($reservaAdmin, 'pendiente')
                );
        
    }

    /**
     * Handle the ReservaAdmin "updated" event.
     */
    public function updated(ReservaAdmin  $reservaAdmin): void
    {
        if (!$reservaAdmin->wasChanged('estado')) {
            return;
        }

        $estadoAnterior = $reservaAdmin->getOriginal('estado');

        if (
            $estadoAnterior === 'pendiente' &&
            in_array($reservaAdmin->estado, ['confirmada', 'cancelada'])
        ) {
            Notification::route('mail', $reservaAdmin->reserva->email)
                ->notify(
                    new ReservaEstadoCambiado(
                        $reservaAdmin,
                        $estadoAnterior
                    )
                );
        }
    }

}
