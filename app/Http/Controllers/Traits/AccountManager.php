<?php

namespace App\Http\Controllers\Traits;

use App\Models\API;

trait AccountManager
{
    public function getAccount() {
        $data = API::get('account', "local");
        $guilds = [];
        foreach($data->guilds as $key => &$guild) {
            if(isset($data->guild_leader) && in_array($guild, $data->guild_leader)) {
                $leader = true;
            } else {
                $leader = false;
            }
            $guildInfo = API::get('guild/'. $guild);
            $guildInfo->name_link = $this->nameToLink($guildInfo->name);
            array_push($guilds, ['id' => $guild, 'leader' => $leader, 'data' => $guildInfo]);
        }
        $data->guilds = $guilds;
        return $data;
    }

    public function getCharacters() {
        return API::get("characters", "local");
    }

    public function getMaterialStorage() {
        return API::get("account/materials", "local");
    }

    public function getBank() {
        return API::get("account/bank", "local");
    }

    public function getItemfromAccount($item_id) {
        $bank = $this->getBank();
        $mats = $this->getMaterialStorage();
        //$chars = $this->getCharacters();
        $have = [];
        $have['found'] = [];
        // Search item in bank
        foreach($bank as $b) {
            if(isset($b) && $b->id === $item_id) {
                $item = ['count' => $b->count, 'source' => "bank"];
                array_push($have['found'], $item);
            }
        }
        // Search item in material storage
        foreach($mats as $mat) {
            if($mat->id === $item_id) {
                if($mat->count > 0) {
                    $item = ['count' => $mat->count, 'source' => "material storage"];
                    array_push($have['found'], $item);
                }
            }
        }
        // Search item on all characters
        /*
        foreach($chars as $char) {
            $inventory = API::get("characters/" . $char . "/inventory", "local");
            foreach($inventory->bags as $bag) {
                if(isset($bag)) {
                    foreach($bag->inventory as $inv) {
                        if(isset($inv) && $inv->id === $item_id) {
                            $item = ['count' => $inv->count, 'source' => $char];
                            array_push($have['found'], $item);
                        }
                    }
                }
            }
        }
        */
        // Get max count of item
        $max = 0;
        foreach($have['found'] as $h) {
            $max += $h['count'];
        }
        $have['max'] = $max;
        return $have;
    }
}
