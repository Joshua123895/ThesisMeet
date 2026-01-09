<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfficeHour extends Model
{
    protected $fillable = ['lecturer_id', 'day_of_week', 'start_time', 'end_time'];

    public function lecturer() : BelongsTo {
        return $this->belongsTo(Lecturer::class);
    }
}
