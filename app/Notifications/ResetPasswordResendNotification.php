<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class ResetPasswordResendNotification extends Notification
{
    protected string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return [\App\Notifications\Channels\ResendChannel::class];
    }

    public function toResend($notifiable)
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        $subject = 'Reset Password Notification';

        $html = "<p>Hello {$notifiable->name},</p>" .
            "<p>You are receiving this email because we received a password reset request for your account.</p>" .
            "<p><a href=\"{$resetUrl}\" style=\"display:inline-block;padding:10px 18px;background:#dc3545;color:#fff;text-decoration:none;border-radius:6px\">Reset Password</a></p>" .
            "<p>If you did not request a password reset, no further action is required.</p>";

        return [
            'from' => env('MAIL_FROM_ADDRESS', 'no-reply@example.com'),
            'to' => [$notifiable->getEmailForPasswordReset()],
            'subject' => $subject,
            'html' => $html,
        ];
    }
}
