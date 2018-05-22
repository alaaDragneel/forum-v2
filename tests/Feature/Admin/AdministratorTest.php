<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

class AdministratorTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->withExceptionHandling();
    }

    /** @test */
    public function an_administrator_can_access_the_administrator_section()
    {
        $this->signInAsAdmin();

        $this->get(route('admin.dashboard.index'))->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function an_non_administrator_cannot_access_the_administrator_section()
    {
        $regularUser = create('App\User');

        $this->signIn($regularUser);

        $this->get(route('admin.dashboard.index'))->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
