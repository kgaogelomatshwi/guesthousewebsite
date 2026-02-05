<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoomRequest;
use App\Models\Amenity;
use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function index(): View
    {
        $rooms = Room::query()->orderByDesc('featured')->orderBy('title')->get();

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create(): View
    {
        $amenities = Amenity::orderBy('name')->get();

        return view('admin.rooms.create', compact('amenities'));
    }

    public function store(StoreRoomRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $room = Room::create($data);
        $room->amenities()->sync($data['amenities'] ?? []);

        $this->storeImages($room, $request);

        return redirect()->route('admin.rooms.edit', $room)->with('success', 'Room created.');
    }

    public function edit(Room $room): View
    {
        $amenities = Amenity::orderBy('name')->get();
        $room->load('images', 'amenities');

        return view('admin.rooms.edit', compact('room', 'amenities'));
    }

    public function update(StoreRoomRequest $request, Room $room): RedirectResponse
    {
        $data = $request->validated();

        $room->update($data);
        $room->amenities()->sync($data['amenities'] ?? []);

        $this->storeImages($room, $request);

        return back()->with('success', 'Room updated.');
    }

    public function destroy(Room $room): RedirectResponse
    {
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted.');
    }

    private function storeImages(Room $room, StoreRoomRequest $request): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $position = $room->images()->max('position') ?? 0;

        foreach ($request->file('images') as $image) {
            $path = $image->store('rooms', 'public');
            RoomImage::create([
                'room_id' => $room->id,
                'path' => $path,
                'position' => ++$position,
            ]);
        }
    }
}
