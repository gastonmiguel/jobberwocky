<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subscription;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subscription::create([
            'email' => 'example1@test.com',
            'search_pattern' => 'Software Engineer',
        ]);

        Subscription::create([
            'email' => 'example2@test.com',
            'search_pattern' => 'Junior Developer',
        ]);

        Subscription::create([
            'email' => 'example3@test.com',
            'search_pattern' => null,
        ]);
    }
}
