<?php

namespace App\Notifications;

use App\Models\ReservaAdmin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservaEnviada extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public ReservaAdmin $reserva,
        public string $estadoAnterior
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
   

     public function toMail(object $notifiable): MailMessage
    {
        

          return (new MailMessage)
        ->subject('Reserva recibida - SalaEventos')
        ->view('emails.reserva-enviada', [
            'reserva' => $this->reserva,
        ]);
    }
}

