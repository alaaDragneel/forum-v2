@extends('admin.layout.app') 
@section('administration-content')

<p><a class="btn btn-sm btn-default" href="{{ route('admin.channels.create') }}">New Channel <span class="glyphicon glyphicon-plus"></span></a></p>

<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Slug</th>
            <th>Description</th>
            <th>Threads</th>
            <th>Archive</th>
        </tr>
    </thead>
    <tbody>
        @forelse($adminChannels as $channel)
        <tr class="{{ ($channel->isArchived()) ? 'danger' : '' }}">
            <td>{{$channel->name}}</td>
            <td>{{$channel->slug}}</td>
            <td>{{$channel->description}}</td>
            <td>{{ $channel->threads_count }}</td>
            <td>
                @if ($channel->isArchived())
                    <form action="{{ route('admin.channels.active', $channel) }}"  method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <button type="submit" class="btn btn-success btn-xs">Active</button>
                    </form>
                @else
                    <form action="{{ route('admin.channels.archive', $channel->slug) }}"  method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <button type="submit" class="btn btn-danger btn-xs">Archive</button>
                    </form>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td>Nothing here.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection