<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FeePaidNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $receiver, $sender, $fee_amount,$fee_type, $subject = 'Fee Paid Notification';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($receiver, $sender,$fee_amount,$fee_type)
    {
        $this->receiver = $receiver;
        $this->sender = $sender;
        $this->fee_amount = $fee_amount;
        $this->fee_type = $fee_type;
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
            ->greeting("Hello, " . $this->receiver['name'])
            ->line($this->sender['name']. ' has paid the fee for '. $this->fee_amount . ' of '. $this->fee_type)
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
            'body' => $this->sender['name']. ' has paid the fee for '. $this->fee_amount . ' of '. $this->fee_type
        ];
    }
}
