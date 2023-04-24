<h3>{{ $title }}</h3>
<form action="{{ $action }}" method="{{ $method }}">
    {{ $slot }}
    {{ csrf_field() }}
</form>
