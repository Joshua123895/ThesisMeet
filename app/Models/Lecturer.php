<?php

namespace App\Models;

use App\Notifications\CustomVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

class Lecturer extends User implements MustVerifyEmail
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
    protected $fillable = ['name', 'email', 'password', 'phone', 'profile', 'image_path'];
    protected $hidden = ['password'];

    public function theses(): BelongsToMany {
        return $this->belongsToMany(Thesis::class)->withPivot('position', 'status');
    }

    public function appointments(): HasMany {
        return $this->hasMany(Appointment::class);
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

    public function officeHours() : HasMany {
        return $this->hasMany(OfficeHour::class);
    }
}
