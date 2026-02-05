<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(): View
    {
        $media = Media::query()->orderByDesc('created_at')->paginate(24);

        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'files' => ['required', 'array'],
            'files.*' => ['required', 'file', 'max:8192'],
        ]);

        foreach ($data['files'] as $file) {
            $path = $file->store('media', 'public');
            Media::create([
                'path' => $path,
                'title' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'size_bytes' => $file->getSize(),
            ]);
        }

        return back()->with('success', 'Media uploaded successfully.');
    }

    public function destroy(Media $media): RedirectResponse
    {
        if ($media->path) {
            Storage::disk('public')->delete($media->path);
        }
        $media->delete();

        return back()->with('success', 'Media deleted.');
    }
}
