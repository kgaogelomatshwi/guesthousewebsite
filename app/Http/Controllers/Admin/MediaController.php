<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
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
            'files.*' => [
                'required',
                'file',
                'max:51200',
                'mimes:jpg,jpeg,png,webp,gif,svg,mp4,webm,mp3,wav,ogg,pdf',
            ],
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

    public function picker(Request $request): JsonResponse
    {
        $query = Media::query()->orderByDesc('created_at');

        $type = $request->string('type')->toString();
        $search = $request->string('q')->toString();

        if ($type === 'image') {
            $query->where('mime_type', 'like', 'image/%');
        } elseif ($type === 'video') {
            $query->where('mime_type', 'like', 'video/%');
        } elseif ($type === 'audio') {
            $query->where('mime_type', 'like', 'audio/%');
        } elseif ($type === 'pdf') {
            $query->where('mime_type', 'application/pdf');
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search): void {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('path', 'like', '%' . $search . '%')
                    ->orWhere('mime_type', 'like', '%' . $search . '%');
            });
        }

        $items = $query->limit(300)->get();

        $payload = $items->map(fn (Media $item) => [
            'id' => $item->id,
            'title' => $item->title,
            'path' => $item->path,
            'url' => asset('storage/' . $item->path),
            'mime_type' => $item->mime_type,
            'size_bytes' => $item->size_bytes,
        ]);

        return response()->json($payload);
    }
}
