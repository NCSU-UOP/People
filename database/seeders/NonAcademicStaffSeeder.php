<?php

namespace Database\Seeders;

use App\Models\NonAcademicStaff;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NonAcademicStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $index = 0;
        $nonAcademicUsers = User::select('id')->where('usertype', env('NON_ACADEMIC_STAFF'))->get();
        $nonAcademicCount = NonAcademicStaff::count();
        $departmentIds = Department::select('id')->get();

        $userCount = (int)(count($nonAcademicUsers)/count($departmentIds));

        if($nonAcademicCount < count($nonAcademicUsers)) {
            foreach ($departmentIds as $key => $department) {
                $facultyId = Department::find($department->id)->faculty()->first()->id;

                for ($i=0; $i < $userCount; $i++, $index++) { 
                    NonAcademicStaff::factory()->state(['id' => $nonAcademicUsers[$index]->id, 'department_id' => $department->id, 'faculty_id' => $facultyId])->create();
                }
            }

            $nonAcademicCount = count($nonAcademicUsers);
            $this->command->info("{$nonAcademicCount} non-academic staff have been created...");
        } else {
            $this->command->info("Non-academic staff have not been created...");
        }
    }
}
