<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    protected $fillable = [

        'website',
        'base_url',
        'host',
        'to_visit',
        'visited',
        'broken_links',
        'indexed',
        'broken',
        'skipped',
        'finished'

    ];
    protected $casts = [
        'to_visit'=>'array',
        'visited'=>'array',
        'broken_links'=>'array',
        'finished'=>'boolean'
    ];
}
