<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\API;
use \App\Guild;
use \App\Lottery;
use \App\LotteryEntry;

class UpdateLottery extends Command
{
    use \App\Http\Controllers\Traits\GuildManager;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:lottery';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates lottery entries for all guilds';

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
       /*
        $guilds = Guild::all();
        foreach($guilds as $guild) {
            $lg = API::get('guild/' . $guild->guild_id . '/log', 'leader', $guild->leader_id);
            $lt = $this->getLottery($guild->guild_id);

            // Only run if lottery is active
            if($lt->active) {
                $start = strtotime($lt->start);
                $end = strtotime($lt->end);
                $today = strtotime(date('Y-m-d H:i:s'));

                // Enter new entries
                foreach($lg as $k => $l) {
                    $time = strtotime($l->time);
                    if(!isset($l->operation) || $l->type != "stash" && $l->operation != "deposit" || $l->coins == 0) {
                        unset($lg[$k]);
                    }
                    if($start >= $time && $time <= $end) {
                        unset($lg[$k]);
                    }
                    if(isset($l->coins) && $l->coins !== $lt->entry) {
                        unset($lg[$k]);
                    }
                }

                foreach($lg as $entry) {
                    $le = LotteryEntry::where('user_id', $entry->user)->get();
                    if(count($le) == 0) {
                        $ne = new LotteryEntry;
                        $ne->lottery_id = $lt->id;
                        $ne->user_id = $entry->user;
                        $ne->save();
                    }
                }

                // Pick winner if lottery ended
                if($today == $end) {
                    $entries = json_decode(json_encode($lt->entries), true);
                    $winner = $entries[array_rand($entries)]['user_id'];
                    $jackpot = \Formatter::gold($lt->starting_pot + count($entries) * $lt->entry, true, true);
                    $content = [
                        'content' => '[LOTTERY] The lottery has concluded and the winner is... ' . $winner . '! Winning the final jackpot of ' . $jackpot
                    ];
                    $endLottery = Lottery::find($lt->id);
                    $endLottery->active = 0;
                    $endLottery->save();
                    API::discord('POST', 'channels/355958805445476353/messages', $content);
                }
            }
        }
        */
    }
}
