<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin\Admin>
 */
class AdminFactory extends Factory
{
    protected $model = Admin::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'firstname'     => $this->faker->firstName(),
            'lastname'      => $this->faker->lastName(),
            'username'      => $this->faker->userName(),
            'email'         => $this->faker->email(),
            'password'      => Hash::make("rokondev"),
            'status'        => true,
            'phone'         => $this->faker->phoneNumber(),
            'created_at'    => now(),
        ];
    }
}
