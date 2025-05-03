<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    protected $table = 'user_progress';

    protected $fillable = [
        'user_id',
        'lesson_id',
        'quiz_id',
        'lesson_completed',
        'quiz_completed',
        'quiz_score',
        'completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'lesson_completed' => 'boolean',
        'quiz_completed' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
