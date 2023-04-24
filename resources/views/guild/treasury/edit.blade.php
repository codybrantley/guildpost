@extends('main')
@section('page')
	@component('component.breadcrumbs', [
		'prev' => $guild->page_link,
		'curr' => 'Edit'
	]) @endcomponent
	@component('component.form', [
		'title' => 'Edit Request #' . $item->id,
		'method' => 'POST',
		'action' => $guild->page_link . '/' . $item->id,
		'submit' => 'Save Changes'
	])
	<div>
		<label>Item
    		<select id="items" name="item_id" value="{{ $item->item_id }}" disabled>
                <option>{{ $item->data['name'] }}</option>
    		</select>
    	</label>
	</div>
	<div>
		<label>Amount
    		<input type="number" name="count" min="1" max="{{ $item->max }}" value="{{ $item->count }}">
    	</label>
	</div>
    <input type="hidden" name="_method" value="PUT"/>
	@endcomponent
@endsection
