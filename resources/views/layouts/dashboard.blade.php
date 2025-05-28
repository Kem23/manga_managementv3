<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manga Dashboard - {{ config('app.name', 'Manga Management') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@400;700&display=swap" rel="stylesheet">
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'M PLUS Rounded 1c', sans-serif;
            position: relative;
            font-size: 16px; /* Base font size increase */
        }
        
        /* Background Animation Styling */
        .background-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
            overflow: hidden;
        }   

        .background-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
        }

        /* Mobile Menu Toggle Button */
        .mobile-menu-toggle {
            display: block;
            position: fixed;
            top: 20px; /* Increased from 12px */
            left: 20px; /* Increased from 12px */
            z-index: 30;
            background: transparent;
            border: none;
            cursor: pointer;
        }

        /* Hamburger Icon - ENLARGED */
        .hamburger {
            width: 36px; /* Increased from 30px */
            height: 24px; /* Increased from 20px */
            position: relative;
            transform: rotate(0deg);
            transition: .5s ease-in-out;
        }

        .hamburger span {
            display: block;
            position: absolute;
            height: 4px; /* Increased from 3px */
            width: 100%;
            background: white;
            border-radius: 4px; /* Increased from 3px */
            opacity: 1;
            left: 0;
            transform: rotate(0deg);
            transition: .25s ease-in-out;
        }

        .hamburger span:nth-child(1) {
            top: 0px;
        }

        .hamburger span:nth-child(2), .hamburger span:nth-child(3) {
            top: 12px; /* Increased from 10px */
        }

        .hamburger span:nth-child(4) {
            top: 24px; /* Increased from 20px */
        }

        /* X animation for the hamburger */
        .hamburger.open span:nth-child(1) {
            top: 12px; /* Increased from 10px */
            width: 0%;
            left: 50%;
        }

        .hamburger.open span:nth-child(2) {
            transform: rotate(45deg);
        }

        .hamburger.open span:nth-child(3) {
            transform: rotate(-45deg);
        }

        .hamburger.open span:nth-child(4) {
            top: 12px; /* Increased from 10px */
            width: 0%;
            left: 50%;
        }
        
        /* Sidebar Animation - WIDER */
        .manga-sidebar {
            background-color: #000000;
            color: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 320px; /* Increased from 300px */
            z-index: 20;
            transition: transform 0.3s ease-in-out;
            transform: translateX(-100%); /* Default state: sidebar is hidden */
            display: flex;
            flex-direction: column;
        }

        /* ENHANCED: Added better spacing for the sidebar header */
        .manga-sidebar h1 {
            margin-top: 60px; /* Increased from 20px to avoid overlap with the X button */
            margin-bottom: 36px; /* Increased from 10px to create more space */
            font-size: 2rem; /* Ensuring the title is prominent */
            padding-bottom: 12px; /* Added padding to create visual separation */
            border-bottom: 1px solid rgba(255, 255, 255, 0.2); /* Added subtle divider */
            text-align: center; /* Center the title text */
            padding-left: 10px; /* Add padding to offset the indent caused by the hamburger menu */
        }

        .manga-sidebar nav {
            margin-top: 16px; /* Add space above the navigation */
        }

        .manga-sidebar a, .manga-sidebar button {
            color: white;
            padding: 16px 20px; /* Increased from 12px 16px */
            transition: all 0.2s;
            border-radius: 6px; /* Increased from 4px */
            margin-bottom: 12px; /* Increased from 8px for more spacing between items */
            width: 100%;
            text-align: left;
            display: flex;
            align-items: center;
            font-size: 18px; /* Added font size */
        }

        .manga-sidebar a i {
            margin-right: 14px; /* Increased from 10px */
            width: 24px; /* Increased from 20px */
            text-align: center;
            font-size: 20px; /* Added font size */
        }

        .manga-sidebar a:hover, .manga-sidebar button:hover {
            background-color: rgba(255,255,255,0.15); /* Slightly more visible */
        }

        /* Sidebar Overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 15;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .main-content {
            margin-left: 0; /* Default state: no margin for sidebar */
            min-height: 100vh;
            width: 100%; /* Default width without sidebar */
            background-color: transparent;
            position: relative;
            z-index: 1;
            transition: margin-left 0.3s ease-in-out;
        }

        .main-content.sidebar-open {
            margin-left: 320px; /* When sidebar is open */
            width: calc(100% - 320px); /* Adjusted for wider sidebar */
        }

        .header {
            height: 80px; /* Increased from 64px */
            border-bottom: 1px solid rgba(232, 59, 59, 0.5);
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 0 32px; /* Increased from 24px */
            background-color: transparent;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            background-color: rgba(0, 0, 0, 0.8); /* Darker for better readability */
            min-width: 180px; /* Increased from 160px */
            box-shadow: 0px 8px 24px rgba(0, 0, 0, 0.3); /* Enhanced shadow */
            border-radius: 6px; /* Increased from 4px */
            border: 1px solid rgba(232, 59, 59, 0.6); /* Made border more visible */
            display: none;
            z-index: 1000;
        }   

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-menu a, 
        .dropdown-menu button {
            padding: 14px 20px; /* Increased from 10px 16px */
            display: block;
            color: white;
            text-decoration: none;
            text-align: left;
            background: none;
            border: none;
            width: 100%;
            font-size: 16px; /* Increased from 14px */
            transition: all 0.2s;
        }

        .dropdown-menu a:hover, 
        .dropdown-menu button:hover {
            background-color: rgba(232, 59, 59, 0.8); /* More vibrant hover */
        }

        .feature-cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 40px; /* Increased from 32px */
            padding: 40px; /* Increased from 32px */
        }

        .feature-card {
            width: 380px; /* Increased from 360px */
            height: 260px; /* Increased from 240px */
            border: 3px solid var(--manga-red); /* Increased from 2px */
            border-radius: 16px; /* Increased from 12px */
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 28px; /* Increased from 24px */
            font-weight: bold;
            transition: all 0.3s;
            background-color: rgba(0, 0, 0, 0.4);
            color: white;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.4); /* Enhanced shadow */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6); /* Enhanced text shadow */
        }

        .feature-card:hover {
            background-color: rgba(232, 59, 59, 0.8); /* More vibrant hover */
            color: white;
            transform: translateY(-8px); /* Increased from -5px */
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.4); /* Enhanced shadow */
        }
        
        /* Both desktop and mobile styles */
        .mobile-menu-toggle {
            display: block;
        }
        
        .manga-sidebar.open {
            transform: translateX(0);
        }
        
        .sidebar-overlay.open {
            display: block;
            opacity: 1;
        }

        /* Welcome Container Styling - ENLARGED */
        .welcome-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 60vh; /* Increased from 50vh */
            width: 100%;
            padding: 40px; /* Increased from 20px */
        }

        /* Welcome Message Styling - ENLARGED */
        .welcome-message {
            text-align: center;
            max-width: 1200px; /* Increased from 1000px */
            padding: 60px; /* Increased from 50px */
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 16px; /* Increased from 12px */
            border: 2px solid rgba(232, 59, 59, 0.6); /* Increased from 1px */
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4); /* Enhanced shadow */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .welcome-message h1 {
            font-size: 52px; /* Increased from 48px */
            font-weight: bold;
            margin-bottom: 24px; /* Increased from 16px */
            color: white;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.8); /* Enhanced text shadow */
            width: 100%;
            text-align: center;
        }

        .welcome-message p {
            font-size: 24px; /* Increased from 22px */
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8); /* Enhanced text shadow */
            line-height: 1.7; /* Increased from 1.6 */
            width: 100%;
            text-align: center;
        }
        
        /* Adjust main content padding to be larger */
        main.p-8 {
            padding: 2.5rem !important; /* Increased from 2rem */
        }
        
        /* Make sure the container has ample padding */
        .container.mx-auto {
            padding-left: 3rem !important; /* Increased from 2.5rem */
            padding-right: 3rem !important; /* Increased from 2.5rem */
            max-width: 98% !important; /* Increased from 95% */
        }
        
        /* Enhance table sizing for manga list */
        .min-w-full {
            font-size: 1.2rem; /* Increased from 1.1rem */
        }
        
        /* Button size increase */
        .py-2.px-4 {
            padding-top: 0.75rem !important; /* Increased from 0.625rem */
            padding-bottom: 0.75rem !important; /* Increased from 0.625rem */
            padding-left: 1.5rem !important; /* Increased from 1.25rem */
            padding-right: 1.5rem !important; /* Increased from 1.25rem */
        }
        
        /* Magnify form elements */
        input, select, textarea {
            font-size: 1.2rem !important; /* Increased from 1.1rem */
            padding: 0.85rem 1.2rem !important; /* Increased from 0.75rem 1rem */
        }

        /* NEW STYLES FOR SIDEBAR PROFILE DROPDOWN */
        .sidebar-nav-item {
            position: relative;
        }

        .sidebar-dropdown {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            padding-left: 38px; /* Indent submenu items */
        }

        .sidebar-dropdown.open {
            max-height: 200px; /* Adjust based on your submenu size */
        }

        .sidebar-dropdown a {
            padding: 14px 20px 14px 20px; /* Modified padding for submenu items */
            font-size: 16px; /* Slightly smaller than parent menu */
        }

        .sidebar-nav-item .toggle-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            transition: transform 0.3s ease;
        }

        .sidebar-nav-item .toggle-icon.rotate {
            transform: translateY(-50%) rotate(180deg);
        }

        /* Add divider between nav sections */
        .nav-divider {
            height: 1px;
            background-color: rgba(255, 255, 255, 0.2);
            margin: 16px 0;
        }

        /* ENHANCED: Improve navigation spacing and organization */
        nav.space-y-2 {
            margin-top: 10px; /* Add space at the top of navigation */
            display: flex;
            flex-direction: column;
            gap: 6px; /* Control spacing between nav items */
        }
    </style>
</head>
<body>
    <!-- Hamburger Menu Toggle Button -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </button>

    <!-- Sidebar Overlay (visible on mobile when menu is open) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Video Background Container -->
    <div class="background-container">
        <video id="bgVideo" class="background-video" autoplay muted loop playsinline>
            <source src="{{ $backgroundVideo ?? asset('images/background_dashboard.mp4') }}" type="video/mp4">
            <!-- Fallback for browsers that don't support video -->
            Your browser does not support the video tag.
        </video>
    </div>

    <!-- Sidebar - ENHANCED -->
    <div class="manga-sidebar p-8" id="mangaSidebar">
        <h1 class="text-3xl font-bold text-white text-center">Manga Admin</h1>
        <nav class="space-y-2">
            <a href="{{ route('dashboard') }}" class="block font-medium hover:text-white">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('manga.index') }}" class="block font-medium hover:text-white">
                <i class="fas fa-book"></i> Manga List
            </a>
            <a href="{{ route('customer.index') }}" class="block font-medium hover:text-white">
                <i class="fas fa-users"></i> Customer List
            </a>
            
            <!-- Navigation Divider -->
            <div class="nav-divider"></div>
            
            <!-- Profile Menu with Dropdown -->
            <div class="sidebar-nav-item">
                <a href="#" class="block font-medium hover:text-white profile-toggle">
                    <i class="fas fa-user-circle"></i> Profile
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </a>
                <div class="sidebar-dropdown">
                    <a href="{{ route('profile.show') }}" class="block font-medium hover:text-white">
                        <i class="fas fa-id-card"></i> Check Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block font-medium hover:text-white w-full text-left">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Header -->
        @hasSection('show_header')
        <header class="header">
            <div class="dropdown">
                <button id="profileDropdown" class="w-12 h-12 rounded-full border border-gray-300 bg-gray-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </button>
                <div id="profileMenu" class="dropdown-menu">
                    <a href="#" class="block">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left">Log out</button>
                    </form>
                </div>
            </div>
        </header>
        @endif

        <!-- Content - ENLARGED PADDING -->
        <main class="p-8">
            @hasSection('welcome_message')
            <!-- Enhanced Welcome Message Section -->
            <div class="welcome-container">
                <div class="welcome-message">
                    <h1>Welcome to Manga Management</h1>
                    <p>Welcome to your manga management dashboard. From here, you can manage your manga collection, track stock levels, and more.</p>
                </div>
            </div>
            @endif
            @yield('content')
        </main>
    </div>

    <script>
        // Menu toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mangaSidebar = document.getElementById('mangaSidebar');
        const mainContent = document.getElementById('mainContent');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const hamburger = document.querySelector('.hamburger');
        
        // Navigation bar is now closed by default - no need to initialize it on page load
        // Instead, we only toggle it when the menu button is clicked
        
        mobileMenuToggle.addEventListener('click', function() {
            mangaSidebar.classList.toggle('open');
            sidebarOverlay.classList.toggle('open');
            hamburger.classList.toggle('open');
            mainContent.classList.toggle('sidebar-open');
        });
        
        // Close sidebar when clicking on overlay
        sidebarOverlay.addEventListener('click', function() {
            mangaSidebar.classList.remove('open');
            sidebarOverlay.classList.remove('open');
            hamburger.classList.remove('open');
            mainContent.classList.remove('sidebar-open');
        });

        // Profile dropdown toggle
        const profileDropdown = document.getElementById('profileDropdown');
        if (profileDropdown) {
            profileDropdown.addEventListener('click', function() {
                document.getElementById('profileMenu').classList.toggle('show');
            });
            
            // Close dropdown when clicking outside
            window.addEventListener('click', function(e) {
                if (!document.getElementById('profileDropdown').contains(e.target)) {
                    var dropdown = document.getElementById('profileMenu');
                    if (dropdown && dropdown.classList.contains('show')) {
                        dropdown.classList.remove('show');
                    }
                }
            });
        }

        // Sidebar Profile Dropdown Toggle
        const profileToggle = document.querySelector('.profile-toggle');
        if (profileToggle) {
            profileToggle.addEventListener('click', function(e) {
                e.preventDefault();
                const dropdown = this.nextElementSibling;
                dropdown.classList.toggle('open');
                this.querySelector('.toggle-icon').classList.toggle('rotate');
            });
        }
    </script>
</body>
</html>