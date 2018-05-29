<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Channel;

class ChannelsController extends Controller
{
    /**
     * Show all channels.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $adminChannels = Channel::withCount('threads')->get();
        return view('admin.channels.index', ['adminChannels' => $adminChannels]);
    }

    /**
     * Show the form to create a new channel.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Channel $channel)
    {
        return view('admin.channels.create', compact('channel'));
    }


    /**
     * Store a new channel.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $validated = request()->validate([
            'name' => 'required|unique:channels',
            'description' => 'required',
        ]);
        $channel = Channel::create($validated + ['slug' => str_slug($validated['name'])]);
        
        cache()->forget('channels');
        
        if (request()->wantsJson()) {
            return response($channel, 201);
        }
        
        return redirect(route('admin.channels.index'))
            ->with('flash', 'Your channel has been created!');
    }

    public function archive(Channel $channel)
    {
        $channel->archived();

        cache()->forget('channels');

        return redirect(route('admin.channels.index'))
            ->with('flash', 'Channel has been archived!');
    }

    public function active(Channel $channel)
    {
        $channel->active();

        cache()->forget('channels');

        return redirect(route('admin.channels.index'))
            ->with('flash', 'Channel has been active!');
    }
}
