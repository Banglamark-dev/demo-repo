<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VendorApprovedNotification extends Notification
{
    use Queueable;

    protected $email;
    protected $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

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
            ->line('Here are your login credentials:')
            ->line('Email: ' . $this->email)
            ->line('Password: ' . $this->password)
            ->action('Go to Dashboard', url('/admin/dashboard'))
            ->line('Thank you for being a part of our platform!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your vendor account has been approved.',
            'url' => url('/admin/dashboard'),
        ];
    }
}
