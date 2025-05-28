@extends('layouts.dashboard')

@section('content')
<div class="mb-6">
    <a href="{{ route('manga.index') }}" class="text-white hover:text-indigo-300" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">
        <span class="mr-2">←</span> Back to Manga List
    </a>
</div>

    <div class="bg-black bg-opacity-60 rounded-lg overflow-hidden shadow-xl p-6 mb-6">
        <h1 class="text-3xl font-bold text-white mb-6">Edit Manga: {{ $manga->name }}</h1>

        <form action="{{ route('manga.update', $manga) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <style>
    /* Table styling to match index.blade.php */
    .bg-black.bg-opacity-60 {
        background: rgba(0, 0, 0, 0.7) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 5px;
    }
    
    /* Input fields styling */
    .bg-gray-800 {
        background: rgba(0, 0, 0, 0.5) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: white !important;
    }
    
    /* Textarea styling */
    textarea.bg-gray-800 {
        background: rgba(0, 0, 0, 0.5) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: white !important;
    }
    
    /* File upload area styling */
    .border-gray-700 {
        border-color: rgba(255, 255, 255, 0.1) !important;
        background: rgba(0, 0, 0, 0.5) !important;
    }
    
    /* Button styling to match */
    .bg-red-600 {
        background: rgba(220, 38, 38, 0.8) !important;
        transition: all 0.3s ease;
    }
    
    .bg-red-600:hover {
        background: rgba(185, 28, 28, 0.9) !important;
    }
    
    /* Label styling */
    .text-white {
        color: white !important;
    }
    
    /* Error message styling */
    .text-red-500 {
        color: #ef4444 !important;
        text-shadow: 0 0 3px rgba(239, 68, 68, 0.5);
    }
</style>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="mb-4">
                        <label for="name" class="block text-white font-medium mb-2">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $manga->name) }}" class="w-full bg-gray-800 border border-gray-700 rounded py-2 px-3 text-white focus:outline-none focus:border-red-500" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="volume" class="block text-white font-medium mb-2">Volume</label>
                        <input type="text" name="volume" id="volume" value="{{ old('volume', $manga->volume) }}" class="w-full bg-gray-800 border border-gray-700 rounded py-2 px-3 text-white focus:outline-none focus:border-red-500" required>
                        @error('volume')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="author" class="block text-white font-medium mb-2">Author</label>
                        <input type="text" name="author" id="author" value="{{ old('author', $manga->author) }}" class="w-full bg-gray-800 border border-gray-700 rounded py-2 px-3 text-white focus:outline-none focus:border-red-500" required>
                        @error('author')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="genre" class="block text-white font-medium mb-2">Genre</label>
                        <input type="text" name="genre" id="genre" value="{{ old('genre', $manga->genre) }}" class="w-full bg-gray-800 border border-gray-700 rounded py-2 px-3 text-white focus:outline-none focus:border-red-500" required>
                        @error('genre')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="publisher" class="block text-white font-medium mb-2">Publisher</label>
                        <input type="text" name="publisher" id="publisher" value="{{ old('publisher', $manga->publisher) }}" class="w-full bg-gray-800 border border-gray-700 rounded py-2 px-3 text-white focus:outline-none focus:border-red-500" required>
                        @error('publisher')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="stock" class="block text-white font-medium mb-2">Stock</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $manga->stock) }}" min="0" class="w-full bg-gray-800 border border-gray-700 rounded py-2 px-3 text-white focus:outline-none focus:border-red-500" required>
                        @error('stock')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <div class="mb-4">
                        <label for="description" class="block text-white font-medium mb-2">Description</label>
                        <textarea name="description" id="description" rows="5" class="w-full bg-gray-800 border border-gray-700 rounded py-2 px-3 text-white focus:outline-none focus:border-red-500" required>{{ old('description', $manga->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="cover_image" class="block text-white font-medium mb-2">Cover Image</label>
                        
                        @if($manga->cover_image)
                            <div class="mb-3">
                                <p class="text-white text-sm mb-2">Current Image:</p>
                                <img src="{{ asset('storage/' . $manga->cover_image) }}" alt="{{ $manga->name }}" class="h-48 w-36 object-cover rounded">
                            </div>
                        @endif
                        
                        <div class="flex items-center justify-center w-full">
                            <label for="cover_image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-700 border-dashed rounded-lg cursor-pointer bg-gray-800 hover:bg-gray-700">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-400">PNG, JPG, GIF (MAX. 2MB)</p>
                                </div>
                                <input id="cover_image" name="cover_image" type="file" class="hidden" accept="image/*" />
                            </label>
                        </div>
                        <div id="image-preview" class="mt-4 hidden">
                            <img id="preview-image" src="" alt="Preview" class="h-48 w-36 object-cover rounded">
                        </div>
                        @error('cover_image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Update Manga
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Preview image before upload
    document.getElementById('cover_image').addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
            document.getElementById('image-preview').classList.remove('hidden');
        }
        reader.readAsDataURL(e.target.files[0]);
    });
</script>
@endsection

@php
    // Define a custom background video for this specific page
    $backgroundVideo = asset('images/manga_index.mp4');
@endphp