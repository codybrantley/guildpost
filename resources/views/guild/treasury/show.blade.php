@extends('main')
@section('page')
@component('component.breadcrumbs', [
	'prev' => $guild->page_link,
	'curr' => 'Item Request #' . $request['id']
]) @endcomponent
<div class="request">
	<h4><img style="width: 50px;" src="{{ $request['data']['icon'] }}"> {{ $request['data']['name'] }}</h4>
	<b>{{ $request['count'] }}x</b> requested, <b>{{ $request['received'] }}x</b> received.<br />
	@foreach($have['found'] as $h)
		<b>{{ $h['count'] }}x</b> @if($h['source'] == 'material storage' || $h['source'] == 'bank')in your @else on your character @endif {{ $h['source'] }}<br />
	@endforeach
	<br />
	@if(count($have['found']) == 0)
	<div>Item was not found in your bank or material storage.</div>
	@endif
	<br />
	<div class="log">
		@if(count($request['contributed']) > 0)
		@foreach($request['contributed'] as $contributor)
		<span>{{ $contributor['count'] }}x was added by {{ $contributor['user'] }} on {{ date('m/d/Y \a\t\ h:i:s A', strtotime($contributor['time_added'])) }}
		@if($request['complete'] && date('Y-m-d H:i:s', strtotime($request['completed_at'])) == date('Y-m-d H:i:s', strtotime($contributor['time_added']))) and completed the requested. @endif</span>
		@endforeach
		@else
		<span>No contributions yet.</span>
		@endif
		<br>
	</div>
</div>
@if($guild->permission >= 3)
<div class="adminBar">
	<a href="{{ $guild->page_link }}/{{ $request['id'] }}/edit"><button class="button">Edit</button></a>&nbsp;&nbsp;
	<form style="display: inline-block;" method="POST" action="{{ $guild->page_link }}/{{ $request['id'] }}"><input type="hidden" name="_method" value="DELETE"/>{{ csrf_field() }}<button type="submit" class="button" onclick="javascript:return confirm('Are you sure you want to delete this request?')">Delete</button></form>
</div>
@endif
@endsection
