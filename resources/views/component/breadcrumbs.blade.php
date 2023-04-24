<ul class="breadcrumbs">
    <li>Guild</li>
    @if(isset($prev))
    @php $arr = explode('/', $prev); @endphp
    <li><a href="{{ $prev }}">{{ end($arr) }}</a></li>
    <li>{{ $curr }}</li>
    @else
    <li>{{ $curr }}</li>
    @endif
</ul>
