<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'faculty_id',
        'name',
        'remark',
        'active',
        'is_admin',
        'last_online'
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array<int, string>
     */
    protected $hidden = [
        'active',
        'is_admin',
        'last_online'
    ];

    /**
     * Get the user and faculty that owns the Admin
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'id');
    }
}
