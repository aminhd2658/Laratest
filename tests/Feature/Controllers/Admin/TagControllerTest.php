<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagControllerTest extends TestCase
{

    use RefreshDatabase;

    protected array $middlewares = ['web', 'admin'];

    public function testIndexMethod(): void
    {
        Tag::factory(10)->create();

        $this->actingAs(User::factory()->admin()->create())
            ->get(route('tag.index'))
            ->assertOk()
            ->assertViewHas('tags', Tag::latest()->paginate(15))
            ->assertViewIs('admin.tag.index');

        $this->assertEquals(
            $this->middlewares,
            request()->route()->middleware()
        );
    }


    public function testCreateMethod(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->get(route('tag.create'))
            ->assertOk()
            ->assertViewIs('admin.tag.create');

        $this->assertEquals(
            $this->middlewares,
            request()->route()->middleware()
        );
    }

    public function testEditMethod(): void
    {
        $tag = Tag::factory()->create();
        $this->actingAs(User::factory()->admin()->create())
            ->get(route('tag.edit', $tag->id))
            ->assertOk()
            ->assertViewHas('tag', $tag)
            ->assertViewIs('admin.tag.edit');

        $this->assertEquals(
            $this->middlewares,
            request()->route()->middleware()
        );
    }


    public function testStoreMethod(): void
    {
        $user = User::factory()->admin()->create();
        $data = Tag::factory()->make()->toArray();

        $this->actingAs($user)
            ->post(route('tag.store'), $data)
            ->assertSessionHas('message', 'New tag has been created.')
            ->assertRedirect(route('tag.index'));

        $this->assertDatabaseHas('tags', $data);

        $this->assertEquals(
            $this->middlewares,
            request()->route()->middleware()
        );
    }


    public function testUpdateMethod(): void
    {
        $tag = Tag::factory()->create();
        $data = Tag::factory()->make()->toArray();

        $this->actingAs(User::factory()->admin()->create())
            ->patch(route('tag.update', $tag->id), $data)
            ->assertSessionHas('message', 'The tag has been updated.')
            ->assertRedirect(route('tag.index'));

        $this->assertDatabaseHas('tags', array_merge(['id' => $tag->id], $data));

        $this->assertEquals(
            $this->middlewares,
            request()->route()->middleware()
        );
    }


    public function testDestroyMethod(): void
    {
        $tag = Tag::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->delete(route('tag.destroy', $tag->id))
            ->assertSessionHas('message', 'The tag has been deleted.')
            ->assertRedirect(route('tag.index'));

        $this->assertDatabaseMissing('tags', $tag->toArray())
            ->assertEmpty($tag->posts);

        $this->assertEquals(
            $this->middlewares,
            request()->route()->middleware()
        );

    }

    public function testValidationRequestRequiredData(): void
    {
        $user = User::factory()->admin()->create();

        $data = [];
        $error = [
            'name' => 'The name field is required.'
        ];

        $this->actingAs($user)
            ->post(route('tag.store'), $data)
            ->assertSessionHasErrors($error);

        $this->actingAs($user)
            ->patch(route('tag.update', Tag::factory()->create()->id), $data)
            ->assertSessionHasErrors($error);
    }

}
