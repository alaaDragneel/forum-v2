<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PinThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function administrator_can_pin_thread()
    {
        $this->signInAsAdmin();

        $thread = create('App\Thread');

        $this->post(route('threads.pin.store', $thread));

        $this->assertTrue($thread->fresh()->pinned, 'Failed That The Thread Was Pinned');
    }

    /** @test */
    public function administrator_can_unpin_thread()
    {
        $this->signInAsAdmin();

        $thread = create('App\Thread');

        $this->delete(route('threads.pin.destroy', $thread));

        $this->assertFalse($thread->fresh()->pinned, 'Failed That The Thread Was Unpinned');
    }

    /** @test */
    public function pinned_threads_are_listed_first()
    {
        $threads = create('App\Thread', [], 3);
        $ids = $threads->pluck('id');

        $this->signInAsAdmin();

        $this->getJson(route('threads.index'))
            ->assertJson([
                'data' => [
                    ['id' => $ids[0]],
                    ['id' => $ids[1]],
                    ['id' => $ids[2]],
                ]
            ]);

        $this->post(route('threads.pin.store', $pinned = $threads->last()));

        $this->getJson(route('threads.index'))
            ->assertJson([
                'data' => [
                    ['id' => $pinned->id],
                    ['id' => $ids[0]],
                    ['id' => $ids[1]],
                ]
            ]);

    }
}