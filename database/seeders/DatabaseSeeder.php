<?php

namespace Database\Seeders;

use Eloquent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        // Ask for db migration refresh, default is no
        if ($this->command->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {

            // Call the php artisan migrate:fresh using Artisan
            $this->command->call('migrate:fresh');

            $this->command->line('All tables were droped and all migrations were re-run');
        }

        $this->call([
            FacultySeeder::class,
            DepartmentSeeder::class,
            BatchSeeder::class,
            UserSeeder::class,
            AdminSeeder::class,
            StudentSeeder::class,
            AcademicStaffSeeder::class,
            NonAcademicStaffSeeder::class
        ]);

        // Re Guard model
        Eloquent::reguard();
    }
}
