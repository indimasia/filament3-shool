<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeRoom extends Model
{
    use HasFactory;

    protected $guarded = [];

    function teacher() : BelongsTo {
        return $this->belongsTo(Teacher::class);
    }

    function period() : BelongsTo {
        return $this->belongsTo(Period::class);
    }

    function classroom() : BelongsTo {
        return $this->belongsTo(Classroom::class);
    }
}
