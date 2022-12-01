<?php

namespace App\Notifications;

use App\Models\Course;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourseEnrollNotification extends Notification
{
    use Queueable;
    private $sender;
    private $courses=[];

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $courses, User $sender)
    {
        $this->sender = $sender;
        $this->courses = $courses->pluck('title');
    //    dd($this->courses);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
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
            ->line('welcome'.' '.$notifiable->full_name)
            ->line('you are assigned into :-'.$this->courses)
            ->line('by '. $this->sender->full_name)
            ->line('Thank You!');
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
            'message' => $notifiable->full_name.' is assign into '.$this->courses.' by '.$this->sender->full_name
        ];
    }
}
