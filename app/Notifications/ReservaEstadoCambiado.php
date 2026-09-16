<?php

namespace App\Notifications;

use App\Models\ReservaAdmin;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservaEstadoCambiado extends Notification
{
    use Queueable;

    public function __construct(
        public ReservaAdmin $reserva,
        public string $estadoAnterior
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {

    return (new MailMessage)
        ->subject('Actualización de tu reserva - SalaEventos')
        ->view('emails.reserva-estado-cambiado', [
            'reserva' => $this->reserva,
            'estadoAnterior' => $this->estadoAnterior,
        ]);
    }
}