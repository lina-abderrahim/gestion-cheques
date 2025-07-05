<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use App\Models\Notification;
use Illuminate\Http\Request;

class ChequeEntrantController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Cheque::where('type', 'entrant')->orderByDesc('created_at');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('numero', 'like', "%{$search}%")
                  ->orWhere('montant', 'like', "%{$search}%")
                  ->orWhere('tiers', 'like', "%{$search}%")
                  ->orWhere('banque', 'like', "%{$search}%");
            });
        }

        $cheques = $query->paginate(10)->withQueryString();

        return view('cheques.entrants.index', compact('cheques', 'search'));
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

        $cheque = Cheque::create([
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

        Notification::create([
            'cheque_id' => $cheque->id,
            'type' => 'alerte_entrant',
            'message' => 'Chèque entrant à écheance demain (n°' . $cheque->numero . ')',
            'is_read' => false,
        ]);

        return redirect()->route('cheques.entrants.index')->with('success', 'Chèque entrant ajouté.');
    }

    public function edit(Cheque $cheque)
    {
        if ($cheque->type !== 'entrant') abort(403);
        return view('cheques.entrants.edit', compact('cheque'));
    }

    public function update(Request $request, Cheque $cheque)
    {
        if ($cheque->type !== 'entrant') abort(403);

        $request->validate([
            'numero' => 'required|unique:cheques,numero,' . $cheque->id,
            'montant' => 'required|numeric',
            'date_echeance' => 'required|date',
            'banque' => 'required|string',
            'tiers' => 'required|string',
            'statut' => 'required|string',
            'type' => 'required|string'
        ]);

        $cheque->update($request->all());

        $type = $cheque->type;
        $numero = $cheque->numero;
        $message = match($type) {
    'entrant' => "Chèque entrant à échéance demain (n°$numero)",
    'sortant' => "Chèque sortant à échéance aujourd'hui (n°$numero)",
    default   => "Chèque mis à jour (n°$numero)",};
    
    Notification::updateOrCreate(
    ['cheque_id' => $cheque->id],
    [
        'type' => 'alerte_' . $type,
        'message' => $message,
        'is_read' => false,
    ]);


        return redirect()->route('cheques.entrants.index')->with('success', 'Chèque modifié avec succès.');
    }

    public function destroy(Cheque $cheque)
    {
        if ($cheque->type !== 'entrant') abort(403);

        Notification::where('cheque_id', $cheque->id)->delete();
        $cheque->delete();

        return redirect()->route('cheques.entrants.index')->with('success', 'Chèque supprimé.');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $cheques = Cheque::where('type', 'entrant')
            ->where(function ($q) use ($query) {
                $q->where('numero', 'like', "%{$query}%")
                  ->orWhere('montant', 'like', "%{$query}%")
                  ->orWhere('tiers', 'like', "%{$query}%")
                  ->orWhere('banque', 'like', "%{$query}%");
            })
            ->paginate(10)
            ->withQueryString();

        return view('cheques.entrants.index', compact('cheques', 'query'));
    }
}