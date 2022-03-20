<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonAcademicStaff extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'employee_id',
        'fname',
        'lname',
        'initial',
        'fullname',
        'city',
        'address',
        'image',
        'department_id',
        'faculty_id',
        'is_rejected',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array<int, string>
     */
    protected $hidden = [
        'is_rejected'
    ];

    /**
     * Get the user, department and faculty that owns the NonAcademicStaff
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
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
