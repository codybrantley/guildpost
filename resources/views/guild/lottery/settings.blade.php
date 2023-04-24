@extends('main')
@section('page')
@if($guild->permission >= 3)
<div class="row collapse">
	<div class="large-12 columns">
		Lottery is currently <span class="red">inactive</a>.
	</div>
</div>
@endif
@endsection
