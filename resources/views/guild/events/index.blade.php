@extends('main')
@section('page')
@component('component.breadcrumbs', [
	'curr' => $guild->page
]) @endcomponent
@php
function getStartAndEndDate($week, $year) {
	$dto = new DateTime();
	$dto->setISODate($year, $week);
	$dto->modify('-1 days');
	$ret['start'] = $dto->format('Y-m-d');
	$dto->modify('+6 days');
	$ret['end'] = $dto->format('Y-m-d');
	return $ret;
}

function getDifferenceOfMonthEnd($currentDay, $weekEnd) {
	$diff = $currentDay->diff($weekEnd);
	return $diff->format('%R%a');
}
@endphp
<div class="row collapse">
	<div class="large-4 columns">
		<a href="{{ $guild->page_link }}/{{ date('m', $calendar->prevMonth) }}/{{ date('Y', $calendar->prevMonth) }}"><button class="button">{{ date('F', $calendar->prevMonth) }}</button></a>
	</div>
	<div class="large-4 columns">
		<h4 class="text-center">{{ $calendar->date->format('F') . " " . $calendar->date->format('Y') }}</h4>
	</div>
	<div class="large-4 columns">
		<a class="right" href="{{ $guild->page_link }}/{{ date('m', $calendar->nextMonth) }}/{{ date('Y', $calendar->nextMonth) }}"><button class="button">{{ date('F', $calendar->nextMonth) }}</button></a>
	</div>
</div>
<table class="calendar">
	<tr>
		<th>Sun</th>
		<th>Mon</th>
		<th>Tue</th>
		<th>Wed</th>
		<th>Thu</th>
		<th>Fri</th>
		<th>Sat</th>
	</tr>
	<tr>
	@foreach($calendar->days as $day)
		@php
		$currentDate = new DateTime($day);
		$week = getStartAndEndDate($currentDate->format("W"), $currentDate->format("Y"));
		$diff = getDifferenceOfMonthEnd($currentDate, new DateTime($week['end']));
		$dayNum = $currentDate->format('j');
		$events = [];
		foreach($all_events as $event) {
			if(date('Y-m-d', strtotime($event['start'])) == $day) {
				array_push($events, $event);
			}
		}
		usort($events, function($a, $b) {
		    return strcmp($a['start'], $b['start']);
		});
		@endphp
		@if($currentDate->format('Y-m-01') == $day && $currentDate->format('w') != 0)
		<td class="darken" colspan="{{ $currentDate->format('w') }}"></td>
		@endif
		@if($week['start'] == $day)
		<tr>
		@endif
		<td class="day @if(date('Y-m-d', strtotime($day)) == date('Y-m-d')) current @endif">
			<span class="num">{{ $dayNum }}</span>
			@foreach(array_slice($events, 0, 4) as $event)
			<a href="{{ $guild->page_link }}/{{ $event['id'] }}"><div class="event label {{ $event['color'] }}"><b>{{ Formatter::eventDate($event['start']) }}</b> {{ $event['name'] }}</div></a>
			@endforeach
			@if(count($events) > 4)
			<div class="more"><a href="{{ $guild->page_link }}/@foreach($events as $i){{ $i['id'] }},@endforeach"><b>+{{ count($events) - 4 }} more</b></a></div>
			@endif
		</td>
		@if($currentDate->format('Y-m-t') == $day && $diff != 0)
		<td class="darken" colspan="{{ $diff }}"></td>
		@endif
		@if($week['end'] == $day)
		</tr>
		@endif
	@endforeach
	</tr>
</table>
@if(1 == 2)
<div class="adminBar">
	<a href="{{ $guild->page_link }}/create/"><button class="button">Create New Event</button></a>
</div>
@endif
@endsection
