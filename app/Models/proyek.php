<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proyek extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function taskProyek()
    {
        return $this->hasMany(task_proyek::class);
    }

    public function updateAverageNilai()
    {
        $averageNilai = $this->taskProyek()->avg('nilai');
        $this->nilai = $averageNilai;
        $this->save();
    }
}
