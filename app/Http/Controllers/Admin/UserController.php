<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // On récupère les utilisateurs avec leur profil patient associé
        $query = User::with('patient')->where('role', '!=', 'admin');

        // Recherche par nom ou par numéro (dans la table patient)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('surname', 'like', '%' . $search . '%')
                  ->orWhereHas('patient', function($panel) use ($search) {
                      $panel->where('telephone', 'like', '%' . $search . '%');
                  });
            });
        }

        $users = $query->latest()->paginate(10);
        $totalUsers = User::where('role', '!=', 'admin')->count();

        return view('admin.utilisateur', compact('users', 'totalUsers'));
    }
}
