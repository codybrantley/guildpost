@extends('main')
@section('page')
@component('component.breadcrumbs', [
	'curr' => 'News'
]) @endcomponent
<div class="row">
	<div class="large-8 columns">
		@foreach($news as $page)
		<div class="news-content">
			<h3><a href="{{ $guild->base_link }}/pages/{{ $page->slug }}">{{ $page->title }}</a><span class="subheader">{{ date('F jS, Y - h:i:s A', strtotime($page->created_at)) }}</span></h3>
			<p>{!! $page->content !!}</p>
		</div>
		<hr>
		@endforeach
		@if(count($news) == 0)
		<div class="news-content">
			No news.
		</div>
		@endif
	</div>
	<div class="large-4 columns">
		<div class="upcomingEvents">
			<h3>Upcoming Events</h3>
			<h4><span>Today</span></h4>
			<div>
				<h5>Fractal Runs</h5>
				<span>8pm - 10pm</span>
			</div>
			<h4><span>Tomorrow</span></h4>
			<div>
				<h5>Dungeons</h5>
				<span>10pm - 12pm</span>
			</div>
			<div>
				<h5>Officer Meeting</h5>
				<span>5pm - 6pm</span>
			</div>
		</div>
	</div>
</div>
@endsection
