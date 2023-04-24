@extends('main') @section('page') @component('component.breadcrumbs', [ 'curr' => $guild->page ]) @endcomponent
<ul class="tabs" data-deep-link="true" data-update-history="true" data-deep-link-smudge="true" data-deep-link-smudge="500" data-tabs id="deeplinked-tabs">
    <li class="tabs-title is-active"><a href="#current" aria-selected="true">Current Lottery</a></li>
    <li class="tabs-title"><a href="#previous">Previous Winners</a></li>
</ul>
<div class="tabs-content" data-tabs-content="deeplinked-tabs">
    <div class="tabs-panel is-active" id="current">
        <div class="row collapse">
            <div class="large-12 columns">
                <div class="lotteryBox">
                    @if($lottery->active)
                    <p class="entered">
                        @if($lottery->name != false && in_array(Auth()->user()->game_id, $lottery->names)) You are entered in this lottery. Good luck! @endif
                    </p>
                    <div class="card-section">
                        <div class="row collapse">
                            <div class="large-8 columns">
                                <div class="row collapse">
                                    <div class="large-6 columns">
                                        <h2>{!! Formatter::gold($lottery->current_pot) !!}</h2>
                                        <h4>Current Jackpot *</h4>
                                    </div>
                                    <div class="large-6 columns">
                                        <h2>{{ $lottery->contestants }}</h2>
                                        <h4>Contestants</h4>
                                    </div>
                                </div>
                                <div class="row collapse">
                                    <div class="large-2 columns">
                                        <h2>{!! Formatter::gold($lottery->entry, false, true) !!}</h2>
                                        <h4>Entry Fee</h4>
                                    </div>
                                    <div class="large-4 columns">
                                        <h2>{{ $lottery->maxentry }}
                                            <h2>
                                                <h4>Max Entries Per Person</h4>
                                    </div>
                                    <div class="large-6 columns">
                                        <h2>{{ date('m/d ga T', strtotime($lottery->end)) }}</h2>
                                        <h4>Winner Announced</h4>
                                    </div>
                                </div>
                                <p class="footnote">* Jackpot calculated before the {{ $lottery->tax }}% guild tax that is applied after lottery has ended.</p>
                            </div>
                            <div class="large-4 columns">
                                <div class="sticky">
                                    <h3>Lottery Instructions</h3>
                                    <p>To enter, follow these steps:</p>
                                    <ol type="1">
                                        <li>Go to the guild hall and visit the vault.</li>
                                        <li>Deposit <b>{{ Formatter::gold($lottery->entry, true, true) }}</b>in to the guild stash.</li>
                                        <li>For multiple entries, enter <i>seperate</i> deposits of the entry fee for each one to be counted.</li>
                                        <li>Good luck!</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        @else
                        <h3 class="text-center">No lottery in progress. Check back later.</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tabs-panel" id="previous">
		<table>
			<tr>
				<th>Lottery Date</th>
				<th>Winner</th>
				<th>Jackpot</th>
			</tr>
			@foreach($lottery->history as $lotto)
				<tr>
					<td>{{ date('Y/m/d', strtotime($lotto->end)) }}</td>
					<td>{{ $lotto->winner }}</td>
					<td>{!! Formatter::gold($lotto->jackpot) !!}</td>
				</tr>
			@endforeach
		</table>
    </div>
</div>
@if($guild->permission >= 8)
<br />
<div class="adminBar">
    <a href="{{ $guild->page_link }}/settings/"><button class="button">Lottery Settings</button></a>
</div>
@endif @endsection
