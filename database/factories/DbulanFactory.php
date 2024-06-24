<?php

namespace Database\Factories;

use App\Models\Danak;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DbulanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $danaks = Danak::inRandomOrder()->first();
        $users = User::where('id', '!=', 3)->inRandomOrder()->first();
        return [
            'users_id' => $users->id,
            'danaks_id' => $danaks->id,
            'umur_periksa' => $this->faker->randomElement(['0 tahun 6 bulan', '0 tahun 1 bulan', '0 tahun 12 bulan', '1 tahun 2 bulan', '3 tahun 4 bulan', '5 tahun 0 bulan']),
            'nama_posyandu' => 'Posyandu ' . sprintf('%02d', $danaks->dposyandu_id),
            'umur_tahun' => $this->faker->numberBetween(1, 4),
            'umur_bulan' => $this->faker->numberBetween(1, 12),
            'bb_anak' => $this->faker->numberBetween(10, 30),
            'tb_anak' => $this->faker->numberBetween(70, 120),
            'lk_anak' => $this->faker->numberBetween(35, 50),
            'll_anak' => $this->faker->numberBetween(10, 20),
            'st_anak' => $this->faker->randomElement(['Pendek', 'Normal', 'Tinggi']),
            'gz_anak' => $this->faker->randomElement(['Kelebihan Berat Badan', 'Obesitas', 'Normal', 'Gizi Kurang', 'Gizi Buruk',]),
            'c_ukur' => $this->faker->randomElement(['Berdiri', 'Telentang']),
            'created_at' =>$this->faker->dateTimeBetween('2024-01-01', '2024-12-31'),
        ];
    }
}
