@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <a href="{{ route('manga.index') }}" class="text-white hover:text-gray-300 flex items-center" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">
            <span class="mr-2">←</span> Back to Manga List
        </a>
    </div>

    <div class="bg-gradient-to-br from-gray-900/80 to-black/90 backdrop-blur-sm rounded-lg overflow-hidden shadow-xl p-6 mb-6 border border-gray-700/50">
        <div style="display: flex; align-items: flex-start; gap: 30px;">
            <!-- Cover Image di Kiri -->
            <div style="flex-shrink: 0;">
                @if($manga->cover_image)
                    <img src="{{ asset('storage/' . $manga->cover_image) }}" alt="{{ $manga->name }}" class="h-96 w-64 object-cover rounded-lg shadow-lg border-2 border-blue-400/30">
                @else
                    <div class="h-96 w-64 bg-gray-800/60 rounded-lg shadow-lg flex items-center justify-center border-2 border-blue-400/30">
                        <p class="text-white text-sm">No Cover Image</p>
                    </div>
                @endif
            </div>
            
            <!-- SEMUA INFO DI SAMPING ATAS KANAN COVER -->
            <div style="flex: 1; display: flex; flex-direction: column; height: 384px;">
                <!-- Title di atas dengan shadow -->
                <h1 class="text-3xl font-bold text-white mb-6" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">{{ $manga->name }} #{{ $manga->volume }}</h1>
                
                <!-- Info dalam 2 kolom SEJAJAR HORIZONTAL -->
                <div style="display: flex; gap: 80px; margin-bottom: 20px;">
                    <!-- Kolom Kiri -->
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div>
                            <span class="font-medium text-white">Author:</span><br>
                            <span class="text-gray-300">{{ $manga->author }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-white">Series:</span><br>
                            <span class="text-gray-300">{{ $manga->name }} {{ $manga->volumes }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-white">Stock:</span><br>
                            <span class="px-2 py-1 rounded text-sm {{ $manga->stock > 0 ? 'bg-green-800/70 text-white' : 'bg-red-800/70 text-white' }}">
                                {{ $manga->stock }} available
                            </span>
                        </div>
                    </div>
                    
                    <!-- Kolom Kanan -->
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div>
                            <span class="font-medium text-white">Publisher:</span><br>
                            <span class="text-gray-300">{{ $manga->publisher }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-white">Genre:</span><br>
                            <span class="bg-blue-900/60 text-white px-3 py-1 rounded-full text-sm">{{ $manga->genre }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Description -->
                <div style="margin-bottom: 20px;">
                    <h3 class="text-lg font-semibold text-white mb-2">Description</h3>
                    <div class="text-white text-sm leading-relaxed">
                        {{ $manga->description }}
                    </div>
                </div>
                
                <!-- Action Buttons di bawah -->
                <div style="margin-top: auto; display: flex; justify-content: flex-end; gap: 12px;">
                    <a href="{{ route('manga.edit', $manga) }}" class="bg-indigo-600/80 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded">
                        Edit
                    </a>
                    <form action="{{ route('manga.destroy', $manga) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this manga?');" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600/80 hover:bg-red-700 text-white font-medium py-2 px-4 rounded">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Main container styling to match index table */
    .bg-gradient-to-br {
        background: rgba(0, 0, 0, 0.7) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
    }
    
    /* Cover image container */
    .bg-gray-800\/60 {
        background: rgba(0, 0, 0, 0.5) !important;
        border: 1px solid rgba(59, 130, 246, 0.3) !important;
    }
    
    /* Info sections */
    .bg-blue-900\/60 {
        background: rgba(30, 58, 138, 0.6) !important;
    }
    
    /* Status badges */
    .bg-green-800\/70 {
        background: rgba(22, 101, 52, 0.7) !important;
    }
    
    .bg-red-800\/70 {
        background: rgba(153, 27, 27, 0.7) !important;
    }
    
    /* Buttons */
    .bg-indigo-606\/80 {
        background: rgba(79, 70, 229, 0.8) !important;
        transition: all 0.3s ease;
    }
    
    .bg-indigo-600\/80:hover {
        background: rgba(67, 56, 202, 0.9) !important;
    }
    
    .bg-red-600\/80 {
        background: rgba(220, 38, 38, 0.8) !important;
        transition: all 0.3s ease;
    }
    
    .bg-red-600\/80:hover {
        background: rgba(185, 28, 28, 0.9) !important;
    }

    /* Text styling */
    .text-white {
        color: white !important;
    }
    
    .text-gray-300 {
        color: rgba(209, 213, 219) !important;
    }
    
    /* Responsive untuk mobile */
    @media (max-width: 768px) {
        .flex-col.md\:flex-row {
            flex-direction: column !important;
        }
        
        div[style*="grid-template-columns"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, rgba(17, 24, 39, 0.9), rgba(0, 0, 0, 0.95));
        background-attachment: fixed;
    }
    
    .container {
        max-width: 1000px;
    }
</style>
@endpush

@php
    // Define a custom background video for this specific page
    $backgroundVideo = asset('images/manga_index.mp4');
@endphp