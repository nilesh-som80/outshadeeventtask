<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\EventInvite;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEventsRequest;
use App\Http\Requests\UpdateEventsRequest;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Events::with("user")->paginate(15);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEventsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventsRequest $request)
    {
        // dd($request->user());
        $request["user_id"] = $request->user()->id;

        Events::create($request->all());
        return "New Event Created Successfully";

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function show(Events $event)
    {

        return $event->with("user")->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function edit(Events $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventsRequest  $request
     * @param  \App\Models\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventsRequest $request, Events $event)
    {
        $event->update($request->all());
        return $event->name." updated successfully";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function destroy(Events $event)
    {
        $event->delete();
        $eventInvite = EventInvite::where("events_id",$event->id)->delete();
        return $event->name." deleted successfully";
    }
    public function AllEventsOfAUser(Request $request){
        $events = Events::where("user_id",$request->user()->id)->get();
        $invitedEvents = EventInvite::where("user_id",$request->user()->id)->with("events","events.user")->get();
        $data = [
            "OwnEvents"=>$events,
            "InvitedEvents"=>$invitedEvents
        ];
        return $data;
    }
}
