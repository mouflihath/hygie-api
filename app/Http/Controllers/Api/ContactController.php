<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller {
    public function store(Request $request) {
        try {
            Contact::create([
                'nom'     => $request->nom,
                'email'   => $request->email,
                'sujet'   => $request->sujet ?? 'Commentaire client',
                'message' => $request->message,
            ]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}