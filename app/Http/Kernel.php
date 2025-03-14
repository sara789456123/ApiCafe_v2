protected $routeMiddleware = [
    // ...
    'auth.token' => \App\Http\Middleware\CheckToken::class,
];
