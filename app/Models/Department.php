<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'faculty_id',
        'name',
        'code'
    ];

    /**
     * Get the faculty that owns the Department
     */
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'id');
    }

    /**
     * Get all of the students, non-academic staff and academic staff for the Department
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'department_id', 'id');
    }

    public function academicStaff()
    {
        return $this->hasMany(AcademicStaff::class, 'department_id', 'id');
    }
    
    public function nonAcademicStaff()
    {
        return $this->hasMany(NonAcademicStaff::class, 'department_id', 'id');
    }    
}
