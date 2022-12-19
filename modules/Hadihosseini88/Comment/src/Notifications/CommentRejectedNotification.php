<?php

namespace Hadihosseini88\Comment\Notifications;

use Hadihosseini88\Comment\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class CommentRejectedNotification extends Notification
{
    use Queueable;


    public $comment;


    public function __construct(Comment $comment)
    {
        //
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = [
            'mail','database'
        ];
        if (!empty($notifiable->telegram) or !is_null($notifiable->telegram)) $channels[] = "telegram";
        return $channels;
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            // Optional recipient user id.
            ->to($notifiable->telegram) //$notifiable->telegram_user_id
            ->content("سلام خوبی!\n دیدگاه شما تایید نشد.")

            ->button('مشاهده دوره', $this->comment->commentable->path());
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
            'message' => 'دیدگاه شما رد شد.',
            'url' => $this->comment->commentable->path(),
        ];
    }
}
