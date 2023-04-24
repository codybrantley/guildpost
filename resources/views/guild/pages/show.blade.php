@extends('main')
@section('page')
@php
if($page->category_id == 1)
	$link = $guild->base_link . '/news';
else
	$link = $guild->page_link;
@endphp
@component('component.breadcrumbs', [
	'prev' => $link,
	'curr' => 'View Page'
]) @endcomponent
<h3>{{ $page->title }}</h3>
@if(1 == 2)
<div class="adminBar">
	<a href="{{ $guild->page_link }}/{{ $page->id }}/edit"><button class="button">Edit</button></a>&nbsp;&nbsp;
	<form style="display: inline-block;" method="POST" action="{{ $guild->page_link }}/{{ $page->id }}"><input type="hidden" name="_method" value="DELETE"/>{{ csrf_field() }}<button type="submit" class="button" onclick="javascript:return confirm('Are you sure you want to delete this page?')">Delete</button></form>
</div>
@endif
<div ta-bind id="content">{!! $page->content !!}</div>
@endsection
