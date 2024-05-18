<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class task_proyek extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function proyek()
    {
        return $this->belongsTo(proyek::class);
    }
}
