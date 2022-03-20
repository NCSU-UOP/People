<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


// use App\Models\Department;

class Faculty extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'remark'
    ];


    /**
     * Get all of the departments and admins for the Faculty
     */
    public function departments()
    {
        return $this->hasMany(Department::class, 'faculty_id', 'id');
    }

    public function admins()
    {
        return $this->hasMany(Admin::class, 'faculty_id', 'id');
    }


    /**
     * Get all of the students, non-academic staff and academic staff for the Faculty
     */
    public function students()
    {
        return $this->hasManyThrough(Student::class, Department::class);
    }

    public function academicStaff()
    {
        return $this->hasManyThrough(AcademicStaff::class, Department::class);
    }

    public function nonAcademicStaff()
    {
        return $this->hasManyThrough(NonAcademicStaff::class, Department::class);
    }
}
