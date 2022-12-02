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
    public $user;
    public $course;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Course $course, User $user)
    {
        $this->user = $user;
        $this->course = $course;
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
            ->line('you are enrolled into:- '.$this->course->title . 'by '. $this->user->full_name)
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
            // 'message' => $notifiable->full_name.' is assign into '.$this->courses.' by '.$this->sender->full_name
        ];
    }
}
