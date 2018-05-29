<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Psy\CodeCleaner\AssignThisVariablePass;

class ChannelsAdministratorTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->withExceptionHandling();
    }

    /** @test */
    public function an_administrator_can_access_the_channel_administrator_section()
    {
        $this->signInAsAdmin();

        $this->get(route('admin.channels.index'))->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function an_non_administrator_cannot_access_the_channels_section()
    {
        $regularUser = create('App\User');

        $this->signIn($regularUser);

        $this->get(route('admin.channels.index'))->assertStatus(Response::HTTP_FORBIDDEN);
        $this->get(route('admin.channels.create'))->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function an_administrator_can_create_a_channel()
    {
        $response = $this->createChannel([
            'name' => 'php',
            'description' => 'This Channel Has A Description'
        ]);

        $this->get($response->headers->get('Location'))
            ->assertSee('php')
            ->assertSee('This Channel Has A Description');
    }

    /** @test */
    public function non_administrator_can_archive_channel()
    {
        $channel = create('App\Channel');
        $this->patch(route('admin.channels.archive', $channel))->assertStatus(Response::HTTP_FORBIDDEN);
    }
    
    /** @test */
    public function an_administrator_can_archive_channel()
    {
        $this->signInAsAdmin();

        $channel = create('App\Channel');

        $this->patch(route('admin.channels.archive', $channel));

        $this->assertTrue($channel->fresh()->archived);
    }

    /** @test */
    public function an_administrator_can_active_channel()
    {
        $this->signInAsAdmin();

        $channel = create('App\Channel', ['archived' => true]);

        $this->patch(route('admin.channels.active', $channel));

        $this->assertFalse($channel->fresh()->archived);
    }

    /** @test */
    public function a_channel_require_a_name()
    {
        $response = $this->createChannel([ 'name' => null ])
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_channel_require_a_description()
    {
        $response = $this->createChannel([ 'description' => null ])
            ->assertSessionHasErrors('description');
    }

    protected function createChannel($overrides = [])
    {
        
        $this->signInAsAdmin();

        $channel = make('App\Channel', $overrides);

        return $this->post(route('admin.channels.store'), $channel->toArray());
    }
}
