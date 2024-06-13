<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutoringSession extends Model
{
    protected $fillable = [
        'tutor_id',
        'subject_id',
        'section_id',
        'topic_id',
        'about',
    ];

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }
}
