<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'usertype',
        'password_set',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'usertype',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all of the admins, students, non-academic staff and academic staff for the User
     */
    public function admins()
    {
        return $this->hasMany(Admin::class, 'id', 'id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'id', 'id');
    }

    public function academicStaff()
    {
        return $this->hasMany(AcademicStaff::class, 'id', 'id');
    }

    public function nonAcademicStaff()
    {
        return $this->hasMany(NonAcademicStaff::class, 'id', 'id');
    }

    public function socialMedia()
    {
        return $this->hasMany(UserSocialMedia::class, 'id', 'id');
    }
}
