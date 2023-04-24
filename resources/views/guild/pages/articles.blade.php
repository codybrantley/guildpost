@extends('main')
@section('page')
@component('component.breadcrumbs', [
	'curr' => $guild->page
]) @endcomponent
<div class="row collapse">
	@foreach($categories as $cat)
	@if($cat->name != "News")
	<ul class="pageList large-4 columns end">
		<li><h3>{{ $cat->name }}</h3>
			<ul>
				@foreach($pages as $page)
				@if($page->category_id == $cat->id)
				<a href="{{ $guild->page_link }}/{{ $page->slug }}"><li>{{ $page->title }}</li></a>
				@endif
				@endforeach
			</ul>
		</li>
	</ul>
	@endif
	@endforeach
</div>
@if(1 == 2)
<div class="adminBar">
	<a href="{{ $guild->page_link }}/create/"><button class="button">Create New Page</button></a>
</div>
@endif
@endsection
