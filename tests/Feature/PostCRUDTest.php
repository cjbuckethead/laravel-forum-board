<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostCRUDTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testFetchAllPosts()
    {
        $response = $this->get('/api/posts');

        $response->assertStatus(200);
    }

    public function testCreatingPost()
    {
        $response = $this->post('/api/posts');

        $response->assertStatus(200);
    }

    public function testRetrievingAPost()
    {
        $response = $this->get('api/posts/', ['id' => 1]);

        $response->assertStatus(200);
    }

    public function testUpdatingPost()
    {
        $response = $this->patch('api/posts', ['id' => 1]);

        $response->assertStatus(200);
    }


}
