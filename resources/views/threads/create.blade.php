@extends('layouts.app')

@section('styles')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create A New Thread</div>
                    <div class="panel-body">
                        <form method="post" action="{{ route('threads.store') }}">
                            {{ csrf_field() }}

                            {{-- Channel_id Section::Start --}}
                            <div class="form-group">
                                <label for="channel_id">Choose A Channel</label>
                                <select id="channel_id" name="channel_id" class="form-control channel_id" placeholder="Select A Channel" required>
                                    <option value="">Choose One...</option>
                                    @foreach($channels as $channel)
                                        <option value="{{ $channel->id }}" {{ $channel->id == old('channel_id') ? 'selected' : '' }}>
                                            {{ $channel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Channel_id Section::End--}}


                            {{-- Title Section::Start --}}
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title" class="form-control title" placeholder="Title Here" value="{{ old('title') }}" required>
                            </div>
                            {{-- Title Section::End--}}
                            {{-- Body Section::Start --}}
                            <div class="form-group">
                                <label for="body">Body</label>
                                <wysiwyg name="body"></wysiwyg>
                            </div>
                            {{-- Body Section::End--}}

                            {{-- reCAPTCHA Section::Start--}}
                            <div class="g-recaptcha" data-sitekey="6Lf6_E8UAAAAAETubBZcI7el9R5RuaGl5pm-3xZe"></div>
                            {{-- reCAPTCHA Section::End--}}

                            <div class="form-group">
                                <button class="btn btn-success">Publish</button>
                            </div>
                            @if(count($errors))
                                <ul class="alert alert-danger list-unstyled">
                                    @foreach($errors->all() as $error)
                                        <li>
                                            {{ $error }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
