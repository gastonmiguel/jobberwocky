<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Job;

class JobTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_job_can_be_created()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/api/jobs', [
            'title' => 'Software Engineer',
            'description' => 'Great job opportunity',
            'company' => 'Tech Corp',
            'skills' => json_encode(['PHP', 'Laravel']),
            'country' => 'USA',
            'salary' => 60000
        ]);

        $response->assertStatus(201);

        $this->assertCount(1, Job::all());
        $this->assertEquals('Software Engineer', Job::first()->title);
    }
}
