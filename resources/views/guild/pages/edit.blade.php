@extends('main')
@section('page')
	@component('component.breadcrumbs', [
		'prev' => $guild->page_link,
		'curr' => 'Edit Page ' . $page->id
	]) @endcomponent
	@component('component.form', [
		'title' => 'Edit Page ' . $page->id,
		'method' => 'POST',
		'action' => $guild->page_link . '/' . $page->id,
		'submit' => 'Save Changes'
	])
    <div>
		<label>Title
    		<input type="text" name="title" value="{{ $page->title }}" required>
    	</label>
	</div>
    <div>
		<label>Category
    	    <select name="category" required>
                <option value="">--Select One--</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" @if($category->id == $page->category_id) selected="selected" @endif>{{ $category->name }}</option>
                @endforeach
            </select>
    	</label>
	</div>
	<div>
		<label>Content</label>
		<div text-angular ng-model="htmlVariable">{!! $page->content !!}</div>
		<textarea name="content" style="display:none;">@{{htmlVariable}}</textarea>
	</div>
    <input type="hidden" name="_method" value="PUT"/>
	@endcomponent
@endsection
