<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectsP extends Model
{
    protected $table = 'pelanggan';

    protected $primaryKey = 'pelanggan_id';

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'pelanggan_id', 'pelanggan_id');
    }
}