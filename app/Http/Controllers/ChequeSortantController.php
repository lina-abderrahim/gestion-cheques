<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChequeSortantController extends Controller
{
    public function index()
    {
        $cheques = Cheque::where('type', 'sortant')->orderByDesc('created_at')->get();
        return view('cheques.sortants.index', compact('cheques'));
    }

    public function create()
    {
        return view('cheques.sortants.create');
    }

    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validated = $request->validate([
            'numero' => 'required|unique:cheques',
            'montant' => 'required|numeric',
            'date_echeance' => 'required|date',
            'banque' => 'required|string',
            'tiers' => 'required|string',
            'commentaire' => 'nullable|string',
        ]);

        // Ajouter les champs fixes
        $validated['type'] = 'sortant';
        $validated['statut'] = 'en_attente';
        $validated['user_id'] = auth()->id();

        // Enregistrer le chèque
        Cheque::create($validated);

        // Rediriger avec message de succès
        return redirect()->route('cheques.sortants.index')->with('success', 'Chèque sortant ajouté avec succès.');
    }
    public function edit(Cheque $cheque)
{
    return view('cheques.sortants.edit', compact('cheque'));
}

public function update(Request $request, Cheque $cheque)
{
    $request->validate([
        'numero' => 'required|unique:cheques,numero,'.$cheque->id,
        'montant' => 'required|numeric',
        'date_echeance' => 'required|date',
        'banque' => 'required|string',
        'tiers' => 'required|string',
        'type' => 'required|in:entrant,sortant',
        'statut' => 'required|in:en_attente,encaisse,paye,annule',
    ]);

    $cheque->update($request->all());

    return redirect()->route('cheques.sortants.index')
                    ->with('success', 'Chèque modifié avec succès');
}

public function destroy(Cheque $cheque)
{
    $cheque->delete();

    return redirect()->route('cheques.sortants.index')
                    ->with('success', 'Chèque supprimé avec succès');
}
public function search(Request $request)
{
    $query = $request->input('q');

    $cheques = Cheque::where('type', 'sortant')
        ->where(function ($q) use ($query) {
            $q->where('numero', 'like', "%{$query}%")
              ->orWhere('montant', 'like', "%{$query}%")
              ->orWhere('tiers', 'like', "%{$query}%");
        })
        ->get();

    return view('cheques.sortants.index', compact('cheques', 'query'));
}
}
