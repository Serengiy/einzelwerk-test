<?php

namespace Database\Seeders;

use App\Models\Contagent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContragentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'inn' => fake()->unique()->randomNumber(9),
                'name' =>  fake()->name,
                'ogrn' => fake()->unique()->randomNumber(9),
                'address' => fake()->address,
            ];
        }

        Contagent::query()->insert($data);
    }
}
