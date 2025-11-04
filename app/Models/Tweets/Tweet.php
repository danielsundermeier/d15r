<?php

namespace App\Models\Tweets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    protected $appends = [
        //
    ];

    protected $casts = [
        //
    ];

    protected $dates = [
        'scheduled_at',
        'tweeted_at',
    ];

    protected $fillable = [
        'scheduled_at',
        'text',
        'tweet_id',
        'tweeted_at',
    ];
}