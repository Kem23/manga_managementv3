<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manga Management System</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@400;700&family=RocknRoll+One&display=swap" rel="stylesheet">

    <style>
        :root {
            --manga-red: #e83b3b;
            --manga-black: #1a1a1a;
            --manga-white: #f8f8f8;
            --translucent-white: rgba(255, 255, 255, 0.8);
            --translucent-black: rgba(26, 26, 26, 0.7);
        }

        body {
            font-family: 'M PLUS Rounded 1c', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow-x: hidden;
        }

        /* Video Background */
        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2; /* Lower z-index to ensure it's behind the content */
            overflow: hidden;
        }

        .video-background video {
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            object-fit: cover;
        }

        /* Overlay for better readability */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: -1;
        }

        /* Red top bar removed */

        .page-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            width: 100%;
            z-index: 1;
        }

        .header {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 20px 40px;
            box-sizing: border-box;
        }

        .auth-buttons {
            display: flex;
            gap: 20px;
        }

        .btn {
            padding: 10px 20px;
            border: 2px solid var(--manga-white);
            background-color: rgba(232, 59, 59, 0.4); /* More transparent buttons */
            color: var(--manga-white);
            text-decoration: none;
            font-weight: bold;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
            backdrop-filter: blur(5px);
        }

        .btn:hover {
            background-color: rgba(232, 59, 59, 0.6);
            color: var(--manga-white);
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.5);
        }

        .circle-container {
            display: flex;
            justify-content: center;
            margin: 60px 0;
        }

        .circle {
            width: 220px;
            height: 220px;
            border: 2px solid var(--manga-white);
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .welcome-icon-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 30px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .welcome-icon {
            width: 120px;
            height: 120px;
            object-fit: contain;
            margin-bottom: 16px;
        }

        .welcome-text {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            color: var(--manga-white); /* All text is white */
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        .features {
            display: flex;
            justify-content: space-between;
            gap: 40px;
            margin: 60px 40px 0;
        }

        .feature-box {
            flex: 1;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 30px 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 260px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .feature-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: var(--manga-white); /* Changed to white */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .feature-desc {
            font-size: 1.1rem;
            line-height: 1.5;
            color: var(--manga-white); /* Already white */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .footer {
            text-align: center;
            padding: 20px;
            margin-top: 60px;
            color: var(--manga-white); /* Already white */
            background-color: rgba(26, 26, 26, 0.7);
            backdrop-filter: blur(5px);
            position: relative;
            z-index: 1;
        }

        @media (max-width: 768px) {
            .features {
                flex-direction: column;
                gap: 30px;
                margin: 40px 20px 0;
            }
            
            .welcome-icon-wrapper {
                padding: 20px;
                margin: 0 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Video Background -->
    <div class="video-background">
        <video autoplay muted loop id="myVideo">
            <source src="{{ asset('images/welcome_background.mp4') }}" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>
    </div>
    
    <!-- Overlay for better readability -->
    <div class="overlay"></div>

    <!-- Red top bar removed -->

    <div class="page-container">
        <!-- Header -->
        <div class="header">
            <div class="auth-buttons">
                <a href="{{ route('login') }}" class="btn">Login</a>
                <a href="{{ route('register') }}" class="btn">Register</a>
            </div>
        </div>

        <!-- Welcome Circle -->
        <div class="circle-container">
            <div class="welcome-icon-wrapper">
                <img src="{{ asset('images/manga_logo.webp') }}" alt="Welcome Icon" class="welcome-icon">
                <div class="welcome-text">Welcome to our Manga Management</div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="features">
            <div class="feature-box">
                <div class="feature-icon">📚</div>
                <div class="feature-title">Catalog Management</div>
                <div class="feature-desc">Track your entire manga collection</div>
            </div>
            <div class="feature-box">
                <div class="feature-icon">🔍</div>
                <div class="feature-title">Advanced Search</div>
                <div class="feature-desc">Find exactly what you need</div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>© {{ date('Y') }} Manga Management System. All rights reserved.</p>
    </footer>

    <script>
        // Enhanced JavaScript to ensure video is properly loaded and visible
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('myVideo');
            
            // Force video to be visible
            video.style.visibility = 'visible';
            video.style.opacity = '1';
            
            // Ensure video source is correctly set and preload
            video.preload = 'auto';
            
            // Log message to confirm video loading
            video.addEventListener('loadeddata', function() {
                console.log('Video loaded successfully');
            });
            
            // Fallback if video fails to load
            video.addEventListener('error', function(e) {
                console.error('Video error:', e);
                document.body.style.backgroundColor = '#1a1a1a';
                console.log('Video failed to load, fallback applied');
            });

            // Check if browser supports autoplay
            video.play().catch(function(error) {
                console.log('Autoplay prevented:', error);
                // Add a play button if autoplay is prevented
                const playButton = document.createElement('button');
                playButton.innerHTML = 'Play Background';
                playButton.className = 'btn';
                playButton.style.position = 'fixed';
                playButton.style.bottom = '20px';
                playButton.style.left = '20px';
                playButton.style.zIndex = '10';
                
                playButton.addEventListener('click', function() {
                    video.play();
                    this.remove();
                });
                
                document.body.appendChild(playButton);
            });
        });
    </script>
</body>
</html>