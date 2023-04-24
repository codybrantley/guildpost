@extends('layouts.app')
@section('content')
<div class="container page cover">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default text-center">
                <div class="panel-heading"><h4>Oops, this guild isn't registered yet.</h4></div>

                <div class="panel-body">
                    @if(Auth::check())
                    <br>
                    <form method="POST" action="/register/{{ $guild }}">
                        <input type="hidden" name="name" value="{{ $guild }}">
                        <input type="hidden" name="guild_id" value="{{ $guild_id }}">
                        <input type="hidden" name="leader_id" value="{{ Auth::user()->api_key }}">
                        {{ csrf_field() }}
                        <button type="submit" class="button">Register Guild</button>
                    </form>
                    @else
                    If you are the leader of this guild, please login to your account and return to this page.
                    @endif
                    <p class="no-bottom">or <a href="/home">go back home.</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
