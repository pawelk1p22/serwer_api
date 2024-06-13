<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competency extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_competencies', 'competency_id', 'subject_id', 'user_id');
    }
}