<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

class API extends Model
{
    public static function get($endpoint, $auth = false, $leaderId = 0) {
        $gw2BaseEndpoint = 'https://api.guildwars2.com/v2/';
        $client = new \GuzzleHttp\Client(['base_uri' => $gw2BaseEndpoint, 'verify' => false]);
        $partial = '?access_token=';
        switch($auth) {
          case "local":
            $endpoint .= $partial . Auth::user()->api_key;
            break;
          case "leader":
            $endpoint .= $partial . $leaderId;
            break;
          default:
            // Do nothing
        }
        try {
            $request = $client->request('GET', $endpoint);
            $result = json_decode($request->getBody()->getContents());
            return $result;
        } catch (RequestException $e) {
            return [];
        } catch (ClientException $e) {
            return false;
        }
    }

    public static function do($method, $endpoint, $content = []) {
        $discordBaseEndpoint = 'https://discordapp.com/api/v6/';
        $client = new \GuzzleHttp\Client(['base_uri' => $discordBaseEndpoint, 'verify' => false]);
        $options = [
            'headers' => [
                'Authorization' => 'Bot ' . env('DISCORD_BOT_KEY')
            ]
        ];
        if(count($content) > 0) {
            $options['headers'] = array_merge($options['headers'], ['Content-Type' => 'application/json']);
            $options = array_merge($options, ['json' => $content]);
        }
        try {
            $request = $client->request($method, $endpoint, $options);
            $result = json_decode($request->getBody());
            return $result;
        } catch (RequestException $e) {
            return [];
        } catch (ClientException $e) {
            return false;
        }
    }
}
