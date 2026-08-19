<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\UserScan;

class UserScan extends Model
{
    protected $fillable = [
        'user_id',
        'website',
        'base_url',
        'host',
        'to_visit',
        'visited',
        'broken_links',
        'indexed',
        'broken',
        'skipped',
        'finished',
    ];

    protected $casts = [
        'to_visit' => 'array',
        'visited' => 'array',
        'broken_links' => 'array',
        'finished' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}