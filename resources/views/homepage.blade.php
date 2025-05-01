<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Owls CTF</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        discord: {
                            900: '#202225', // Discord background
                            800: '#2f3136', // Discord darker sidebar
                            700: '#36393f', // Discord main area
                            600: '#40444b', // Discord input area
                            500: '#72767d', // Discord text
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-discord-900 text-gray-200 min-h-screen">
    <!-- Navbar -->
    <nav class="fixed w-full top-0 z-50 bg-discord-800 border-b border-discord-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Left side - Logo -->
                <img src="{{ asset('images/TheOwlNav.png') }}" alt="Logo">
                <div class="hidden md:flex items-center">
                    <div class="font-bold text-lg md:text-xl">
                        The Owls
                    </div>
                </div>
                
                <!-- Center - Title -->
                <div class="hidden md:flex items-center justify-center flex-1">
                    <h1 class="font-bold text-xl md:text-2xl lg:text-3xl text-white"></h1>
                </div>
                
                <!-- Mobile title (shown on mobile only) -->
                <div class="md:hidden flex items-center justify-center flex-1">
                    <h1 class="font-bold text-lg text-white"></h1>
                </div>
                
                <!-- Right side - Profile Icon -->
                <div class="flex items-center">
                    <div class="ml-4 flex items-center">
                        <button class="p-1 rounded-full text-gray-300 hover:text-white focus:outline-none">
                            <a href="{{ auth()->check() ? route('homepage') : route('login') }}" class="p-1 rounded-full text-gray-300 hover:text-white focus:outline-none">
                                <span class="sr-only">Profile</span>
                                <i class="fas fa-user-circle text-4xl"></i>
                            </a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main content with padding to account for fixed navbar -->
    <main class="pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-8">
                @if (!auth()->check())

                <!-- Hero section -->
                <div class="bg-discord-700 rounded-lg shadow-lg p-6 mb-8">
                    <h2 class="text-2xl font-bold mb-4">Welcome to The Owls CTF Challenge</h2>
                    <p class="mb-4">Join with us and test your skills in this cybersecurity challenge and capture the flag!</p>
                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        <a href="{{ route('login') }}" class="btn btn-link">Get it Now!</a>
                    </button>
                </div>
                @endif
                
                <!-- Challenge categories -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                    @foreach ($types as $type)
                    <div class="bg-discord-700 rounded-lg shadow-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold">{{ ucfirst(str_replace('-', ' ', $type)) }}</h3>
                            <span class="bg-indigo-600 text-white text-xs font-semibold py-1 px-2 rounded-full">
                                {{ $challenge_counts[$type] }}
                            </span>
                        </div>
                        <p class="text-gray-300 mb-4">
                            @if ($type === 'web-exploitation')
                                Test your skills in SQL injection, XSS, and other web vulnerabilities.
                            @elseif ($type === 'cryptography')
                                Decrypt messages, crack codes, and solve cryptographic puzzles.
                            @else
                                Explore unique challenges in {{ $type }}.
                            @endif
                        </p>
                        <button class="text-indigo-400 hover:text-indigo-300 font-medium">
                            <a href="{{ route('challenge.list', ['type' => $type]) }}">View Challenges →</a>
                        </button>
                    </div>
                @endforeach
                </div>                
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bottom-0 bg-discord-800 border-t border-discord-600 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-center md:text-left mb-4 md:mb-0">
                    <p class="text-gray-400">&copy; 2025 The Flag DevRPL. All rights reserved.</p>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-discord"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // JavaScript untuk navbar sticky
        document.addEventListener('DOMContentLoaded', function () {
            const navbar = document.querySelector('nav');
            
            window.addEventListener('scroll', function() {
                if (window.scrollY > 0) {
                    navbar.classList.add('shadow-md');
                } else {
                    navbar.classList.remove('shadow-md');
                }
            });
        });
    </script>
</body>
</html>