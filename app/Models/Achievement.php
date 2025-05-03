<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'description',
        'type',
        'required_count'
    ];

    /**
     * Get the users who have earned this achievement.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_achievements')
            ->withTimestamps();
    }
}