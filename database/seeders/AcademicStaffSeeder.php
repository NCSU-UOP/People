<?php

namespace Database\Seeders;

use App\Models\AcademicStaff;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $index = 0;
        $academicUsers = User::select('id')->where('usertype', env('ACADEMIN_STAFF'))->get();
        $academicCount = AcademicStaff::count();
        $departmentIds = Department::select('id')->get();

        $userCount = (int)(count($academicUsers)/count($departmentIds));

        if($academicCount < count($academicUsers)) {
            foreach ($departmentIds as $key => $department) {
                $facultyId = Department::find($department->id)->faculty()->first()->id;

                for ($i=0; $i < $userCount; $i++, $index++) { 
                    AcademicStaff::factory()->state(['id' => $academicUsers[$index]->id, 'department_id' => $department->id, 'faculty_id' => $facultyId])->create();
                }
            }

            $academicCount = count($academicUsers);
            $this->command->info("{$academicCount} academic staff have been created...");
        } else {
            $this->command->info("Academic staff have not been created...");
        }
    }
}
