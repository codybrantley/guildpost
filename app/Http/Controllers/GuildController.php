<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\API;

class GuildController extends Controller
{
    public function __construct() {
        $this->authenticateGuild();
    }

    public function guild_register($guild) {
        $guild_id = $this->searchGuild($this->nameFromLink($guild));
        if($guild_id)
            return view('error.notregistered', compact('guild', 'guild_id'));
        else
            return redirect('/guild/notfound');
    }

    public function guild_create(Request $request) {
        $this->createGuild($request->guild_id, $request->leader_id);
        return redirect('/' . $request->name);
    }

    public function guild_notfound() {
        return view('error.notfound');
    }
}
