<?php

namespace Database\Factories;

use App\Models\Guru;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Guru>
 */
class GuruFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nip' => fake()->unique()->numerify('19########'),
            'nama' => fake()->name(),
            'mata_pelajaran' => fake()->randomElement(['Matematika', 'Bahasa Indonesia', 'Fisika', 'Biologi']),
            'no_hp' => fake()->phoneNumber(),
            'alamat' => fake()->address(),
            'status' => 'aktif',
        ];
    }
}
