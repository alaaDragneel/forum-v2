<?php

namespace App;

class Reputation
{
    const THREAD_WAS_PUBLISHED = 15;
    const REPLY_POSTED = 2;
    const BEST_REPLY_AWARDED = 50;
    const REPLY_FAVORITED = 5;

    public static function award(User $user, $points)
    {
        $user->increment('reputation', $points);       
    }

    public static function revoking(User $user, $points)
    {
        $user->decrement('reputation', $points);
    }
}