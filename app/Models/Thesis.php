<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thesis extends Model
{
    protected $fillable = ['title', 'is_done', 'paper_link'];

    public function students(): BelongsToMany {
        return $this->belongsToMany(Student::class)->withPivot('status');
    }

    public function lecturers(): BelongsToMany {
        return $this->belongsToMany(Lecturer::class)->withPivot('position', 'status');
    }

    public function appointments(): HasMany {
        return $this->hasMany(Appointment::class);
    }
}
