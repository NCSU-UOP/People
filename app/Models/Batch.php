<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'expire_date'
    ];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        'expire_date' => 'date',
    ];

    /**
     * Get all of the students for the Batch
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'batch_id', 'id');
    }
}
