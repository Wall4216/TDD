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

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
    }

    public function a_post_can_be_stored()
    {
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
        $this->assertEquals('/images' . $file->hashName(), $post->image);
        Storage::disk('local')->assertExists($post->image_url);
    }

    /** @test */

    public function attribute_title_is_required_for_storing_post()
    {
        $data = [
            'title' => 'fwfwf',
            'description' => 'Description',
            'image' => ''
        ];
        $res = $this->post('/posts', $data);

        $res->assertRedirect();
        $res->assertInvalid('title');
    }

    /** @test */

    public function attribute_image_is_required_for_storing_post()
    {

        Storage::fake('local');
        $data = [
            'title' => 'fwfwf',
            'description' => 'Description',
            'image' => 'oioio'
        ];
        $res = $this->post('/posts', $data);

        $res->assertRedirect();
        $res->assertInvalid('image');
    }
    /** @test */

    public function a_post_can_be_update()
    {
        $this->withoutExceptionHandling();
        $post = Post::factory()-create();
        $file = File::create('image.png');
        $data = [
            'title' => 'title edited',
            'description' => 'Description',
            'image' => $file,
        ];
        $res = $this->patch('/posts/', $post->id, $data);
        $updatePost = Post::first();
        $this->assertEquals($data['title'], $post->title);
        $this->assertEquals($data['description'], $post->description);
        $this->assertEquals('/images' . $file->hashName(), $post->image);
        $this->assertEquals($post->id, $updatePost->id);
    }

    /** @test */
    public function response_for_route_posts_index_is_view_post_index_with_posts()
    {
        $this->withoutExceptionHandling();
        $posts = Post::factory(10)->create();
        $posts->first->title = 'fpwipfwp';
        $res = $this->get('/posts');
        $res->assertViewIs('posts.index');
        $res->assertSeeText('View page');
        $titles = $posts->pluck('title')->toArray();
        $res->assertSeeText($titles);
    }

    /** @test */

    public function response_for_route_posts_show_is_view_post_index_with_post()
    {
        $this->withoutExceptionHandling();
        $post=Post::factory()->create();

    }
}
