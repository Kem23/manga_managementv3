@extends('layouts.dashboard')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-white" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">Manga List</h1>
    <div class="flex items-center space-x-4">
        <input 
            type="text" 
            placeholder="Search manga..." 
            id="searchInput" 
            class="transition-all duration-300 text-white placeholder-gray-400 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent mr-4"
            style="
                background: rgba(0, 0, 0, 0.7);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                min-width: 300px;
            "
        >
        <a href="{{ route('manga.create') }}" 
           class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition duration-200 font-semibold
                  border border-blue-400/30 backdrop-blur-sm bg-opacity-80 hover:bg-opacity-100"
           style="
               background: rgba(59, 130, 246, 0.8);
               border: 1px solid rgba(255, 255, 255, 0.1);
           ">
            Add Manga
        </a>
    </div>
</div>
        
<div class="overflow-x-auto">
    <!-- CSS fix applied directly to the table -->
    <style>
        /* Ensure all headers and cells align properly */
        #mangaTable th, #mangaTable td {
            text-align: center !important;
            color: white !important; /* Memastikan semua teks di tabel berwarna putih */
        }
        
        /* Fix the specific AUTHOR column alignment */
        #mangaTable th:nth-child(6), #mangaTable td:nth-child(6) {
            text-align: center !important;
            color: white !important; /* Khusus untuk kolom AUTHOR */
        }
        
        /* Table layout fixed to maintain consistent column widths */
        #mangaTable {
            table-layout: fixed;
            color: white !important; /* Memastikan semua teks di tabel berwarna putih */
        }
        
        /* Specific widths for most important columns */
        #mangaTable th:nth-child(1), #mangaTable td:nth-child(1) { width: 5%; } /* ID */
        #mangaTable th:nth-child(2), #mangaTable td:nth-child(2) { width: 8%; } /* COVER - Don't change image display code */
        #mangaTable th:nth-child(3), #mangaTable td:nth-child(3) { width: 15%; } /* NAME */
        #mangaTable th:nth-child(4), #mangaTable td:nth-child(4) { width: 8%; } /* VOLUME */
        #mangaTable th:nth-child(5), #mangaTable td:nth-child(5) { width: 10%; } /* GENRE */
        #mangaTable th:nth-child(6), #mangaTable td:nth-child(6) { width: 15%; } /* AUTHOR - This was misaligned */
        #mangaTable th:nth-child(7), #mangaTable td:nth-child(7) { width: 12%; } /* PUBLISHER */
        #mangaTable th:nth-child(8), #mangaTable td:nth-child(8) { width: 7%; } /* STOCK */
        #mangaTable th:nth-child(9), #mangaTable td:nth-child(9) { width: 10%; } /* AVAILABILITY */
        #mangaTable th:nth-child(10), #mangaTable td:nth-child(10) { width: 10%; } /* ACTION */
        
        /* Login-style container styles applied to the table */
        #mangaTable {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            overflow: hidden;
        }
        
        #mangaTable thead {
            background: rgba(0, 0, 0, 0.5);
        }
        
        #mangaTable th {
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 1rem 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: white !important; /* Memastikan header tabel berwarna putih */
        }
        
        #mangaTable td {
            padding: 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: white !important; /* Memastikan isi sel tabel berwarna putih */
        }
        
        #mangaTable tr:hover {
            background-color: rgba(59, 130, 246, 0.1);
        }
        
        /* Style the action buttons like the login button */
        #mangaTable .bg-blue-600,
        #mangaTable .bg-yellow-600,
        #mangaTable .bg-red-600 {
            background: rgba(59, 130, 246, 0.8);
            transition: all 0.3s ease;
            font-weight: 600;
        }
        
        #mangaTable .bg-blue-600:hover {
            background: rgba(37, 99, 235, 0.9);
        }
        
        #mangaTable .bg-yellow-600 {
            background: rgba(217, 119, 6, 0.8);
        }
        
        #mangaTable .bg-yellow-600:hover {
            background: rgba(180, 83, 9, 0.9);
        }
        
        #mangaTable .bg-red-600 {
            background: rgba(220, 38, 38, 0.8);
        }
        
        #mangaTable .bg-red-600:hover {
            background: rgba(185, 28, 28, 0.9);
        }
        
        /* Memastikan teks availability selalu putih */
        #mangaTable span {
            color: white !important;
        }
    </style>
    
    <table id="mangaTable" class="min-w-full">
        <thead>
            <tr>
                <th class="px-4 py-3 text-white">ID</th>
                <th class="px-4 py-3 text-white">COVER</th>
                <th class="px-4 py-3 text-white">NAME</th>
                <th class="px-4 py-3 text-white">VOLUME</th>
                <th class="px-4 py-3 text-white">GENRE</th>
                <th class="px-4 py-3 text-white">AUTHOR</th>
                <th class="px-4 py-3 text-white">PUBLISHER</th>
                <th class="px-4 py-3 text-white">STOCK</th>
                <th class="px-4 py-3 text-white">AVAILABILITY</th>
                <th class="px-4 py-3 text-white">ACTION</th>
            </tr>
        </thead>
        <tbody id="mangaTableBody">
            @foreach($mangas as $manga)
            <tr class="hover:bg-opacity-30 transition duration-200">
                <td class="px-4 py-3 text-white">{{ $manga->id }}</td>
                <td class="px-4 py-3">
                    <!-- Keep your original cover image code untouched -->
                    <img src="{{ asset('storage/' . $manga->cover_image) }}" alt="{{ $manga->name }}" class="h-20 mx-auto">
                </td>
                <td class="px-4 py-3 text-white">{{ $manga->name }}</td>
                <td class="px-4 py-3 text-white">{{ $manga->volume }}</td>
                <td class="px-4 py-3 text-white">{{ $manga->genre }}</td>
                <td class="px-4 py-3 text-white">{{ $manga->author }}</td>
                <td class="px-4 py-3 text-white">{{ $manga->publisher }}</td>
                <td class="px-4 py-3 text-white">{{ $manga->stock }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded text-white {{ $manga->stock > 0 ? 'bg-green-600 bg-opacity-80' : 'bg-red-600 bg-opacity-80' }}">
                        {{ $manga->stock > 0 ? 'Available' : 'Out of Stock' }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <div class="flex justify-center space-x-2">
                        <a href="{{ route('manga.show', $manga) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-sm transition duration-200">
                            View
                        </a>
                        <a href="{{ route('manga.edit', $manga) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-2 py-1 rounded text-sm transition duration-200">
                            Edit
                        </a>
                        <form action="{{ route('manga.destroy', $manga) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-sm transition duration-200"
                                    onclick="return confirm('Are you sure you want to delete this manga?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6 text-white">
    {{ $mangas->links() }}
</div>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('#mangaTableBody tr');
        
        tableRows.forEach(row => {
            const textContent = row.textContent.toLowerCase();
            row.style.display = textContent.includes(searchTerm) ? '' : 'none';
        });
    });
</script>
@endsection

@php
    // Define a custom background video for this specific page
    $backgroundVideo = asset('images/manga_index.mp4');
@endphp