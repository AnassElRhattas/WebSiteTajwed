<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'module_id',
        'title',
        'content',
        'explanation',
        'order',
        'is_active'
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class);
    }

    public function audioResources()
    {
        return $this->hasMany(AudioResource::class);
    }

    public function userProgress()
    {
        return $this->hasMany(UserProgress::class);
    }
}
