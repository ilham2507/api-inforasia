<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class task_proyek extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function penerimaProyek()
    {
        return $this->hasMany(penerima_proyek::class);
    }

    public function proyek()
    {
        return $this->belongsTo(proyek::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($taskProyek) {
            $taskProyek->proyek->updateAverageNilai();
        });

        static::deleted(function ($taskProyek) {
            $taskProyek->proyek->updateAverageNilai();
        });
    }
}
