<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    private $faculty_list_uop = [
        ['name'=>'Faculty of Agriculture', 'code'=>'AG'],
        ['name'=>'Faculty of Arts', 'code'=>'A'],        
        ['name'=>'Faculty of Dental Sciences', 'code'=>'D'],
        ['name'=>'Faculty of Engineering', 'code'=>'E'],
        ['name'=>'Faculty of Medicine', 'code'=>'M'],
        ['name'=>'Faculty of Science', 'code'=>'S'],
        ['name'=>'Faculty of Veterinary Medicine and Animal Science', 'code'=>'V'],
        ['name'=>'Faculty of Allied Health Sciences', 'code'=>'AHS'],
        ['name'=>'Faculty of Management', 'code'=>'MG'],
    ];

    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        // Number of faculties we already have in the database
        $facultyCount = Faculty::count();

        // Add all the faculties in university of Peradeniya
        if($facultyCount < 9) {
            foreach ($this->faculty_list_uop as $key => $faculty) {
                Faculty::create($faculty);
            }
            $arrayLength = count($this->faculty_list_uop);
            $this->command->info("{$arrayLength} faculties have been created...");
            $facultyCount = $arrayLength;
        } 
        // There are some faculties already in the table
        else {
            $this->command->info("There are {$facultyCount} faculties already in the table...");
        }

        // Ask user if he wants more faculties to be added to the table
        if($this->command->confirm("Do you want more than {$facultyCount} faculties?")) {
            $moreFaculty = (int) $this->command->ask("How many faculties do you want more?", 5);
            Faculty::factory()->count($moreFaculty)->create();
            $this->command->info("{$moreFaculty} more faculties have been created...");
        }
        
    }
}
