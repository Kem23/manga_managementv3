@extends('layouts.dashboard')

@section('content')
<style>
input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(1);
    opacity: 1;
}
</style>

<div class="flex flex-col items-center mb-6">
    <div class="w-full max-w-3xl">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">Edit Customer: {{ $customer->name }}</h1>
            <a href="{{ route('customer.index') }}" 
               class="text-white bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-lg transition duration-200 font-semibold
                     border border-gray-500/30 backdrop-blur-sm bg-opacity-80 hover:bg-opacity-100"
               style="
                   background: rgba(75, 85, 99, 0.8);
                   border: 1px solid rgba(255, 255, 255, 0.1);
               ">
                Back to List
            </a>
        </div>
        
        <div style="
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 2rem;
        ">
            <form action="{{ route('customer.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm mb-1 text-white">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $customer->name) }}" required
                               class="w-full transition-all duration-300 text-white placeholder-gray-400 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               style="
                                   background: rgba(0, 0, 0, 0.5);
                                   border: 1px solid rgba(255, 255, 255, 0.1);
                               ">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm mb-1 text-white">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $customer->email) }}" required
                               class="w-full transition-all duration-300 text-white placeholder-gray-400 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               style="
                                   background: rgba(0, 0, 0, 0.5);
                                   border: 1px solid rgba(255, 255, 255, 0.1);
                               ">
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm mb-1 text-white">Phone Number</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $customer->phone) }}" required
                               class="w-full transition-all duration-300 text-white placeholder-gray-400 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               style="
                                   background: rgba(0, 0, 0, 0.5);
                                   border: 1px solid rgba(255, 255, 255, 0.1);
                               ">
                    </div>
                    
                    <div>
                        <label for="birthdate" class="block text-sm mb-1 text-white">Birthdate</label>
                        <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate', $customer->birthdate->format('Y-m-d')) }}" required
                               class="w-full transition-all duration-300 text-white placeholder-gray-400 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               style="
                                   background: rgba(0, 0, 0, 0.5);
                                   border: 1px solid rgba(255, 255, 255, 0.1);
                               ">
                    </div>
                </div>
                
                <div class="mt-8 flex items-center justify-end">
                    <button type="submit" 
                            class="text-white bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded-lg transition duration-200 font-semibold
                                 border border-blue-400/30 backdrop-blur-sm bg-opacity-80 hover:bg-opacity-100"
                            style="
                                background: rgba(59, 130, 246, 0.8);
                                border: 1px solid rgba(255, 255, 255, 0.1);
                            ">
                        Update Customer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@php
    // Define a custom background video for this specific page
    $backgroundVideo = asset('images/customer_index.mp4');
@endphp