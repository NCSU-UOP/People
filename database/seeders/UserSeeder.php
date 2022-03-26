<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Batch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{    
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $admin = env('ADMIN', 0);
        $student = env('STUDENT', 1);
        $academic = env('ACADEMIN_STAFF', 2);
        $nonAcademic = env('NON_ACADEMIC_STAFF', 3);

        $password = Hash::make(env('DEFAULT_PASSWORD', 'admin12345'));
        $token = Str::random(10);
        $facultyCodes = Faculty::orderBy('code')->select('code')->get();
        $departmentCount = Department::count();
        $batchCount = Batch::count();
        $arrayLength = count($facultyCodes)*2;

        // retrieve the user count from the table
        $userCount = User::count();

        // Add one admin and one super admin for each faculty
        if($userCount < $arrayLength) {
            foreach ($facultyCodes as $key => $faculty) {
                $facultyCode = strtolower($faculty->code);

                User::create(['username' => $facultyCode.'_admin', 'email' => $facultyCode.'admin@pdn.ac.lk', 'password' => $password, 'usertype' => $admin, 'remember_token' => $token]);
                User::create(['username' => $facultyCode.'_super', 'email' => $facultyCode.'super@pdn.ac.lk', 'password' => $password, 'usertype' => $admin, 'remember_token' => $token]);
            }

            $this->command->info("{$arrayLength} admins have been created...");
        } else {
            $this->command->info("Admins have not been created...");
        }

        if($userCount < 1000) {
            $userNeeds = (int) $this->command->ask("How many entries do you want to add for each students, academic staff and non-academic staff tables?", 2);

            for ($i=0; $i < $departmentCount; $i++) { 
                // Create Non-Academic Staff
                User::factory()->count($userNeeds)->state(['password' => $password, 'usertype' => $nonAcademic, 'remember_token' => $token])->create();

                // Create Academic Staff
                User::factory()->count($userNeeds)->state(['password' => $password, 'usertype' => $academic, 'remember_token' => $token])->create();

                // Create Students
                User::factory()->count($userNeeds * $batchCount)->state(['password' => $password, 'usertype' => $student, 'remember_token' => $token])->create();
            }

            $this->command->info("Student, Non-Academic and Academic users have been created...");
        } else {
            $this->command->info("Student, Non-Academic and Academic users have not been created...");
        }
        
    }
}
