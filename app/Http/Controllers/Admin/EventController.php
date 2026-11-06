<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('creator');
        if ($request->search) $query->where('title', 'like', '%' . $request->search . '%');
        if ($request->status) $query->where('status', $request->status);
        $events = $query->orderBy('start_datetime', 'desc')->paginate(10)->withQueryString();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required',
            'start_datetime' => 'required|date',
            'category'       => 'required',
        ]);

        $data = $request->only('title', 'description', 'venue', 'start_datetime', 'end_datetime', 'organizer', 'category', 'status')
            + ['created_by' => auth()->id()];

        if ($request->hasFile('image')) {
            $file        = $request->file('image');
            $name        = time() . '.' . $file->extension();
            $file->move(public_path('uploads/events'), $name);
            $data['image'] = $name;
        }

        Event::create($data);
        return redirect()->route('admin.events.index')->with('success', 'Event created!');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title'          => 'required',
            'start_datetime' => 'required|date',
        ]);

        $data = $request->only('title', 'description', 'venue', 'start_datetime', 'end_datetime', 'organizer', 'category', 'status');

        if ($request->hasFile('image')) {
            $file        = $request->file('image');
            $name        = time() . '.' . $file->extension();
            $file->move(public_path('uploads/events'), $name);
            $data['image'] = $name;
        }

        $event->update($data);
        return redirect()->route('admin.events.index')->with('success', 'Event updated!');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted!');
    }
}
