<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentClass extends Model
{
    use HasFactory;

    protected $guarded = [];

    function student() : BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    function homeroom() : BelongsTo {
        return $this->belongsTo(HomeRoom::class, 'home_room_id');
    }
}
