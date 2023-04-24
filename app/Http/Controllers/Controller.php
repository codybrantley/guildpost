<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Traits\AccountManager;
use App\Http\Controllers\Traits\GuildManager;
use App\Models\API;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use AccountManager, GuildManager;

    public function __construct() {
        $this->middleware('auth', ['only' => 'index']);
    }

    public function index() {
        $user = $this->getAccount();
        return view('home', compact('user'));
    }

    public function guildView($view, $content = false) {
    	return view($view, ['guild' => $this->guild, 'links' => $this->links])->with($content);
    }

    public function nameFromLink($input) {
        return ucwords(str_replace('-', ' ', $input));
    }

    public function nameToLink($input) {
        return strtolower(str_replace(' ', '-', $input));
    }
}
