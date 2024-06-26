<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = ['id'];

    public function role()
    {
        return $this->belongsTo(role::class, 'role_id');
    }

    public function proyek()
    {
        return $this->hasMany(proyek::class);
    }

    public function taskProyek()
    {
        return $this->hasMany(task_proyek::class);
    }

    public function penerimaProyek()
    {
        return $this->hasMany(penerima_proyek::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'nip',
        'username',
        'password',
        'jenis_kelamin',
        'tanggal_lahir',
        'no_telp',
        'alamat',
        'role_id',
        'remember_token',
        'email_verified_at',
        'foto_profile',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
