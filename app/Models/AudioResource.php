<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AudioResource extends Model
{
    protected $fillable = [
        'lesson_id',
        'title',
        'file_path',
        'description',
        'duration_seconds'
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
