<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lottery;
use App\Models\LotteryEntry;

class LotteryController extends GuildController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
		$lottery = $this->getLottery();
		if($lottery->entries) {
			$entries = json_decode(json_encode($lottery->entries), true);
			$lottery->names = array_column($entries, 'user_id');
			$ea = [];
			foreach($entries as $entry) {
				$ec = array_column($ea, 'user_id');
				if(!in_array($entry['user_id'], $ec)) {
					array_push($ea, $entry);
				}
			}
			$lottery->allentries = count($lottery->entries);
			$lottery->contestants = count($ea);
		} else {
			$lottery->names = false;
			$lottery->allentries = 0;
			$lottery->contestants = 0;
		}
		$lottery->current_pot = $lottery->starting_pot + $lottery->allentries * $lottery->entry;
        return $this->makeView('app.lottery.index', compact('lottery'));
    }

	public function settings()
	{
		$lottery = $this->getLottery();
		return $this->makeView('app.lottery.settings', compact('lottery'));
	}
}
