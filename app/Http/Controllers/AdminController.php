<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
//use App\Models\Invite;

class AdminController extends GuildController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = $this->getUsers();
        $ranks = $this->getRanks();
        return $this->guildView('guild.admin.index', compact('users', 'ranks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        if($request->type == "perm") {
            $this->validate($request, [
                'user' => 'required|max:12',
                'perm' => 'required|max:12',
            ]);

            $admin = new Admin;
            $admin->guild_id = $this->guildId;
            $admin->user_id = $request->user;
            $admin->perm = $request->perm;
            $admin->save();
        } elseif($request->type == "invite") {
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ1234567890';
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 6; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            $code = implode($pass); //turn the array into a string

            $invite = new Invite;
            $invite->guild_id = $this->guildId;
            $invite->code = $code;
            $invite->save();
        }

        return redirect($this->guild->name_link . '/admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
