@extends('layouts.dashboard')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-white" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">Customer List</h1>
    <div class="flex items-center space-x-4">
        <input 
            type="text" 
            placeholder="Search customers..." 
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
        <a href="{{ route('customer.create') }}" 
           class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition duration-200 font-semibold
                  border border-blue-400/30 backdrop-blur-sm bg-opacity-80 hover:bg-opacity-100"
           style="
               background: rgba(59, 130, 246, 0.8);
               border: 1px solid rgba(255, 255, 255, 0.1);
           ">
            Add Customer
        </a>
    </div>
</div>
        
<div class="overflow-x-auto">
    <!-- CSS fix applied directly to the table -->
    <style>
        /* Ensure all headers and cells align properly */
        #customerTable th, #customerTable td {
            text-align: left !important;
            color: white !important;
        }
        
        /* Table layout fixed to maintain consistent column widths */
        #customerTable {
            table-layout: fixed;
            color: white !important;
        }
        
        /* Specific widths for columns */
        #customerTable th:nth-child(1), #customerTable td:nth-child(1) { width: 5%; } /* ID */
        #customerTable th:nth-child(2), #customerTable td:nth-child(2) { width: 20%; } /* Name */
        #customerTable th:nth-child(3), #customerTable td:nth-child(3) { width: 25%; } /* Email */
        #customerTable th:nth-child(4), #customerTable td:nth-child(4) { width: 20%; } /* Phone */
        #customerTable th:nth-child(5), #customerTable td:nth-child(5) { width: 15%; } /* Birthdate */
        #customerTable th:nth-child(6), #customerTable td:nth-child(6) { width: 15%; } /* Actions */
        
        /* Login-style container styles applied to the table */
        #customerTable {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            overflow: hidden;
        }
        
        #customerTable thead {
            background: rgba(0, 0, 0, 0.5);
        }
        
        #customerTable th {
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 1rem 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: white !important;
        }
        
        #customerTable td {
            padding: 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: white !important;
        }
        
        #customerTable tr:hover {
            background-color: rgba(59, 130, 246, 0.1);
        }
        
        /* Style the action buttons like the login button */
        #customerTable .bg-blue-600,
        #customerTable .bg-red-600 {
            background: rgba(59, 130, 246, 0.8);
            transition: all 0.3s ease;
            font-weight: 600;
        }
        
        #customerTable .bg-blue-600:hover {
            background: rgba(37, 99, 235, 0.9);
        }
        
        #customerTable .bg-red-600 {
            background: rgba(220, 38, 38, 0.8);
        }
        
        #customerTable .bg-red-600:hover {
            background: rgba(185, 28, 28, 0.9);
        }
    </style>
    
    <table id="customerTable" class="min-w-full">
        <thead>
            <tr>
                <th class="px-4 py-3 text-white">ID</th>
                <th class="px-4 py-3 text-white">Name</th>
                <th class="px-4 py-3 text-white">E-mail</th>
                <th class="px-4 py-3 text-white">Phone Number</th>
                <th class="px-4 py-3 text-white">Birthdate</th>
                <th class="px-4 py-3 text-white">Actions</th>
            </tr>
        </thead>
        <tbody id="customerTableBody">
            @foreach($customers as $customer)
            <tr class="hover:bg-opacity-30 transition duration-200">
                <td class="px-4 py-3 text-white">{{ $customer->id }}</td>
                <td class="px-4 py-3 text-white">{{ $customer->name }}</td>
                <td class="px-4 py-3 text-white">{{ $customer->email }}</td>
                <td class="px-4 py-3 text-white">{{ $customer->phone }}</td>
                <td class="px-4 py-3 text-white">{{ $customer->birthdate->format('Y-m-d') }}</td>
                <td class="px-4 py-3">
                    <div class="flex space-x-2">
                        <a href="{{ route('customer.edit', $customer->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition duration-200">
                            Edit
                        </a>
                        <form action="{{ route('customer.destroy', $customer->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition duration-200"
                                    onclick="return confirm('Are you sure you want to delete this customer?')">
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
    {{ $customers->links() }}
</div>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('#customerTableBody tr');
        
        tableRows.forEach(row => {
            const textContent = row.textContent.toLowerCase();
            row.style.display = textContent.includes(searchTerm) ? '' : 'none';
        });
    });
</script>
@endsection

@php
    // Define a custom background video for this specific page
    $backgroundVideo = asset('images/customer_index.mp4');
@endphp