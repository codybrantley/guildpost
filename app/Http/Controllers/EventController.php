<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventRecurring;

class EventController extends GuildController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($guild = false, $month = false, $year = false)
    {
        $all_events = $this->getEvents();
        $calendar = $this->getCalendarData($month, $year);
        return $this->guildView('guild.events.index', compact('all_events', 'calendar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->guildView('guild.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $date = date_create($request->date);
        $dates = [];
        if($request->recurring) {
            $limit = 1000;
        } else {
            $limit = 1;
        }
        for($i=1;$i<=$limit;$i++) {
            if(count($dates) >= 1) {
                if(count($request->repeat_on) > 1) {
                    date_add($date,date_interval_create_from_date_string('1 day'));
                    if(in_array($date->format('w'), $request->repeat_on)) {
                        $add = true;
                    } else {
                        $add = false;
                    }
                } else {
                    date_add($date,date_interval_create_from_date_string($request->repeat_every . " " . $request->repeat_type));
                    $add = true;
                }
            } else {
                $add = true;
            }
            if(count($dates) > 1) {
                $date1 = date_create(reset($dates));
                $date2 = date_create(end($dates));
                $interval = $date1->diff($date2);
                // End loop if dates are 6 months apart
                if($interval->m == 6) {
                    break;
                }
            }
            if($add) {
                array_push($dates, $date->format('Y-m-d'));
            }
        }
        $this->validate($request, [
            'name' => 'required|max:120',
            'description' => 'required|max:540',
            'date' => 'required',
            'time' => 'required',
            'color' => 'required'
        ]);

        if($request->recurring) {
            $recurring = new EventRecurring;
            $recurring->last_event = end($dates);
            $recurring->save();
        }

        foreach($dates as $date) {
            $event = new Event;
            $event->guild_id = $this->guildId;
            $event->name = $request->name;
            $event->description = $request->description;
            $event->color = $request->color;
            if($request->recurring) {
                $event->recurring_id = $recurring->id;
                $format = date('w', strtotime($date));
                if($request->time_change[$format] != NULL) {
                    $time = $request->time_change[$format];
                } else {
                    $time = $request->time;
                }
            } else {
                $time = $request->time;
            }
            $event->starts_at = date('Y-m-d H:i:s', strtotime($date . ' ' . $time));
            $event->save();
        }

        return redirect($this->guild->name_link . '/events/' . $event->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($guild, $id)
    {
        if(strpos($id, ',')) {
            $event = $this->getSpecificEvents($id);
            return $this->guildView('guild.events.day', compact('event'));
        } else {
            $event = $this->getEvent($id);
            return $this->guildView('guild.events.show', compact('event'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($guild, $id)
    {
        $event = $this->getEvent($id);
        $date_spl = explode(' ', $event->starts_at);
        $event->date = $date_spl[0];
        $event->time = $date_spl[1];
        return $this->guildView('guild.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($guild, $id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:120',
            'description' => 'required|max:540',
            'date' => 'required',
            'time' => 'required',
            'color' => 'required'
        ]);

        $event = Event::find($id);
        $event->name = $request->name;
        $event->description = $request->description;
        $event->color = $request->color;
        $event->starts_at = date('Y-m-d H:i:s', strtotime($request->date . ' ' . $request->time));
        $event->save();

        return redirect($this->guild->name_link . '/events/' . $event->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($guild, $id)
    {
        $event = Event::find($id);
        $event->delete();

        return redirect($this->guild->name_link . '/events');
    }
}
