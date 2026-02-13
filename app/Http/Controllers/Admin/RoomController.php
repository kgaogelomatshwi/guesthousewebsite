<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoomRequest;
use App\Models\Amenity;
use App\Models\Room;
use App\Models\RoomImage;
use App\Services\Media\MediaService;
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

        return view('admin.rooms.create', [
            'amenities' => $amenities,
            'media' => \App\Models\Media::query()
                ->where('mime_type', 'like', 'image/%')
                ->orderByDesc('created_at')
                ->take(200)
                ->get(),
        ]);
    }

    public function store(StoreRoomRequest $request, MediaService $mediaService): RedirectResponse
    {
        $data = $request->validated();

        $room = Room::create($data);
        $room->amenities()->sync($data['amenities'] ?? []);

        $this->storeImages($room, $request, $mediaService);

        return redirect()->route('admin.rooms.edit', $room)->with('success', 'Room created.');
    }

    public function edit(Room $room): View
    {
        $amenities = Amenity::orderBy('name')->get();
        $room->load('images', 'amenities');

        return view('admin.rooms.edit', [
            'room' => $room,
            'amenities' => $amenities,
            'media' => \App\Models\Media::query()
                ->where('mime_type', 'like', 'image/%')
                ->orderByDesc('created_at')
                ->take(200)
                ->get(),
        ]);
    }

    public function update(StoreRoomRequest $request, Room $room, MediaService $mediaService): RedirectResponse
    {
        $data = $request->validated();

        $room->update($data);
        $room->amenities()->sync($data['amenities'] ?? []);

        $this->storeImages($room, $request, $mediaService);

        return back()->with('success', 'Room updated.');
    }

    public function destroy(Room $room): RedirectResponse
    {
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted.');
    }

    private function storeImages(Room $room, StoreRoomRequest $request, MediaService $mediaService): void
    {
        $position = $room->images()->max('position') ?? 0;

        $existing = $request->input('existing_images', []);
        foreach ($existing as $path) {
            if (! $path) {
                continue;
            }
            RoomImage::create([
                'room_id' => $room->id,
                'path' => $path,
                'position' => ++$position,
            ]);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $mediaService->store($image, 'rooms');
                RoomImage::create([
                    'room_id' => $room->id,
                    'path' => $path,
                    'position' => ++$position,
                ]);
            }
        }
    }
}
