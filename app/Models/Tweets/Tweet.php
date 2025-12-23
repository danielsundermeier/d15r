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
        'scheduled_at' => 'datetime',
        'tweeted_at' => 'datetime',
    ];

    protected $fillable = [
        'type',
        'source',
        'scheduled_at',
        'text',
        'tweet_id',
        'tweeted_at',
    ];
}