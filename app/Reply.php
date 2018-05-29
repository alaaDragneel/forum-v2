<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{

    use Favoritable, RecordsActivity;

    protected $guarded = [];
    protected $with = ['owner', 'favorites'];
    // protected $withCount = ['favorites'];
    protected $appends = ['favoritesCount', 'isFavorited', 'isBest'];

    public static function boot()
    {
        parent::boot();

        static::created(function ($reply) {
            $reply->thread->increment('replies_count');

            Reputation::award($reply->owner, Reputation::REPLY_POSTED);
        });


        static::deleted(function ($reply) {
            $reply->thread->decrement('replies_count');
            Reputation::revoking($reply->owner, Reputation::REPLY_POSTED);
        });
    }


    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread_id');
    }

    public function wasJustPublished()
    {
        return $this->created_at->gt(now()->subMinute());
    }

    public function mentionedUsers()
    {
        preg_match_all('/@([\w\-]+)/', $this->body, $matches);

        return $matches[1];

    }


    public function path()
    {
        $perPage = config('forum-v2.pagination.perPage'); // EX: 1
        
        $replyPosition = $this->thread->replies()->pluck('id')->search($this->id) + 1; // EX: 3 Note (+1) because it 0 based index

        $page = ceil($replyPosition / $perPage);

        return $this->thread->path() . "?page={$page}#reply-{$this->id}";
    }

    public function setBodyAttribute($body)
    {
        $this->attributes['body'] = preg_replace('/@([\w\-]+)/', '<a href="' . asset('/profiles/$1') . '">$0</a>', $body);
    }

    public function isBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }

    public function getBodyAttribute($body)
    {
        return \Purify::clean($body);
    }

}
