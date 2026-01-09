<?php

namespace App\Models;

use App\Notifications\CustomVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

class Student extends User implements MustVerifyEmail
{
    use Notifiable;
    /**
     * Send the email verification notification using Resend channel.
     */
    // public function sendEmailVerificationNotification()
    // {
    //     $this->notify(new \App\Notifications\VerifyResendNotification());
    // }

    /**
     * Send the password reset notification using Resend channel.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPasswordResendNotification($token));
    }
    protected $fillable = ['name', 'email', 'password', 'NIM', 'major', 'image_path'];
    protected $hidden = ['password'];

    public function theses(): BelongsToMany {
        return $this->belongsToMany(Thesis::class)->withPivot('status');
    }

    public function appointments(): BelongsToMany {
        return $this->belongsToMany(Appointment::class, 'appointment_students')->withPivot('hidden');
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }

    /**
     * Get the email address that should be used for password reset.
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }
}
