@extends('layouts.app')
@section('content')
<div class="header">
    <div class="top-bar">
        <div class="row">
            <div class="top-bar-right">
                <ul class="dropdown menu" data-dropdown-menu>
                    @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li>/</li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                    <li>
                        <a href="#">{{ Auth::user()->name }}</a>
                        <ul class="menu vertical">
                            <li><a href="{{ route('home') }}">My Guilds</a></li>
                            <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="row collapse">
        <div class="large-4 columns">
            <div class="banner">
                <img class="emblem" src="https://guilds.gw2w2w.com/guilds/{{ $guild->name_link }}/135.svg">
            </div>
            <h4 class="name">{{ $guild->name }}</h4>
        </div>
        <div class="large-8 columns">
            <ul class="navMenu">
                @foreach($links as $link)
                <li class="navTab"><a @if($guild->page == $link) class="isActive" @endif href="/{{ $guild->name_link }}/{{ $link }}"><span class="{{ $link }}"></span>{{ $link }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<div class="header-bottom"></div>
<div class="page">
    <div class="row collapse">
        <div class="large-12 columns">
            <nav aria-label="You are here:" role="navigation">
                @yield('page')
            </nav>
        </div>
    </div>
</div>
@endsection
