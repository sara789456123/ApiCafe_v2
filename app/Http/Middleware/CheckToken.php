namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');

        if (!$token || !$this->isValidToken($token)) {
            return response()->json(['message' => 'Token invalide'], 401);
        }

        return $next($request);
    }

    private function isValidToken($token)
    {
        // Implémentez votre logique de validation de token ici
        // Par exemple, vérifiez si le token existe dans une base de données ou une liste de tokens valides
        return true; // Pour l'instant, on accepte tous les tokens
    }
}
