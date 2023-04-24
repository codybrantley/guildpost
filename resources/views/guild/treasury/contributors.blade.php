@extends('main')
@section('page')
@component('component.breadcrumbs', [
	'prev' => $guild->page,
	'curr' => 'Contributors'
]) @endcomponent
<div class="tabs-panel is-active" id="contributors">
  <table class="leaderboard">
    <tr class="text-left">
      <th>Name</th>
      <th>Total Items Contributed</th>
      <th>Total Estimated Worth*</th>
    </tr>
    @if($log)
      @foreach($log as $key => $item)
      <tr>
        <td><a href="{{ $guild->base_link }}/treasury/contributors/{{ $item['key'] }}">{{ $item['user'] }}</a></td>
      <td>{{ $item['count'] }}</td>
      <td>{!! Formatter::gold($item['worth']) !!}</td>
      </tr>
      @endforeach
    @else
    <tr>
      <td colspan="3">No contributions currently logged.</td>
    </tr>
    @endif
    </table>
    <p class="footnote">* excludes account bound items, or any other items that have no trading post value. Total is calculated from prices at the time of entry.
</div>
@endsection
