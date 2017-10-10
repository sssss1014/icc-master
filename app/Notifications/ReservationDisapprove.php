<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationDisapprove extends Notification {

    use Queueable;

    /**
     * Customer Information
     * @var type 
     */
    protected $customer_info;

    /**
     * Reservation ID
     * @var type 
     */
    protected $reserv_id;

    /**
     * Disabled reason
     * @var type 
     */
    protected $disapprove_reason;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($customer_info, $reserv_id, $disapprove_reason) {
        $this->customer_info = $customer_info;
        $this->reserv_id = $reserv_id;
        $this->disapprove_reason = $disapprove_reason;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        return (new MailMessage)
                        ->subject('ICC')
                        ->line('Good day, ' . $this->customer_info->cust_fname . ' ' . $this->customer_info->cust_lname . ' ' .
                                'your reservation has been disapprove. ')
                        ->line('Disabled reason: ' . $this->disapprove_reason)
                        ->line('This is your reservation id: ' . '<b>' . $this->reserv_id . '</b>')
                        ->action('Check Credentials', route('credential.check-code', ['reserv_id' => $this->reserv_id]))
                        ->line('Thank you for booking reservation!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [
                //
        ];
    }

}
