<!-- resources/views/challenge/cryptography/detail.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $question->title }} - CTF Challenge</title>
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
        
        .markdown {
            color: var(--discord-light);
        }
        
        .markdown h1, .markdown h2, .markdown h3 {
            color: white;
            font-weight: 600;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }
        
        .markdown h1 {
            font-size: 1.5rem;
        }
        
        .markdown h2 {
            font-size: 1.25rem;
        }
        
        .markdown h3 {
            font-size: 1.125rem;
        }
        
        .markdown p {
            margin-bottom: 1rem;
        }
        
        .markdown ul, .markdown ol {
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .markdown ul {
            list-style-type: disc;
        }
        
        .markdown ol {
            list-style-type: decimal;
        }
        
        .markdown pre {
            background-color: #23272a;
            padding: 1rem;
            border-radius: 0.375rem;
            overflow-x: auto;
            margin-bottom: 1rem;
        }
        
        .markdown code {
            font-family: monospace;
            background-color: #23272a;
            padding: 0.125rem 0.25rem;
            border-radius: 0.25rem;
        }
        
        .btn-primary {
            background-color: var(--discord-primary);
            transition: all 0.2s;
        }
        
        .btn-primary:hover {
            background-color: #4752c4;
        }
        
        .input-focus:focus {
            border-color: var(--discord-primary);
            box-shadow: 0 0 0 2px rgba(88, 101, 242, 0.25);
        }
    </style>
</head>
<body class="min-h-screen bg-[#36393f] text-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Back button and info -->
        <div class="mb-6">
            <a href="{{ route('challenge.list', ['type' => $question->type]) }}" class="inline-flex items-center text-gray-400 hover:text-white">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to {{ ucfirst($question->type) }} challenges
            </a>
        </div>
        
        <!-- Challenge Card -->
        <div class="bg-[#2f3136] rounded-xl overflow-hidden shadow-lg border border-gray-700">
            <!-- Header -->
            <div class="p-6 pb-4 border-b border-gray-700">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-white">{{ $question->title }}</h1>
                    <span class="bg-[#5865f2] text-white px-3 py-1 rounded-full text-sm">{{ ucfirst($question->type) }}</span>
                </div>
            </div>
            
            <!-- Challenge description -->
            <div class="p-6">
                <div class="markdown">
                    {!! $question->description !!}
                </div>
                
                <!-- Attachment if available -->
                @if($question->attachment)
                <div class="mt-6 p-4 bg-[#23272a] rounded-lg">
                    <h3 class="text-white font-medium mb-3">Attachment</h3>
                    <a href="{{ asset('storage/' . $question->attachment) }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-md text-sm font-medium"
                       target="_blank" download>
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download attachment
                    </a>
                </div>
                @endif
                
                <!-- Flag submission form -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-white mb-3">Submit Flag</h3>
                    
                    @if(session('success'))
                    <div class="bg-green-500/10 text-green-500 px-4 py-3 rounded-md mb-4">
                        {{ session('success') }}
                    </div>
                    @endif
                    
                    @if(session('error'))
                    <div class="bg-red-500/10 text-red-500 px-4 py-3 rounded-md mb-4">
                        {{ session('error') }}
                    </div>
                    @endif
                    
                    <form action="{{ route('challenge.submit', ['type' => $type, 'id' => $question->flag_id]) }}" method="POST">
                        @csrf
                        <div class="flex">
                            <input type="text" name="flag" placeholder="Enter flag here (e.g. flag{...})" 
                                class="flex-1 bg-[#23272a] border border-gray-700 rounded-l-md px-4 py-2 text-white input-focus focus:outline-none" required>
                            <button type="submit" class="btn-primary px-6 py-2 rounded-r-md text-white font-medium">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 