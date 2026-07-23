<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
    'admin_name',
    'admin_email',
    'generate_reports',
   ];
}