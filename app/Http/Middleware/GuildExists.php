<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Closure;
use Session;
use App\Models\API;
use App\Models\Guild;

class GuildExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(isset(Route::getRoutes()->match($request)->parameters['name'])) {
            $name = Route::getRoutes()->match($request)->parameters['name'];
            $name_readable = ucwords(str_replace('-', ' ', $name));
            $info = Guild::where('slug', $name)->first();
            $page = explode('.', Route::getRoutes()->match($request)->action['as'])[0];

            // If guild not created
            if(!$info) {
              // Search for guild existence
              $search = API::get('guild/search?name=' . urlencode($name_readable));
              if(!isset($search[0])) {
                  // If guild doesn't exist
                  return redirect()->route('error.notfound');
              }
              $info = Guild::where('guild_id', $search[0])->get();
              if(!isset($info[0])) {
                  // If guild not registered
                  return redirect('/guild/' . $name)->with('guild_id', $search[0]);
                  //return redirect()->route('error.notregistered')->with('guild_id', $search[0]);
              }
            }

            // Set guild values
            $guild = new \stdClass();
            $guild->guildId = $info->guild_id;
            $guild->leaderId = $info->leader_id;
            $guild->name = $name_readable;
            $guild->name_link = $name;
            $guild->page = $page;
            $guild->base_link = '/' . $name;
            $guild->page_link = '/' . $name . '/' . $page;

            // Send to session
            Session::flash('guild', $guild);
            return $next($request);
        } else {
            return $next($request);
        }
    }
}
