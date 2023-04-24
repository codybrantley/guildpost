<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Page;

class PageController extends GuildController
{
    /**
     * Display all articles
     *
     * @return Response
     */
    public function index() {
        $categories = $this->getPageCategories();
        $pages = $this->getPages();
        return $this->guildView('guild.pages.articles', compact('categories', 'pages'));
    }

    /**
     * Display all news
     *
     * @return Response
     */
    public function news() {
        $news = $this->getNews();
        return $this->guildView('guild.pages.news', compact('news'));
    }

    /**
     * Show the form for creating a new page
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->getPageCategories();
        return $this->guildView('guild.pages.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:120',
            'description' => 'required|max:540',
            'date' => 'required',
            'time' => 'required',
            'color' => 'required'
        ]);

        $event = new Event;
        $event->guild_id = $this->guildId;
        $event->save();

        return redirect($this->guild->name_link . '/events/' . $event->id);
    }

    /**
     * Display a page
     *
     * @param  int  $id
     * @return Response
     */
    public function show($guild, $slug)
    {
        $page = $this->getPage($slug);
        return $this->guildView('guild.pages.show', compact('page'));
    }

    /**
     * Show the form for editing a page
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($guild, $id)
    {
        $event = $this->getEvent($id);
        $date_spl = explode(' ', $event->start);
        $event->date = $date_spl[0];
        $event->time = $date_spl[1];
        return $this->makeView('app.events.edit', compact('event'));
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
        $event->start = date('Y-m-d H:i:s', strtotime($request->date . ' ' . $request->time));
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
