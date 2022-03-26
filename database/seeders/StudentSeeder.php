<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Department;
use App\Models\User;
use App\Models\Batch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Generator;
use Illuminate\Container\Container;

class StudentSeeder extends Seeder
{
    protected $faker;

    /**
     * Create a new seeder instance.
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $index = 0;
        $studentUsers = User::select('id')->where('usertype', env('STUDENT'))->get();
        $studentCount = Student::count();
        $departmentIds = Department::select('id')->get();
        $batchIds = Batch::select('id')->get();

        $userCount = (int)(count($studentUsers)/(count($departmentIds) * count($batchIds)));

        if($studentCount < count($studentUsers)) {
            foreach ($departmentIds as $key => $department) {
                $faculty = Department::find($department->id)->faculty()->select('id', 'code')->first();

                foreach ($batchIds as $key => $batch) {
                    for ($i=0; $i < $userCount; $i++, $index++) { 
                        $regNo = $faculty->code.'/'.$batch->id.'/'.$this->faker->unique()->randomNumber($nbDigits = 3, $strict = true);
                        Student::factory()->state(['id' => $studentUsers[$index]->id, 'regNo' => $regNo, 'batch_id' => $batch->id, 'department_id' => $department->id, 'faculty_id' => $faculty->id])->create();
                    }
                }
            }

            $studentCount = count($studentUsers);
            $this->command->info("{$studentCount} students have been created...");
        } else {
            $this->command->info("Students have not been created...");
        }
    }
}
