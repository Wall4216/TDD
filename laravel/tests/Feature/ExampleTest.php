<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     @test
     */

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
    }
}
