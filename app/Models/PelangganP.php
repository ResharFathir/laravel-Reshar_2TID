<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = ['nama', 'email', 'hp'];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
} 