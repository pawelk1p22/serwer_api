<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOpinions extends Model
{
    protected $table = 'user_opinions';

    public $timestamps = false;


    protected $primaryKey = ['user_reviewed_id', 'user_giving_review'];


    public $incrementing = false;


    protected $fillable = [

        'user_reviewed_id',

        'user_giving_review_id',

        'opinion_id',

    ];


    public function userReviewed()
    {

        return $this->belongsTo(User::class, 'user_reviewed_id', 'id');

    }


    public function userGivingReview()
    {

        return $this->belongsTo(User::class, 'user_giving_review', 'id');

    }

    // You can define other relationships or methods here if needed
}
