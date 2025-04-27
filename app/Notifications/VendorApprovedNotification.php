<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VendorApprovedNotification extends Notification
{


    use Queueable;

    public function via($notifiable)
    {
        return ['mail', 'database']; // optional: 'broadcast'
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('Your Vendor Account Has Been Approved')
            ->greeting('Hello ' . $notifiable->name)
            ->line('We are happy to inform you that your vendor account has been approved.')
            ->action('Go to Dashboard', url('/dashboard'))
            ->line('Thank you for being a part of our platform!');
    }


    public function toArray($notifiable)
    {
        return [
            'message' => 'Your vendor account has been approved.',
            'url' => url('/dashboard'),
        ];
    }
}
