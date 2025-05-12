<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class ResetPasswordNotification extends Notification
{
    public $token;
    public $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $resetUrl = "https://frontend-app.com/reset-password/{$this->token}?email={$this->email}";

        return (new MailMessage)
            ->subject('Reset Password')
            ->line('Klik tombol di bawah untuk mengatur ulang password Anda:')
            ->action('Reset Password', $resetUrl)
            ->line('Jika Anda tidak meminta reset, abaikan email ini.');
    }
}
