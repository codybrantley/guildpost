@extends('layouts.app')
@section('content')
<div class="container page cover">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel-default">
                <h3>Hello, {{ Auth::user()->game_id }}</h3>
                <h4 class="muted" style="margin-top: -11px;margin-bottom: 11px;font-weight:100;">Select Your Guild</h4>
                <ul class="guildList">
                @foreach($user->guilds as $guild)
                    <a href="{{ $guild['data']->name_link }}"><li>{{ $guild['data']->name }} [{{ $guild['data']->tag }}]</li></a>
                @endforeach
                </ul>
                @component('component.logout') @endcomponent
            </div>
        </div>
    </div>
</div>
@endsection
