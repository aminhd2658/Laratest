<?php

namespace Tests\Feature\Middlewares;

use App\Http\Middleware\CheckUserIsAdmin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class CheckUserIsAdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function testWhenUserIsNotAdmin(): void
    {
        $user = User::factory()
            ->user()
            ->create();

        $this->actingAs($user);
        $request = Request::create('/admin');
        $middleware = new CheckUserIsAdmin();

        $response = $middleware->handle($request, function () {
        });

        $this->assertEquals(ResponseAlias::HTTP_FOUND, $response->getStatusCode());
    }

    public function testWhenUserIsAdmin(): void
    {
        $user = User::factory()
            ->admin()
            ->create();
        $this->actingAs($user);
        $request = Request::create('/admin');

        $middleware = new CheckUserIsAdmin();
        $response = $middleware->handle($request, function () {
        });

        $this->assertEquals(null, $response);
    }

    public function testWhenUserNotLoggedIn(): void
    {
        $request = Request::create('/admin');

        $middleware = new CheckUserIsAdmin();
        $response = $middleware->handle($request, function () {
        });

        $this->assertEquals(ResponseAlias::HTTP_FOUND, $response->getStatusCode());
    }
}
