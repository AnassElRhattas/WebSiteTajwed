<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'title',
        'description',
        'order',
        'is_active'
    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
