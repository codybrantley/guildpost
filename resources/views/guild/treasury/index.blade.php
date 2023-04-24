@extends('main')
@section('page')
@component('component.breadcrumbs', [
	'curr' => $guild->page
]) @endcomponent
<ul class="tabs" data-deep-link="true" data-update-history="true" data-deep-link-smudge="true" data-deep-link-smudge="500" data-tabs id="deeplinked-tabs">
	<li class="tabs-title is-active"><a href="#treasury" aria-selected="true">Treasury</a></li>
	<li class="tabs-title"><a href="#contributors">Contributors</a></li>
</ul>
<div class="tabs-content">
	<div class="tabs-panel is-active" id="treasury">
		<div class="row collapse">
			<div class="large-12 columns">
				@foreach($treasury as $upgrade)
				<div class="upgrade">
					<div class="item" data-tip="<span style='font-size:14px'>{{ $upgrade['name'] }}</span><div style='height:3px'></div>{{ $upgrade['max'] }} Max">
						@if($upgrade['count'] == $upgrade['max']) <div class="overlay"></div> @endif
						<p class="count">{{ $upgrade['count'] }}</p>
						<img src="{{ $upgrade['icon'] }}">
						<div class="progress bar" role="progressbar" tabindex="0">
						  	<div class="progress-meter {{ $upgrade['color'] }}" style="width: {{ $upgrade['perc'] }}%"></div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection
