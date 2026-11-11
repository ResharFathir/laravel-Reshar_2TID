<?php

namespace Tests\Feature;

<<<<<<< HEAD
// use Illuminate\Foundation\Testing\RefreshDatabase;
=======
use Illuminate\Foundation\Testing\RefreshDatabase;
>>>>>>> d53abf93a89ef8261a84f4a912e3af3d44be0ad7
use Tests\TestCase;

class ExampleTest extends TestCase
{
<<<<<<< HEAD
=======
    use RefreshDatabase;

>>>>>>> d53abf93a89ef8261a84f4a912e3af3d44be0ad7
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
