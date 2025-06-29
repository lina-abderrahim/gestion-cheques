<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use Illuminate\Http\Request;

class ChequeEntrantController extends Controller
{
    public function index()
    {
        $cheques = Cheque::where('type', 'entrant')->orderByDesc('created_at')->get();
        return view('cheques.entrants.index', compact('cheques'));
    }

    public function create()
    {
        return view('cheques.entrants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|unique:cheques',
            'montant' => 'required|numeric',
            'date_echeance' => 'required|date',
            'banque' => 'required|string',
            'tiers' => 'required|string',
        ]);

        Cheque::create([
            'numero' => $request->numero,
            'montant' => $request->montant,
            'type' => 'entrant',
            'date_echeance' => $request->date_echeance,
            'statut' => 'en_attente',
            'banque' => $request->banque,
            'tiers' => $request->tiers,
            'commentaire' => $request->commentaire,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('cheques.entrants.index')->with('success', 'Chèque entrant ajouté.');
    }
}

