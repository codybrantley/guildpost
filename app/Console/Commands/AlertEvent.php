<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\API;
use \App\Guild;
use \App\Event;

class AlertEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alert:event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all events and send notifications for any upcoming events for all guilds';

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
        $today = strtotime(date('Y-m-d H:i:s'));
        foreach($guilds as $guild) {
            $events = Event::where('guild_id', $guild->guild_id)->get();
            if(count($events) > 0) {
                foreach($events as $event) {
                    $date = strtotime($event->start);
                    $diff = round(abs($today - $date) / 60);
                    $timePassed = $today > $date;
                    // If 15 minutes before event
                    if($diff == 15 && $timePassed == false) {
                        // Construct message
                        $content = [
                            'content' => "`Upcoming Event Notification`",
                            'embed' => [
                                'author' => [
                                    'name' => $event->name,
                                    'icon_url' => 'https://render.guildwars2.com/file/1273C427032320DDDB63062C140E72DCB0D9B411/502087.png'
                                ],
                                'title' => 'Event starts in 15 minutes',
                                'description' => 'View additional details by [clicking here.](http://guildpost.me/' . $guild->guild_name . '/events/' . $event->id . ')',
                                'color' => 12607588
                            ]
                        ];
                        // Send message to designated channel
                        API::discord('POST', 'channels/355958805445476353/messages', $content);
                    }
                }
            }
        }
        */
    }
}
