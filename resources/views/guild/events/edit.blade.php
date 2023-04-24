@extends('main')
@section('page')
	@component('component.breadcrumbs', [
		'prev' => $guild->page_link,
		'curr' => 'Edit'
	]) @endcomponent
	@component('component.form', [
		'title' => 'Edit Event ' . $event->id,
		'method' => 'POST',
		'action' => $guild->page_link . '/' . $event->id,
		'submit' => 'Save Changes'
	])
    <div>
		<label>Name
    		<input type="text" name="name" value="{{ $event->name }}" required>
    	</label>
	</div>
    <div>
		<label>Description</label>
		<div text-angular ng-model="htmlVariable">{!! $event->description !!}</div>
		<textarea name="description" style="display:none;">@{{htmlVariable}}</textarea>
	</div>
    <div class="inline">
		<label>Start Date
            <input type="date" name="date" min="{{ date('Y-m-d') }}" style="width:160px" value="{{ $event->date }}" required>
    	</label>
        <label>Start Time
            <input type="time" name="time" style="width:130px" value="{{ $event->time }}">
    	</label>
	</div>
    <div>
		<label>Label Color
    	    <select name="color" required>
                @foreach([['value' => 'secondary', 'name' => 'Grey'],['value' => 'alert', 'name' => 'Red'],['value' => 'primary', 'name' => 'Blue'],['value' => 'success', 'name' => 'Green']] as $color)
                <option value="{{ $color['value'] }}" @if($color['value'] == $event->color) selected="selected" @endif>{{ $color['name'] }}</option>
                @endforeach
            </select>
    	</label>
	</div>
    <input type="hidden" name="_method" value="PUT"/>
	@endcomponent
@endsection
