<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use App\Models\Faculty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $index = 0;
        $adminUsers = User::select('id')->where('usertype', env('ADMIN'))->get();
        $adminCount = Admin::count();
        $facultyIds = Faculty::orderBy('code')->select('id')->get();

        if($adminCount < count($adminUsers)) {
            foreach ($facultyIds as $key => $faculty) {
                Admin::factory()->state(['id' => $adminUsers[$index]->id, 'faculty_id' => $faculty->id, 'active' => 1, 'is_admin' => 0])->create();
                Admin::factory()->state(['id' => $adminUsers[$index+1]->id, 'faculty_id' => $faculty->id, 'active' => 1, 'is_admin' => 1])->create();
                $index += 2;
            }
    
            $adminCount = count($adminUsers);
            $this->command->info("{$adminCount} admins have been created...");
        } else {
            $this->command->info("Admins have not been created...");
        }
        
    }
}
