<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name', 'photo_path', 'headline', 'summary', 'email', 'phone', 'address',
        'linkedin', 'github', 'skills', 'education',
    ];
}