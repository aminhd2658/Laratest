<?php

namespace Tests\Feature\Views;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LayoutViewTest extends TestCase
{
    use RefreshDatabase;

    public function testLayoutViewRenderedWhenUserIsAdmin()
    {
        $user = User::factory()->state(['type' => 'admin'])->create();

        $this->actingAs($user);

        $view = $this->view('layouts.layout');

        $view->assertSee('<a href="/admin/dashboard">Admin Panel</a>', false);
    }

    public function testLayoutViewRenderedWhenUserIsNotAdmin()
    {
        $user = User::factory()->state(['type' => 'user'])->create();

        $this->actingAs($user);

        $view = $this->view('layouts.layout');

        $view->assertDontSee('<a href="/admin/dashboard">Admin Panel</a>', false);
    }
}
