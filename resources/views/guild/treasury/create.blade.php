@extends('main')
@section('page')
	@component('component.breadcrumbs', [
		'prev' => $guild->page_link,
		'curr' => 'Create'
	]) @endcomponent
	@component('component.form', [
		'title' => 'Create New Item Request',
		'method' => 'POST',
		'action' => $guild->page_link,
		'submit' => 'Create',
		'another' => 'Create And Add Another'
	])
	<div>
		<label>Item
    		<select id="items" name="item_id" ng-model="item_id" ng-change="maxChange(item_id)">
    			<option value="" disabled>--Select One--</option>
    			@foreach($items as $item)
    			<option value="{{ $item['id'] }}" data-max="{{ $item['left'] }}">{{ $item['name'] }}</option>
    			@endforeach
    		</select>
			<p class="help">Treasury items that are maxed out or already requested have been redacted.</p>
    	</label>
	</div>
	<div>
		<label>Amount
    		<input type="number" ng-model="count" name="count" min="1" max="@{{ max }}">
			<p class="help" ng-show="maxhelp">Set to max needed at <a ng-click="inputChange(max)">@{{ max }}</a></p>
    	</label>
	</div>
	@endcomponent
@endsection
