<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerify;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Carbon;

class VerifyResendNotification extends Notification
{
    public function via($notifiable)
    {
        return [\App\Notifications\Channels\ResendChannel::class];
    }

    public function toResend($notifiable)
    {
        $expiration = Config::get('auth.verification.expire', 60);

        $verifyUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes($expiration),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );

        $subject = 'Verify Email Address';

        $html = "<p>Hello {$notifiable->name},</p>" .
            "<p>Please click the button below to verify your email address.</p>" .
            "<p><a href=\"{$verifyUrl}\" style=\"display:inline-block;padding:10px 18px;background:#0069d9;color:#fff;text-decoration:none;border-radius:6px\">Verify Email Address</a></p>" .
            "<p>If you did not create an account, no further action is required.</p>";

        return [
            'from' => env('MAIL_FROM_ADDRESS', 'no-reply@example.com'),
            'to' => [$notifiable->getEmailForVerification()],
            'subject' => $subject,
            'html' => $html,
        ];
    }
}
