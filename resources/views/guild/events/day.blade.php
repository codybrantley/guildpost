@extends('main')
@section('page')
@component('component.breadcrumbs', [
	'prev' => $guild->page_link,
	'curr' => 'Events on ' . date('l, F jS', strtotime($event[0][0]->start))
]) @endcomponent
@foreach($event as $e)
<h3><span class="label secondary eventTag">{{ date('h:i a', strtotime($e[0]->start)) }}</span> <a href="{{ $guild->page_link }}/{{ $e[0]->id }}">{{ $e[0]->name }}</a></h3>
@if(strlen($e[0]->description) > 0)
<p>{!! $e[0]->description !!}</p>
@else
<p>No description.</p>
@endif
<hr>
@endforeach
@endsection
