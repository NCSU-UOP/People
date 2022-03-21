<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NonAcademicStaff>
 */
class NonAcademicStaffFactory extends Factory
{
    /**
     * Define the model's default state.
     * @return array<string, mixed>
     */
    public function definition()
    {
        $Gender = array_rand(['male', 'female']);
        $firstName = $this->faker->firstName($gender = $Gender, $maxNbChars = 20);
        $middleName = $this->faker->firstName($gender = $Gender, $maxNbChars = 20);
        $lastName = $this->faker->lastName($maxNbChars = 20);
        $city = $this->faker->city($maxNbChars = 80);

        return [
            'employee_id' => $this->faker->lexify('??').$this->faker->unique()->numberBetween(20, 9000),

            'fname' => $firstName,

            'lname' => $lastName,

            'initial' => $firstName[0].'.'.$middleName[0].'. '.$lastName,

            'fullname' => $firstName.' '.$middleName.' '.$lastName,

            'city' => $city,

            'address' => $this->faker->streetAddress().', '.$city.', '.$this->faker->state().' '.$this->faker->postcode(),

            'image' => $this->faker->imageUrl($width = 400, $height = 400, 'cats'),
        ];
    }
}
