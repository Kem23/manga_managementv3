<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MangaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Manga::query();
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('author', 'like', "%{$searchTerm}%")
                  ->orWhere('genre', 'like', "%{$searchTerm}%")
                  ->orWhere('publisher', 'like', "%{$searchTerm}%")
                  ->orWhere('volume', 'like', "%{$searchTerm}%");
            });
        }
        
        $mangas = $query->latest()->paginate(10);
        
        // Append search parameter to pagination links
        if ($request->has('search')) {
            $mangas->appends(['search' => $request->search]);
        }
        
        return view('manga.index', compact('mangas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manga.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'volume' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'genre' => 'required|string|max:255',
                'publisher' => 'required|string|max:255',
                'description' => 'required|string',
                'stock' => 'required|integer|min:0',
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            ]);
            
            $data = $request->except('cover_image');
            
            // Handle image upload
            if ($request->hasFile('cover_image')) {
                $path = $request->file('cover_image')->store('manga_covers', 'public');
                $data['cover_image'] = $path;
            }
            
            $manga = Manga::create($data);
            
            return redirect()->route('manga.index')
                ->with('success', 'Manga added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create manga. Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
        public function show(Manga $manga) {
    // Pastikan method menerima model binding
        return view('manga.show', compact('manga'));
        }

        public function edit(Manga $manga)
        {
            return view('manga.edit', compact('manga'));
        }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manga $manga)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'volume' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
        ]);

        $data = $request->except('cover_image');
        
        // Handle image upload
        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($manga->cover_image) {
                Storage::disk('public')->delete($manga->cover_image);
            }
            
            $path = $request->file('cover_image')->store('manga_covers', 'public');
            $data['cover_image'] = $path;
        }

        $manga->update($data);

        return redirect()->route('manga.index')
            ->with('success', 'Manga updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manga $manga)
    {
        // Delete image if exists
        if ($manga->cover_image) {
            Storage::disk('public')->delete($manga->cover_image);
        }
        
        $manga->delete();

        return redirect()->route('manga.index')
            ->with('success', 'Manga deleted successfully.');
    }
}