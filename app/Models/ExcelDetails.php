<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcelDetails extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'admin_id',
        'usertype',
        'excel_filename',
        'faculty_id',
        'batch_id',
        'department_id',
        'excel_file_link'
    ];

    /**
     * Get the user, batch, department and faculty
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
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
