@extends('main')
@section('page')
	@component('component.breadcrumbs', [
		'prev' => $guild->page_link,
		'curr' => 'Create'
	]) @endcomponent
	@component('component.form', [
		'title' => 'Create New Page',
		'method' => 'POST',
		'action' => $guild->page_link,
		'submit' => 'Create'
	])
    <new-page></new-page>
	@endcomponent
@endsection
