<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
    protected $table = 'opinions';

    protected $fillable = [
        'stars',
        'opinion_text',
        'approved'
    ];

    protected $casts = [
        'approved' => 'boolean',
    ];

    public function isValid()
    {
        return $this->stars > 0 && $this->stars < 6;
    }
}
