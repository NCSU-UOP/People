<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'regNo',
        'preferedname',
        'initial',
        'fullname',
        'city',
        'province',
        'address',
        'image',
        'bio',
        'telephone',
        'batch_id',
        'department_id',
        'faculty_id',
        'is_verified',
        'is_rejected',
        'is_activated',
        'is_visible'
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array<int, string>
     */
    protected $hidden = [
        'is_rejected',
    ];

    /**
     * Get the user, batch, department and faculty that owns the NonAcademicStaff
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'id');
    }
}
