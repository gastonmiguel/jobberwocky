<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_subscription()
    {

        $subscriptionData = [
            'email' => 'user@example.com',
            'search_pattern' => 'Engineer'
        ];

        $response = $this->post('/api/subscriptions', $subscriptionData);

        $response->assertStatus(201);

        $this->assertDatabaseHas('subscriptions', [
            'email' => 'user@example.com',
            'search_pattern' => 'Engineer'
        ]);
    }


    public function test_it_requires_an_email_to_create_a_subscription()
    {
        $response = $this->post('/api/subscriptions', [
            'search_pattern' => 'Developer'
        ]);

        $response->assertSessionHasErrors('email');
    }
}
