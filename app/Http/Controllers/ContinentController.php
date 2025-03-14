namespace App\Http\Controllers;

use App\Models\Continent;
use Illuminate\Http\Request;

class ContinentController extends Controller
{
    public function index()
    {
        $continents = Continent::orderBy('nom')->get();
        return response()->json($continents);
    }
}
