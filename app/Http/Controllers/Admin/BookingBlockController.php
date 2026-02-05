<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingBlock;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingBlockController extends Controller
{
    public function index(): View
    {
        $blocks = BookingBlock::with('room')->orderByDesc('start_date')->get();
        $rooms = Room::orderBy('title')->get();

        return view('admin.booking-blocks.index', compact('blocks', 'rooms'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'room_id' => ['nullable', 'exists:rooms,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['nullable', 'string', 'max:150'],
        ]);

        $data['created_by'] = $request->user()->id;

        BookingBlock::create($data);

        return back()->with('success', 'Block added.');
    }

    public function destroy(BookingBlock $bookingBlock): RedirectResponse
    {
        $bookingBlock->delete();

        return back()->with('success', 'Block removed.');
    }
}
