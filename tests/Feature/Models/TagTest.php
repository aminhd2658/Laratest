<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Traits\ModelHelperTesting;
use Tests\TestCase;

class TagTest extends TestCase
{

    use ModelHelperTesting, RefreshDatabase;

    protected function model(): Model
    {
        return new Tag();
    }

    public function testTagRelationshipWithPost()
    {
        $count = rand(1, 10);

        $tag = Tag::factory()
            ->hasPosts($count)
            ->create();

        $this->assertCount($count,$tag->posts);
        $this->assertTrue($tag->posts->first() instanceof Post);
    }
}
