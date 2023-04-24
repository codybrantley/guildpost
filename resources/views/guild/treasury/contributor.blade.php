@extends('main')
@section('page')
@component('component.breadcrumbs', [
	'prev' => $guild->page_link,
	'curr' => $log['user']
]) @endcomponent
<h3>{{ $log['user'] }}</h3>
<div class="stats">
	<span class="number">{{ $log['count'] }}</span>
	<span class="desc">Items Contributed</span>
</div>
<div class="stats">
	<span class="number">{{ count($log['items']) }}</span>
	<span class="desc">Unique Items</span>
</div>
<div class="stats">
	<span class="number">{!! Formatter::gold($log['worth']) !!}</span>
	<span class="desc">Estimated Worth</span>
</div>
<div class="contributions">
	@foreach($log['items'] as $item)
	<div class="upgrade">
		<div class="item" data-tip="<span style='font-size:14px'>{{ $item['data']['name'] }}</span><div style='height:3px'></div>{{ Formatter::gold($item['worth']) }}">
			<p class="count">{{ $item['count'] }}</p>
			<img src="{{ $item['data']['icon'] }}">
		</div>
	</div>
	@endforeach
</div>
@endsection
