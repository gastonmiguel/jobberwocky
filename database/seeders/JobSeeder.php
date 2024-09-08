<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Job;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $skills = ['PHP', 'Java', 'OOP', 'Design Patterns', 'React', 'Angular', 'TypeScript'];

        foreach (range(1, 5) as $index) {
            Job::create([
                'title' => $faker->jobTitle,
                'description' => $faker->paragraph,
                'skills' => $faker->randomElements($skills, 3),
                'company' => $faker->company,
                'country' => $faker->country,
                'salary' => $faker->numberBetween(3000, 10000),
            ]);
        }
    }
}
