<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Auth\Events\Registered;
use App\Contracts\HasUser;
use App\Repositories\UserRepository;
use App\Models\People;
use App\Models\User;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private $repository;

    public function setUp() : void
    {
        parent::setUp();
        $this->repository = app(UserRepository::class);
    }
    
    /** @test */
    public function it_validate_that_generate_user_method_accept_has_user_instance()
    {
        Event::fake();
        $people = People::factory()->create();
        $user = $this->repository->generateUser($people, '12345678');

        $this->assertInstanceOf(User::class, $user);
        $this->assertNotNull($user->model_id);
        $this->assertTrue(Str::isUuid($user->model_id));
        $this->assertEquals(get_class($people), $user->model_type);

    }

    /** @test */
    public function it_validate_that_registered_event_is_fired()
    {
        Event::fake();

        $people = People::factory()->create();
        $user = $this->repository->generateUser($people, '12345678');

        Event::assertDispatched(Registered::class);
        Event::assertDispatched(function (Registered $event) use ($user) {
            return $event->user->is($user);
        });
    }

}
