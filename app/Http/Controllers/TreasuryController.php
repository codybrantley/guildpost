<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use App\Models\ItemRequest;
use App\Models\Contribute;
use Session;

class TreasuryController extends GuildController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $treasury = $this->getGuildTreasury();
        return $this->guildView('guild.treasury.index', compact('treasury'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $items = $this->getGuildTreasury();
        $requests = array_column($this->getItemRequests(), 'item_id');
        $upgrades = $this->getUpgradesFromStorage();
        $filtered = [];
        foreach($items as $item) {
            if($item['max'] != $item['count'] && !in_array($item['id'], $requests)) {
                $item['left'] = $item['max'] - $item['count'];
                array_push($filtered, $item);
            }
        }
        return $this->makeView('app.upgrades.create', ['items' => $filtered, 'upgrades' => $upgrades]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'item_id' => 'required|max:12',
            'count' => 'required|max:12',
        ]);

        $item = new ItemRequest;
        $item->guild_id = $this->guildId;
        $item->item_id = $request->item_id;
        $item->count = $request->count;
        $item->received = 0;
        $item->complete = 0;
        $item->contributed = "";
        $item->save();

        return redirect($this->guild->name_link . '/upgrades');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($guild, $id)
    {
        $request = $this->getItemRequest($id);
        $request['contributed'] = json_decode($request['contributed'], true);
        $have = $this->getItemfromAccount($request['data']['id']);
        return $this->makeView('app.upgrades.show', compact('request', 'have'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function contributors($guild)
    {
        $log = $this->getGuildLog();
        return $this->guildView('guild.treasury.contributors', compact('log'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function contributor($guild, $id)
    {
        $log = $this->getGuildLog($id);
        return $this->guildView('guild.treasury.contributor', compact('log'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($guild, $id)
    {
        $items = $this->getGuildTreasury();
        $item = ItemRequest::find($id);
        $columns = array_column($items, 'item_id');
        $key = array_search($item->item_id, $columns);
        $item->data = $this->getItemFromStorage($item->item_id);
        $item->max = $items[$key]['max'] - $items[$key]['have'];
        return $this->makeView('app.upgrades.edit', compact('item'));
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
            'count' => 'required|max:12'
        ]);

        $item = ItemRequest::find($id);
        $item->count = $request->count;
        $item->save();

        return redirect($this->guild->name_link . '/upgrades');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($guild, $id)
    {
        $item = ItemRequest::find($id);
        $item->delete();

        return redirect($this->guild->name_link . '/upgrades');
    }
}
