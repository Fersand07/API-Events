<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Models\Events;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;

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
            'image' => ['required', 'image'],
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');

            $imagePath = $file->storePubliclyAs(
                'users/events',
                $file->hashName(),
                config('filesystems.default')
            );
        }

        $event = Events::create([
            'name' => $request->get('name'),
            'location' => $request->get('location'),
            'date' => $request->get('date'),
            'description' => $request->get('description'),
            'image' => $imagePath,
        ]);

        return EventResource::make($event);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
