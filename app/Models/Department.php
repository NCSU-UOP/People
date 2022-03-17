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
        'name'
    ];

    /**
     * Get the faculty that owns the Department
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'id');
    }

    /**
     * Get all of the students, non-academic staff and academic staff for the Department
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'department_id', 'id');
    }

    public function academicStaff(): HasMany
    {
        return $this->hasMany(AcademicStaff::class, 'department_id', 'id');
    }
    
    public function nonAcademicStaff(): HasMany
    {
        return $this->hasMany(NonAcademicStaff::class, 'department_id', 'id');
    }    
}
