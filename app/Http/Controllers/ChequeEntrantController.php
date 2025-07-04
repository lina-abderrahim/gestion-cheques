<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

            Notification::checkAlertes();


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
        'statut'=>'required|string',
        'type'=>'required|string'
    ]);

    $cheque->update($request->all());

    Notification::checkAlertes();
    Notification::where('cheque_id', $cheque->id)->update([
    'type' => 'alerte_' . $cheque->type,
    'message' => 'Chèque ' . $cheque->type . ' à échéance aujourd\'hui (n°' . $cheque->numero . ')',
]);


    return redirect()->route('cheques.entrants.index')->with('success', 'Chèque modifié avec succès.');
}
    public function destroy(Cheque $cheque)
{
    if ($cheque->type !== 'entrant') abort(403);

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
              ->orWhere('tiers', 'like', "%{$query}%");
        })
        ->get();

    return view('cheques.entrants.index', compact('cheques', 'query'));
}

}

