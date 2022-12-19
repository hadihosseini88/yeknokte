<?php

namespace Hadihosseini88\Comment\Notifications;

use Hadihosseini88\Comment\Mail\CommentSubmittedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kavenegar\LaravelNotification\KavenegarChannel;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class CommentSubmittedNotification extends Notification
{
    use Queueable;

    public $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable): array
    {
        $channels = [
            'mail', 'database',
        ];
        if (!empty($notifiable->telegram) or !is_null($notifiable->telegram)) $channels[] = "telegram";
        if (!empty($notifiable->mobile) or !is_null($notifiable->mobile)) $channels[] = KavenegarChannel::class;
        return $channels;
    }

    public function toMail($notifiable)
    {
        return (new CommentSubmittedMail($this->comment))->to($notifiable->email);
    }

    public function toSMS($notifiable)
    {
        return 'یک دیدگاه جدید در یک نکته برای شما ارسال شده است.' . "\n" . $this->comment->commentable->path();
    }

    public function toTelegram($notifiable)
    {
//        $url = url('/invoice/' . $this->invoice->id);
        return TelegramMessage::create()
            // Optional recipient user id.
            ->to($notifiable->telegram) //$notifiable->telegram_user_id
            // Markdown supported.
            ->content("سلام خوبی!\n یک دیدگاه جدید در یک نکته برای شما ارسال شده است.")

            // (Optional) Blade template for the content.
            // ->view('notification', ['url' => $url])

            // (Optional) Inline Buttons
            ->button('مشاهده دوره', $this->comment->commentable->path())
            ->button('مدیریت نظرات', route('comments.index'));
        // (Optional) Inline Button with callback. You can handle callback in your bot instance
//            ->buttonWithCallback('Confirm', 'confirm_invoice ' . $this->invoice->id);
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'دیدگاه شما ثبت شد.',
            'url' => $this->comment->commentable->path(),
        ];
    }
}
