<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChannelTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_channel_consists_of_threads ()
    {
        $channel = create('App\Channel');
        $thread = create('App\Thread', [ 'channel_id' => $channel->id ]);

        $this->assertTrue($channel->threads->contains($thread));
    }
    
    /** @test */
    public function a_channel_can_be_archived()
    {
        $channel = create('App\Channel');

        $this->assertFalse($channel->isArchived());

        $channel->archived();

        $this->assertTrue($channel->isArchived());
    }

    /** @test */
    public function a_channel_can_be_active()
    {
        $channel = create('App\Channel', ['archived' => true]);

        $this->assertTrue($channel->isArchived());
        
        $channel->active();

        $this->assertFalse($channel->isArchived());

    }
}
