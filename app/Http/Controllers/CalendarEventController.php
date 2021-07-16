<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use Illuminate\Http\Request;

class CalendarEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $calender_event = CalendarEvent::get();
        return $calender_event;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        $start_date = date("y-m-d", time());    
        $start_time = date("h-i-s",time());
        $end_date = date("y-m-d", time()); 
        $end_time = date("h-i-s",time());

        $start_datetime = explode(" ", $request->start);
        if($start_datetime) {
            $start_date = $start_datetime[0];
            if(count($start_datetime) > 1)
            {
                $start_time = $start_datetime[1];
            }            
        }        

        $end_datetime = explode(" ", $request->end);
        if($end_datetime) {
            $end_date = $end_datetime[0];
            if(count($end_datetime) > 1)
            {
                $end_time = $end_datetime[1];
            }            
        }        

        $calender_event = CalendarEvent::create([
            'title' => $request->title,
            'body' => $request->content,
            'frequency' => 1,
            'start_date' => $start_date,
            'start_time' => $start_time,
            'end_date' => $end_date,
            'end_time' => $end_time,
            'is_all_day' => 1,
            'class' => $request->class
        ]);    

        if(!$calender_event) {
            return response()->json(['fail' => 'db creation error'], 500);
        }            
        return response()->json(['success' => $calender_event],200);
        // return CalendarEvent::create([
        //     'title' => $request->name,
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
