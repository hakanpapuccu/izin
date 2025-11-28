<?php

namespace App\Http\Controllers;

use App\Models\BusinessEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessEventController extends Controller
{
    public function index()
    {
        return view('calendar.index');
    }

    public function getEvents()
    {
        $events = BusinessEvent::all()->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_date->toIso8601String(),
                'end' => $event->end_date->toIso8601String(),
                'description' => $event->description,
                'created_by' => $event->created_by,
            ];
        });

        return response()->json($events);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $event = BusinessEvent::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'created_by' => Auth::id(),
        ]);

        return response()->json($event);
    }

    public function update(Request $request, BusinessEvent $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $event->update($validated);

        return response()->json($event);
    }

    public function destroy(BusinessEvent $event)
    {
        $event->delete();

        return response()->json(['success' => true]);
    }
}
