@extends('main')
@section('page')
	@component('component.breadcrumbs', [
		'prev' => $guild->page_link,
		'curr' => 'Create'
	]) @endcomponent
	@component('component.form', [
		'title' => 'Create New Event',
		'method' => 'POST',
		'action' => $guild->page_link,
		'submit' => 'Create'
	])
    <div>
		<label>Name
    		<input type="text" name="name" required>
    	</label>
	</div>
    <div>
		<label>Description</label>
		<div text-angular ng-model="htmlVariable"></div>
		<textarea name="description" style="display:none;">@{{htmlVariable}}</textarea>
	</div>
    <div class="inline">
		<label>Start Date
            <input type="date" name="date" ng-model="date" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" style="width:165px" required>
    	</label>
        <label>Start Time
            <input type="time" name="time" value="{{ date('h:i A') }}" style="width:130px">
    	</label>
	</div>
    <div>
		<label>Label Color
    	    <select name="color" required>
                <option value="secondary">Grey</option>
                <option value="alert">Red</option>
                <option value="primary">Blue</option>
                <option value="success">Green</option>
            </select>
    	</label>
	</div>
	<div>
		<input type="checkbox" ng-model="recurring"> Make Recurring
	</div>
	<div ng-show="recurring">
		<input ng-if="recurring" type="hidden" name="recurring" value="true">
		<div>Repeats
			<select name="repeat_type" ng-model="repeat" ng-init="repeat = 'days'">
				<option value="days">Daily</option>
				<option value="weeks">Weekly</option>
				<option value="months">Monthly</option>
				<option value="years">Yearly</option>
			</select>
		</div>
		<div>Repeat Every
			<select style="width:50px;display:inline-block;" name="repeat_every">
				@for($i=1;$i<=30;$i++)
				<option>{{ $i }}</option>
				@endfor
			</select> <span ng-show="repeat == 'days'">days</span><span ng-show="repeat == 'weeks'">weeks</span><span ng-show="repeat == 'months'">months</span><span ng-show="repeat == 'years'">years</span>
		</div>
		<div ng-show="repeat == 'weeks'">Repeat On<br>
			<input type="checkbox" ng-model="sun" name="repeat_on[]" value="0" ng-checked="(date | date:'EEE') == 'Sun'" ng-disabled="(date | date:'EEE') == 'Sun'"> S
			<input type="checkbox" ng-model="mon" name="repeat_on[]" value="1" ng-checked="(date | date:'EEE') == 'Mon'" ng-disabled="(date | date:'EEE') == 'Mon'"> M
			<input type="checkbox" ng-model="tue" name="repeat_on[]" value="2" ng-checked="(date | date:'EEE') == 'Tue'" ng-disabled="(date | date:'EEE') == 'Tue'"> T
			<input type="checkbox" ng-model="wed" name="repeat_on[]" value="3" ng-checked="(date | date:'EEE') == 'Wed'" ng-disabled="(date | date:'EEE') == 'Wed'"> W
			<input type="checkbox" ng-model="thu" name="repeat_on[]" value="4" ng-checked="(date | date:'EEE') == 'Thu'" ng-disabled="(date | date:'EEE') == 'Thu'"> T
			<input type="checkbox" ng-model="fri" name="repeat_on[]" value="5" ng-checked="(date | date:'EEE') == 'Fri'" ng-disabled="(date | date:'EEE') == 'Fri'"> F
			<input type="checkbox" ng-model="sat" name="repeat_on[]" value="6" ng-checked="(date | date:'EEE') == 'Sat'" ng-disabled="(date | date:'EEE') == 'Sat'"> S
			<input type="hidden" name="repeat_on[]" value="0" ng-if="(date | date:'EEE') == 'Sun'">
			<input type="hidden" name="repeat_on[]" value="1" ng-if="(date | date:'EEE') == 'Mon'">
			<input type="hidden" name="repeat_on[]" value="2" ng-if="(date | date:'EEE') == 'Tue'">
			<input type="hidden" name="repeat_on[]" value="3" ng-if="(date | date:'EEE') == 'Wed'">
			<input type="hidden" name="repeat_on[]" value="4" ng-if="(date | date:'EEE') == 'Thu'">
			<input type="hidden" name="repeat_on[]" value="5" ng-if="(date | date:'EEE') == 'Fri'">
			<input type="hidden" name="repeat_on[]" value="6" ng-if="(date | date:'EEE') == 'Sat'">
			<br>
			<div ng-show="(date | date:'EEE') == 'Sun' || sun">
				<input type="checkbox" ng-model="sun_d"> Change event time for Sunday
				<div ng-show="sun_d">
					<input type="time" name="time_change[]" style="width:130px">
				</div>
			</div>
			<div ng-show="(date | date:'EEE') == 'Mon' || mon">
				<input type="checkbox" ng-model="mon_d"> Change event time for Monday
				<div ng-show="mon_d">
					<input type="time" name="time_change[]" style="width:130px">
				</div>
			</div>
			<div ng-show="(date | date:'EEE') == 'Tue' || tue">
				<input type="checkbox" ng-model="tue_d"> Change event time for Tuesday
				<div ng-show="tue_d">
					<input type="time" name="time_change[]" style="width:130px">
				</div>
			</div>
			<div ng-show="(date | date:'EEE') == 'Wed' || wed">
				<input type="checkbox" ng-model="wed_d"> Change event time for Wednesday
				<div ng-show="wed_d">
					<input type="time" name="time_change[]" style="width:130px">
				</div>
			</div>
			<div ng-show="(date | date:'EEE') == 'Thu' || thu">
				<input type="checkbox" ng-model="thu_d"> Change event time for Thursday
				<div ng-show="thu_d">
					<input type="time" name="time_change[]" style="width:130px">
				</div>
			</div>
			<div ng-show="(date | date:'EEE') == 'Fri' || fri">
				<input type="checkbox" ng-model="fri_d"> Change event time for Friday
				<div ng-show="fri_d">
					<input type="time" name="time_change[]" style="width:130px">
				</div>
			</div>
			<div ng-show="(date | date:'EEE') == 'Sat' || sat">
				<input type="checkbox" ng-model="sat_d"> Change event time for Saturday
				<div ng-show="sat_d">
					<input type="time" name="time_change[]" style="width:130px">
				</div>
			</div>
		</div>
		<!-- <div>Repeats
			<select ng-model="repeat" ng-init="repeat = 'd'">
				<option value="d">Daily</option>
				<option value="w">Weekly</option>
				<option value="m">Monthly</option>
				<option value="y">Yearly</option>
			</select>
		</div>
		<div ng-show="repeat == 'd'">
			<div>Repeat Every
				<select style="width:50px;display:inline-block;">
					@for($i=1;$i<=30;$i++)
					<option>{{ $i }}</option>
					@endfor
				</select> days
			</div>
		</div>
		<div ng-show="repeat == 'w'">
			<div>Repeat Every
				<select style="width:50px;display:inline-block;">
					@for($i=1;$i<=30;$i++)
					<option>{{ $i }}</option>
					@endfor
				</select> weeks
			</div>
			<div>
			Repeat Every<br>
				<input type="checkbox"> S
				<input type="checkbox"> M
				<input type="checkbox"> T
				<input type="checkbox"> W
				<input type="checkbox"> T
				<input type="checkbox"> F
				<input type="checkbox"> S
			</div>
		</div>
		<div ng-show="repeat == 'm'">

		</div>
		<div ng-show="repeat == 'y'">

		</div>
		<div>
		Ends<br>
			<input type="radio" name="ends" ng-model="ends" value="never" ng-init="ends = 'never'"> Never<br>
			<input type="radio" name="ends" ng-model="ends" value="after"> After <input type="number" style="width:50px;display:inline-block;" ng-disabled="ends != 'after'"> occurences<br>
			<input type="radio" name="ends" ng-model="ends" value="on"> On <input type="date" style="width:165px;display:inline-block;" ng-disabled="ends != 'on'">
		</div> -->
	</div>
	@endcomponent
@endsection
