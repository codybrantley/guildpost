@extends('main')
@section('page')
@component('component.breadcrumbs', [
	'prev' => $guild->page_link,
	'curr' => $event['name']
]) @endcomponent
<h3>{{ $event['name'] }}</h3>
@if(strlen($event['description']) > 0)
<p>{!! $event['description'] !!}</p>
@else
<p>No description.</p>
@endif
<h4>Event Time</h4>
<p>{{ date('l, F jS @ h:i a', strtotime($event['start'])) }}</p>
@if($guild->permission >= 3)
<div class="adminBar">
	<a href="{{ $guild->page_link }}/{{ $event['id'] }}/edit"><button class="button">Edit</button></a>&nbsp;&nbsp;
	<form style="display: inline-block;" method="POST" action="{{ $guild->page_link }}/{{ $event['id'] }}"><input type="hidden" name="_method" value="DELETE"/>{{ csrf_field() }}<button type="submit" class="button" onclick="javascript:return confirm('Are you sure you want to delete this event?')">Delete</button></form>
</div>
@endif
@endsection
