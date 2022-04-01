<?php

namespace Database\Seeders;

use App\Models\Batch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $expired_in = now()->addYear(env('EXPIRED_IN', 4))->format('Y-m-d');

        $current_batches = [
            ['id' => 16, 'expire_date' => $expired_in],
            ['id' => 17, 'expire_date' => $expired_in],
            ['id' => 18, 'expire_date' => $expired_in],
            ['id' => 19, 'expire_date' => $expired_in],
            ['id' => 20, 'expire_date' => $expired_in]
        ];

        // Number of batches we already have in the database
        $batchCount = Batch::count();

        // Add all the batches in university of Peradeniya
        if($batchCount < 5) {
            foreach ($current_batches as $key => $batch) {
                Batch::create($batch);
            }
            $arrayLength = count($current_batches);
            $this->command->info("{$arrayLength} batches have been created...");
            $batchCount = $arrayLength;
        } 
        // There are some batches already in the table
        else {
            $this->command->info("There are {$batchCount} batches already in the table...");
        }

        // Ask user if he wants more batches to be added to the table
        if($this->command->confirm("Do you want more than {$batchCount} batches?")) {
            $moreBatches = (int) $this->command->ask("How many batches do you want more?", 2);
            Batch::factory()->count($moreBatches)->create();
            $this->command->info("{$moreBatches} more batches have been created...");
        }
    }
}
