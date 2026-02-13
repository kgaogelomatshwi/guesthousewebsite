<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Services\Media\MediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = BlogPost::with('category')->orderByDesc('published_at')->get();

        return view('admin.blog.index', compact('posts'));
    }

    public function create(): View
    {
        $categories = BlogCategory::orderBy('name')->get();

        return view('admin.blog.create', [
            'categories' => $categories,
            'media' => \App\Models\Media::query()
                ->where('mime_type', 'like', 'image/%')
                ->orderByDesc('created_at')
                ->take(200)
                ->get(),
        ]);
    }

    public function store(Request $request, MediaService $mediaService): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'slug' => ['required', 'string', 'max:150'],
            'excerpt' => ['nullable', 'string'],
            'body' => ['required', 'string'],
            'cover_image' => ['nullable', 'file', 'mimetypes:image/*', 'max:5120'],
            'cover_image_existing' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:blog_categories,id'],
            'seo_title' => ['nullable', 'string', 'max:160'],
            'seo_description' => ['nullable', 'string', 'max:255'],
            'is_published' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'tags' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $mediaService->store($request->file('cover_image'), 'blog');
        } elseif (!empty($data['cover_image_existing'])) {
            $data['cover_image'] = $data['cover_image_existing'];
        }
        unset($data['cover_image_existing']);

        $data['user_id'] = $request->user()->id;

        $post = BlogPost::create($data);
        $this->syncTags($post, $data['tags'] ?? null);

        return redirect()->route('admin.blog.index')->with('success', 'Post created.');
    }

    public function edit(BlogPost $blog): View
    {
        $categories = BlogCategory::orderBy('name')->get();
        $blog->load('tags');

        return view('admin.blog.edit', [
            'post' => $blog,
            'categories' => $categories,
            'media' => \App\Models\Media::query()
                ->where('mime_type', 'like', 'image/%')
                ->orderByDesc('created_at')
                ->take(200)
                ->get(),
        ]);
    }

    public function update(Request $request, BlogPost $blog, MediaService $mediaService): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'slug' => ['required', 'string', 'max:150'],
            'excerpt' => ['nullable', 'string'],
            'body' => ['required', 'string'],
            'cover_image' => ['nullable', 'file', 'mimetypes:image/*', 'max:5120'],
            'cover_image_existing' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:blog_categories,id'],
            'seo_title' => ['nullable', 'string', 'max:160'],
            'seo_description' => ['nullable', 'string', 'max:255'],
            'is_published' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'tags' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $mediaService->store($request->file('cover_image'), 'blog');
        } elseif (!empty($data['cover_image_existing'])) {
            $data['cover_image'] = $data['cover_image_existing'];
        }
        unset($data['cover_image_existing']);

        $blog->update($data);
        $this->syncTags($blog, $data['tags'] ?? null);

        return back()->with('success', 'Post updated.');
    }

    public function destroy(BlogPost $blog): RedirectResponse
    {
        $blog->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Post removed.');
    }

    private function syncTags(BlogPost $post, ?string $tags): void
    {
        if ($tags === null) {
            $post->tags()->sync([]);
            return;
        }

        $names = array_values(array_filter(array_map('trim', explode(',', $tags))));
        $tagIds = [];
        foreach ($names as $name) {
            $tag = BlogTag::firstOrCreate([
                'slug' => Str::slug($name),
            ], [
                'name' => $name,
            ]);
            $tagIds[] = $tag->id;
        }

        $post->tags()->sync($tagIds);
    }
}
