@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">Welcome to Manga Management</h1>
    </div>

    <div class="bg-black bg-opacity-60 rounded-lg overflow-hidden shadow-xl p-6">
        <p class="text-white mb-6">Welcome to your manga management dashboard. From here, you can manage your manga collection, track stock levels, and more.</p>
        
        <div class="feature-cards">
            <a href="{{ route('manga.index') }}" class="feature-card">
                Manga List
            </a>

            <a href="{{ route('customer.index') }}" class="feature-card">
                Customer List
            </a>
        </div>
    </div>
</div>
@endsection