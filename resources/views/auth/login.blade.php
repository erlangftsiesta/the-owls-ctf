<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Modern Minimalist</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --discord-primary: #5865f2;
            --discord-dark: #36393f;
            --discord-darker: #2f3136;
            --discord-light: #dcddde;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--discord-dark);
        }
        
        .input-focus:focus {
            border-color: var(--discord-primary);
            box-shadow: 0 0 0 2px rgba(88, 101, 242, 0.25);
        }
        
        .btn-primary {
            background-color: var(--discord-primary);
            transition: all 0.2s;
        }
        
        .btn-primary:hover {
            background-color: #4752c4;
        }
        
        .link-text {
            color: var(--discord-primary);
            transition: all 0.2s;
        }
        
        .link-text:hover {
            color: #4752c4;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-[#36393f] text-gray-100 p-4">
    <div class="w-full max-w-md">
        <div class="bg-[#2f3136] rounded-xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="p-6 pb-3">
                <h1 class="text-2xl font-bold text-center text-white">Nice to see u again!</h1>
                <p class="text-center text-gray-400 text-sm mt-1">Login to your account and conquer all the challenges!</p>
            </div>
            
            <!-- Form -->
            <div class="p-6 pt-3">
                <!-- Error Display -->
                @if($errors->any())
                <div class="bg-red-500/10 text-red-500 px-4 py-3 rounded-md mb-4">
                    {{ $errors->first() }}
                </div>
                @endif

                <form method="POST" action="{{ route('login.authenticate') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="username" class="block text-gray-400 text-xs font-medium uppercase tracking-wide mb-1">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" 
                            class="w-full bg-[#23272a] border border-gray-700 rounded-md px-4 py-2 text-white input-focus focus:outline-none"
                            autocomplete="off">
                    </div>
                    
                    <div class="mb-6">
                        <label for="password" class="block text-gray-400 text-xs font-medium uppercase tracking-wide mb-1">Password</label>
                        <input type="password" id="password" name="password" 
                            class="w-full bg-[#23272a] border border-gray-700 rounded-md px-4 py-2 text-white input-focus focus:outline-none">
                    </div>
                    
                    <div class="flex flex-col gap-2">
                        <button type="submit" class="btn-primary w-full text-white font-medium py-2.5 rounded-md">
                            Login
                        </button>
                        
                        <div class="text-center mt-2">
                            <a href="{{ route('register') }}" class="link-text text-sm">
                                Don't have an account yet?
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="mt-4 text-center text-xs text-gray-500">
            &copy; 2025 · Modern Auth System
        </div>
    </div>
</body>
</html>