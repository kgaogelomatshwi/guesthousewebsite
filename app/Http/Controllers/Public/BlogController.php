<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Page;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = BlogPost::query()
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->paginate(9);

        $page = Page::query()
            ->where('key', 'blog')
            ->where('is_active', true)
            ->with(['sections' => fn ($query) => $query->where('is_active', true)->orderBy('position')])
            ->first();

        return view('public.blog.index', compact('posts', 'page'));
    }

    public function show(string $slug): View
    {
        $post = BlogPost::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $page = (object) [
            'title' => $post->title,
            'seo_title' => $post->seo_title ?? $post->title,
            'seo_description' => $post->seo_description ?? $post->excerpt,
        ];

        return view('public.blog.show', compact('post', 'page'));
    }
}
