<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{
    public function index(Request $request)
    {
        $query = Resource::published()->with('author');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('title','like',"%$s%")->orWhere('excerpt','like',"%$s%"));
        }

        $resources   = $query->latest('published_at')->paginate(9);
        $categories  = Resource::published()->distinct()->pluck('category')->sort()->values();

        return view('resources.index', compact('resources', 'categories'));
    }

    public function show(Resource $resource)
    {
        abort_unless($resource->is_published, 404);
        $related = Resource::published()
            ->where('category', $resource->category)
            ->where('id', '!=', $resource->id)
            ->take(3)->get();
        return view('resources.show', compact('resource', 'related'));
    }

    public function create()
    {
        $categories = ['Anxiety', 'Depression', 'Mindfulness', 'Stress', 'Relationships', 'Sleep', 'Self-care', 'Trauma'];
        return view('resources.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'    => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'excerpt'  => ['nullable', 'string', 'max:300'],
            'body'     => ['required', 'string', 'min:100'],
            'read_time'=> ['nullable', 'string', 'max:20'],
        ]);

        $validated['author_id']    = Auth::id();
        $validated['is_published'] = true;
        $validated['published_at'] = now();

        Resource::create($validated);

        return redirect()->route('resources.index')->with('success', 'Article published successfully!');
    }
}
