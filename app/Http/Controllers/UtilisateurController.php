namespace App\Http\Controllers;

use App\Models\Utilisateur;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UtilisateurController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'mdp' => 'required|string',
        ]);

        $utilisateur = Utilisateur::where('login', $request->login)->first();

        if ($utilisateur && $utilisateur->validatePassword($request->mdp)) {
            $token = $utilisateur->generateToken();
            return response()->json(['token' => $token], 200);
        }

        return response()->json(['message' => 'Identifiants invalides'], 401);
    }
}
