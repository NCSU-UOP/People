<?php

namespace Database\Factories;

use App\Models\Batch;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Batch>
 */
class BatchFactory extends Factory
{
    private $increase_value = 1;
    /**
     * Define the model's default state.
     * @return array<string, mixed>
     */
    public function definition()
    {
        $last_batch = Batch::orderBy('id', 'desc')->first()->id;
        $next_batch = $last_batch + $this->increase_value++;
        $expired_in = now()->addYear(env('EXPIRED_IN', 4));

        return [
            'id' => $next_batch,
            'expire_date' => $expired_in
        ];
    }
}
