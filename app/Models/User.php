<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's quiz attempts through user progress.
     */
    public function quizAttempts()
    {
        return $this->hasMany(UserProgress::class)->whereNotNull('quiz_id');
    }

    /**
     * Get the user's achievements.
     */
    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')
            ->withTimestamps();
    }

    /**
     * Get the lessons associated with the user through progress.
     */
    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'user_progress')
                    ->withPivot('lesson_completed')
                    ->withTimestamps();
    }

    /**
     * Get the modules associated with the user.
     */
    public function modules()
    {
        return $this->belongsToMany(Module::class, 'user_progress')
            ->withPivot('lesson_completed')
            ->withTimestamps();
    }
}
