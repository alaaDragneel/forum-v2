<?php

use Illuminate\Database\Seeder;
use App\Channel;
use App\Thread;
use App\Reply;
use App\ThreadSubscription;
use App\Activity;
use App\Favorite;
use Illuminate\Support\Facades\Schema;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $this->channels();
        $this->threads();
        Schema::enableForeignKeyConstraints();

    }

    public function channels()
    {
        Channel::truncate();

        factory(Channel::class, 10)->create();
    }

    public function threads()
    {
        Thread::truncate();
        Reply::truncate();
        ThreadSubscription::truncate();
        Activity::truncate();
        Favorite::truncate();

        factory(Thread::class, 50)->create();
    }
}
