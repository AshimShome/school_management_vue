<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $receiver_name, $sender, $subject, $body;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($receiver_name,  $sender, $subject, $body)
    {
        $this->receiver_name = $receiver_name;
        $this->sender = $sender;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->subject)
//            ->greeting("Hello, " . $this->receiver_name['name'])
            ->greeting("Hello, " . $notifiable->name)
            ->line($this->body)
            ->action('Details', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'subject' => $this->subject,
            'sender' => [
                'name' => $this->sender['name'],
                'image' => $this->sender['image_url'],
            ],
            'body' => $this->body
        ];
    }
}
