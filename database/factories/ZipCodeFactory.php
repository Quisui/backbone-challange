<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ZipCode>
 */
class ZipCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $c_CP = [
            null,
            rand(0, 100),
        ];

        return [
            'd_codigo' => rand(10000, 99999),
            'd_asenta' => fake()->name(),
            'd_tipo_asenta' => fake()->city(),
            'D_mnpio' => fake()->city(),
            'd_estado' => fake()->state(),
            'd_ciudad' => fake()->city(),
            'd_CP' => rand(1000, 99999),
            'c_estado' => rand(0, 99),
            'c_oficina' => $c_CP[rand(0, 1)],
            'c_tipo_asenta' => rand(0, 100),
            'c_mnpio' => rand(0, 100),
            'id_asenta_cpcons' => fake()->numberBetween(0001, 9999),
            'c_cve_ciudad' => fake()->numberBetween(0, 10000),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
