<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ReplyTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_has_an_owner()
    {
        $reply = create('App\Reply');

        $this->assertInstanceOf('App\User', $reply->owner);
    }

    /** @test */
    public function it_knows_if_it_was_just_published()
    {
        $reply = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    /** @test */
    public function it_can_detect_all_mentioned_users_in_the_body()
    {
        $reply = create('App\Reply', [
            'body' => 'Hallo @sasuke Look At This Man @moaalaa.',
        ]);

        $this->assertEquals(['sasuke', 'moaalaa'], $reply->mentionedUsers());
    }

    /** @test */
    public function it_wraps_mentioned_usernames_in_the_body_within_anchor_tags()
    {
        $reply = create('App\Reply', [
            'body' => 'Hallo @sasuke.',
        ]);

        $this->assertEquals(
            'Hallo <a href="' . asset('/profiles/sasuke') . '">@sasuke</a>.',
            $reply->body
        );
    }

    /** @test */
    public function it_knows_if_it_is_the_best_reply()
    {
        $reply = create('App\Reply');

        $this->assertFalse($reply->isBest());

        $reply->thread->update(['best_reply_id' => $reply->id]);

        $this->assertTrue($reply->fresh()->isBest());
    }


    /** @test */
    public function a_replies_body_is_sanitized_automatically()
    {
        $thread = make('App\Reply', ['body' => '<script>alert("bad")</script><h1>This Is Ok</h1>']);

        $this->assertEquals('<h1>This Is Ok</h1>', $thread->body);
    }

    /** @test */
    public function it_generates_the_correct_path_for_a_paginated_thread()
    {
        $thread = create('App\Thread');

        $replies = create('App\Reply', ['thread_id' => $thread->id], 3);

        config(['forum-v2.pagination.perPage' => 1]);

        $this->assertEquals(
            $thread->path() . '?page=1#reply-1',
            $replies->first()->path()
        );
        
        $this->assertEquals(
            $thread->path() . '?page=2#reply-2',
            $replies[1]->path()
        );
        
        $this->assertEquals(
            $thread->path() . '?page=3#reply-3',
            $replies->last()->path()
        );
    }
    
}
