<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EventInvite;
use App\Http\Requests\StoreEventInviteRequest;
use App\Http\Requests\UpdateEventInviteRequest;

class EventInviteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        return EventInvite::with("events","user")->paginate(20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEventInviteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventInviteRequest $request)
    {
        if ($request->email == $request->user()->email) {
            return response()->json("You cannot invite yourself",405);
        }
        $user = User::where("email",$request->email)->first();
        if($user){
            $request["user_id"]=$user->id;
            EventInvite::create($request->all());
        return "Invitation sent successfully";

        }else{
            return response()->json("User not found",404);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventInvite  $eventInvite
     * @return \Illuminate\Http\Response
     */
    public function show(EventInvite $eventInvite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EventInvite  $eventInvite
     * @return \Illuminate\Http\Response
     */
    public function edit(EventInvite $eventInvite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventInviteRequest  $request
     * @param  \App\Models\EventInvite  $eventInvite
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventInviteRequest $request, EventInvite $eventInvite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventInvite  $eventInvite
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventInvite $eventInvite)
    {
        //
    }
}
