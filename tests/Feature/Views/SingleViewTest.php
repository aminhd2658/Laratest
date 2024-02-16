<?php

namespace Tests\Feature\Views;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SingleViewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testSingleViewRenderedWhenUserLoggedIn(): void
    {
        $post = Post::factory()->create();
        $comments = [];

        $view = (string)$this
            ->actingAs(User::factory()->create())
            ->view('single', compact('post', 'comments'));

        $dom = new \DOMDocument();
        $dom->loadHTML($view);
        $dom = new \DOMXPath($dom);
        $action = route('single.comment', $post->id);
        $query = $dom->query("//form[@method='post'][@action='$action']/textarea[@name='text']");
        $this->assertCount(1, $query);
    }
}
