<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Appointment extends Model
{
    protected $fillable = [
        'start_time',
        'end_time',
        'comments',
        'is_onsite',
        'location',
        'paper_path',
        'hidden_by_lecturer',
        'status',
        'thesis_id',
        'lecturer_id'
    ];
    
    public function thesis(): BelongsTo {
        return $this->belongsTo(Thesis::class);
    }

    public function lecturer(): BelongsTo {
        return $this->belongsTo(Lecturer::class);
    }
    
    public function notes() {
        return $this->hasMany(Note::class);
    }

    public function students(): BelongsToMany {
        return $this->belongsToMany(Student::class, 'appointment_students')->withPivot('hidden');
    }
}
