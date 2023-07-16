<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;
use App\Http\Resources\EventResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Scheduling\Event;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Events::paginate(
            $request->get('per_page')
        );

        return EventResource::collection($events);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'location' => ['required', 'max:20'],
            'date' => ['required', 'max:20'],
            'description' => ['required', 'max:255'],
            'image' => ['required'],
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            
            $path = Storage::put('public/events', $file, 'public');
        }

        $event = Events::create([
            'name' => $request->get('name'),
            'location' => $request->get('location'),
            'date' => $request->get('date'),
            'description' => $request->get('description'),
            'image' => $path,
        ]);

        return EventResource::make($event);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $event = Events::find($id); 
        return EventResource::make($event);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'location' => ['required', 'max:20'],
            'date' => ['required', 'max:20'],
            'description' => ['required', 'max:255'],
        ]);

        $event = Events::find($id);

        $event->update([
            'name' => $request->get('name'),
            'location' => $request->get('location'),
            'date' => $request->get('date'),
            'description' => $request->get('description'),
        ]);

        return EventResource::make($event);
    }


    public function destroy(string $id)
    {
       $event = Events::find($id);
       $event->delete();
       return $event;
    }
}
