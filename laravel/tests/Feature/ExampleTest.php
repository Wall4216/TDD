<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     @test
     */
    use RefreshDatabase;
    public function a_post_can_be_stored()
    {
        $this->withoutExceptionHandLing();
        $data =
            [
                'title' => 'Some title',
                'description' => 'Description',
                'image' => 'avatar.png'
            ];
        $res = $this->post('/posts', $data);
        $res->assertOk();
        $this->assertDatabaseCount('posts', 1);
    }
}
