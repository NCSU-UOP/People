<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Getting the number of department that we want for an each faculty
        $departmentCount = (int) $this->command->ask('How many departments do you need for each faculty?', 10);
        $this->command->info("Creating {$departmentCount} departments for each faculty...");

        // Retrieve all the faculty ids from the table
        $faculties = Faculty::select('id', 'code')->get();

        // Create departments for each faculty in the database
        foreach ($faculties as $key => $faculty) {
            if ($faculty->code == "AHS") {
                Department::factory()->count($departmentCount)->state(['faculty_id' => $faculty->id, 'code' => strtoupper(Str::random(3))])->create();
            } else {
                Department::factory()->count($departmentCount)->state(['faculty_id' => $faculty->id])->create();
            }
        }
    }
}
