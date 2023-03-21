<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
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
        Storage::fake('local');
        $file=File::create('my_image.png');

        $data =
            [
                'title' => 'Some title',
                'description' => 'Description',
                'image' => $file
            ];
        $res = $this->post('/posts', $data);
        $res->assertOk();
        $this->assertDatabaseCount('posts', 1);
        $post=Post::first();
        $this->assertEquals($data['title'], $post->title);
        $this->assertEquals($data['description'], $post->description);
        $this->assertEquals($data['image'], $post->image);
    }
}
