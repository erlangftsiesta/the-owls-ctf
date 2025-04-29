// app/Http/Kernel.php
protected $routeMiddleware = [
    // Middleware lainnya
    'auth' => \App\Http\Middleware\Authenticate::class,
];