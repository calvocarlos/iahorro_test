<?php

namespace Database\Factories;

use App\Models\MortgageApplication;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class MortgageApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MortgageApplication::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fecha_creacion = Carbon::now()->subHours(rand(1, 10));
        $start_time_slot = $this->faker->numberBetween(0, 22);
        $end_time_slot = ($start_time_slot + rand(1, 8)) < 23 ? ($start_time_slot + rand(1, 8)) : 23;
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->email(),
            'phone_number' => $this->faker->e164PhoneNumber(),
            'net_income' => $this->faker->randomFloat(2, 20000, 150000),
            'requested_amount' => $this->faker->randomFloat(2, 150000, 1000000),
            'start_time_slot' => $start_time_slot,
            'end_time_slot' => $end_time_slot,
            'created_at' => $fecha_creacion,
            'updated_at' => $fecha_creacion,
        ];
    }
}
