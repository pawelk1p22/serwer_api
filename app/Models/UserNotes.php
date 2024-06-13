<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotes extends Model
{
    protected $table = 'user_notes';
    protected $primaryKey = null;

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'note_id',
    ];

    // Define the relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function note()
    {
        return $this->belongsTo(Note::class, 'note_id');
    }
}
