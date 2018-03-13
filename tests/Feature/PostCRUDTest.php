<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostCRUDTest extends TestCase
{
    /**
     * Tests GET `/api/posts` endpoint.
     */
    public function testFetchAllPosts()
    {
        $response     = $this->get('/api/posts');
        $responseData = $response->getContent();

        $this->assertJson($responseData);
        $response->assertStatus(200);
    }

    /**
     * Tests POST `/api/posts` endpoint.
     */
    public function testSuccessfulCreationOfPost()
    {
        $data = [
            'title'    => $this->faker->sentence,
            'contents' => $this->faker->paragraph,
        ];

        $response = $this->post('/api/posts', $data);
        $response->assertJson(['status' => 'success']);
        $response->assertStatus(200);
    }

    /**
     * Erroneous test to POST `/api/posts` endpoint.
     */
    public function testInvalidInputWhenCreatingAPost()
    {
        $data = [];

        $response = $this->json('POST', '/api/posts', $data);
        $response->assertStatus(422);
    }

    /**
     * Test GET `/api/posts/post_id` endpoint.
     */
    public function testRetrievingAPost()
    {
        $data     = [
            'title'    => $this->faker->sentence,
            'contents' => $this->faker->paragraph,
        ];
        $post     = Post::create($data);
        $response = $this->get('api/posts/' . $post->id);

        $responseData = json_decode($response->getContent(), true)['post'];
        $this->assertEquals($data, [
            'title'    => $responseData['title'],
            'contents' => $responseData['contents']
        ]);
        $response->assertStatus(200);
    }

    /**
     * Test GET `/api/posts/post_id` endpoint.
     */
    public function testRetrievingPostWithInvalidId()
    {
        $response = $this->get('api/posts/200');

        $response->assertStatus(404);
    }

    /**
     * Test PATCH `/api/posts/post_id` endpoint.
     */
    public function testUpdatingPost()
    {
        $data        = [
            'title'    => $this->faker->sentence,
            'contents' => $this->faker->paragraph,
        ];
        $newContent  = $this->faker->paragraph;
        $post        = Post::create($data);
        $response    = $this->patch('api/posts/' . $post->id, [
            'title'    => $post->title,
            'contents' => $newContent
        ]);
        $updatedPost = Post::find($post->id);

        $this->assertNotEquals($post->toArray(), $updatedPost->toArray());
        $response->assertStatus(200);
    }

    /**
     * Test PATCH `/api/posts/post_id` endpoint.
     */
    public function testUpdatingPostWithInvalidId()
    {
        $newContent = $this->faker->paragraph;
        $response   = $this->patch('api/posts/200', [
            'title'    => '',
            'contents' => $newContent
        ]);
        $response->assertStatus(404);
    }

    /**
     * Test PATCH `/api/posts/post_id` endpoint.
     */
    public function testUpdatingOfPostWithInvalidInput()
    {
        $data        = [
            'title'    => $this->faker->sentence,
            'contents' => $this->faker->paragraph,
        ];
        $post        = Post::create($data);
        $response    = $this->json('PATCH', 'api/posts/' . $post->id, [
            'title' => ''
        ]);
        $updatedPost = Post::find($post->id);

        $this->assertNotEquals($post->toArray(), $updatedPost->toArray());
        $response->assertStatus(422);
    }
}
