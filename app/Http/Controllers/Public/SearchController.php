<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\SearchAvailabilityRequest;
use App\Models\Room;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(SearchAvailabilityRequest $request): View
    {
        $data = $request->validated();

        $query = Room::query()->where('status', 'active')->with('images');
        if (! empty($data['room_id'])) {
            $query->where('id', $data['room_id']);
        }

        $rooms = $query->orderBy('title')->get();

        return view('public.search.index', [
            'rooms' => $rooms,
            'search' => $data,
        ]);
    }
}
