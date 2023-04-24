<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\API;
use \App\Guild;
use \App\Contribute;
use \App\ItemRequest;

class UpdateTreasury extends Command
{
    use \App\Http\Controllers\Traits\GuildManager;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:treasury';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates contributor list of the treasury for all guilds';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$guilds = Guild::all();
		foreach($guilds as $guild) {
            $lg = API::get('guild/' . $guild->guild_id . '/log', 'leader', $guild->leader_id);
    		//$re = $this->getItemRequests($guild->guild_id);
    		$ls = [];
    		$bl = [];

    		// Prepopulate user from database
    		if($ct = $this->contributorsExist($guild->guild_id)) {
    			$con = json_decode($ct['contributors'], true);
    			$ls = array_merge($ls, $con);
    			$blk = json_decode($ct['blacklist'], true);
    			if(!is_array($blk)) { $blk = []; }
    			$bl = array_merge($bl, $blk);
    			$exists = true;
    		}

    		foreach($lg as $l) {
    			if($l->type == "treasury") {
    				// Search items if they match a current request
            /*
    				foreach($re as $r) {
    					$it = ItemRequest::find($r['id']);
    					$c = json_decode($it->contributed, true);
    					if($c) {
    						$i = array_column($c, 'id');
    						// If there is a match update the count of the request
    						if($r['item_id'] == $l->id && date('Y-m-d H:i:s', strtotime($l['time'])) >= date('Y-m-d H:i:s', strtotime($r['created_at'])) && !$r['complete'] && !in_array($l['id'], $i)) {
    							$it->received += $it->count;
    							if($it->received >= $it->count) {
    								$it->complete = true;
    								$it->completed_at = date('Y-m-d H:i:s');
    							}
    							array_push($c, $l);
    							$it->contributed = json_encode($c);
    							$it->save();
    						}
    					}
    				}
            */
    				// Combine duplicates & structure deposits
    				$lsc = array_column($ls, 'user');
    				$lsk = array_search($l->user, $lsc);
    				if(!in_array($l->id, $bl)) {
    					if(in_array($l->user, $lsc)) {
    						// Update user
    						$itl = array_column($ls[$lsk]['items'], 'item_id');
    						$itk = array_search($l->item_id, $itl);
    						if(in_array($l->item_id, $itl)) {
    							$dl = array_column($ls[$lsk]['items'][$itk]['deposits'], 'id');
    							if(!in_array($l->id, $dl)) {
    								// Add deposit
    								array_push($ls[$lsk]['items'][$itk]['deposits'], ['id' => $l->id, 'count' => $l->count, 'time' => $l->time]);
    								array_push($bl, $l->id);
    							}
    						} else {
    							// Add item
    							$data = $this->getItemFromStorage($l->item_id, true);
    							$total = $data['tp_buy_price'] * $l->count;
    							array_push($ls[$lsk]['items'], ['item_id' => $l->item_id, 'deposits' => [['id' => $l->id, 'count' => $l->count, 'time' => $l->time]], 'data' => $data]);
    						}
    					} else {
    						// Create user
    						$a['user'] = $l->user;
    						$data = $this->getItemFromStorage($l->item_id, true);
    						$a['items'] = [['item_id' => $l->item_id, 'deposits' => [['id' => $l->id, 'count' => $l->count, 'time' => $l->time]], 'data' => $data]];
    						array_push($ls, $a);
    					}
    				}
    			}
    		}

    		// Save data
    		if(isset($exists)) {
    			$ctb = Contribute::find($ct['id']);
    		} else {
    			$ctb = new Contribute;
    		}

        $top = $this->getGuildLog(false, $guild->guild_id);
        if($top) {
            $value = reset($top);
        }

    		$ctb->contributors = json_encode($ls);
    		$ctb->blacklist = json_encode($bl);
    		$ctb->guild_id = $guild->guild_id;
        //$ctb->top = json_encode($value);
    		$ctb->updated_at = date("Y-m-d H:i:s");
    		$ctb->save();
		}
    }
}
