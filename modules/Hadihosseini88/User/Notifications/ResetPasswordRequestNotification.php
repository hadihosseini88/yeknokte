<?php

namespace Hadihosseini88\User\Notifications;

use Hadihosseini88\User\Mail\ResetPasswordRequestMail;
use Hadihosseini88\User\Services\VerifyCodeService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ResetPasswordRequestNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return ResetPasswordRequestMail
     */
    public function toMail($notifiable)
    {
        $code = VerifyCodeService::generate();

        VerifyCodeService::store($notifiable->id,$code,120);

        return (new ResetPasswordRequestMail($code))
            ->to($notifiable->email);

    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
