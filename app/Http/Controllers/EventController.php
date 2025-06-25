<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Event::with('user')->latest();
        
        if ($request->category) {
            $query->where('category', $request->category);
        }
        
        $events = $query->paginate(12);
        $categories = Event::categories();
        
        return view('events.index', compact('events', 'categories'));
    }

    /**
     * Display a listing of the user's events.
     */
    public function myEvents()
    {
        $events = Event::where('user_id', Auth::id())
                      ->with('user')
                      ->latest()
                      ->paginate(12);
        return view('events.my-events', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Event::categories();
        return view('events.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category' => 'required|in:' . implode(',', array_keys(Event::categories())),
            'description' => 'required',
            'location' => 'required',
            'event_date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'capacity' => 'nullable|integer|min:1',
            'image' => 'required|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 'public');
            $validated['image_path'] = $path;
        }

        $validated['user_id'] = Auth::id();
        
        $event = Event::create($validated);

        return redirect()->route('events.show', $event)
            ->with('success', '¡Evento creado exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $this->authorize('update', $event);
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'location' => 'required',
            'event_date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'capacity' => 'nullable|integer|min:1',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($event->image_path) {
                Storage::disk('public')->delete($event->image_path);
            }
            $path = $request->file('image')->store('events', 'public');
            $validated['image_path'] = $path;
        }

        $event->update($validated);

        return redirect()->route('events.show', $event)
            ->with('success', '¡Evento actualizado exitosamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        if ($event->image_path) {
            Storage::disk('public')->delete($event->image_path);
        }

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', '¡Evento eliminado exitosamente!');
    }
}
