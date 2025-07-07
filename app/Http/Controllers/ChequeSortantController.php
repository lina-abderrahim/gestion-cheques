<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use App\Models\Log;
use App\Models\Notification;
use Illuminate\Http\Request;

class ChequeSortantController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Cheque::where('type', 'sortant')->orderByDesc('created_at');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('numero', 'like', "%{$search}%")
                  ->orWhere('montant', 'like', "%{$search}%")
                  ->orWhere('tiers', 'like', "%{$search}%")
                  ->orWhere('banque', 'like', "%{$search}%");
            });
        }

        $cheques = $query->paginate(10)->withQueryString();

        return view('cheques.sortants.index', compact('cheques', 'search'));
    }

    public function create()
    {
        return view('cheques.sortants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero' => 'required|unique:cheques',
            'montant' => 'required|numeric',
            'date_echeance' => 'required|date',
            'banque' => 'required|string',
            'tiers' => 'required|string',
            'commentaire' => 'nullable|string',
        ]);

        $validated['type'] = 'sortant';
        $validated['statut'] = 'en_attente';
        $validated['user_id'] = auth()->id();

        $cheque = Cheque::create($validated);

        Notification::create([
            'cheque_id' => $cheque->id,
            'type' => 'alerte_sortant',
            'message' => 'chéque sortant à écheance aujourd\'hui  (n°' . $cheque->numero . ')',
            'is_read' => false,
        ]);

        Log::enregistrer(auth()->id(), 'Création chèque sortant', 'cheque', [
    'numero' => $cheque->numero,
    'montant' => $cheque->montant
]);


        return redirect()->route('cheques.sortants.index')->with('success', 'Chèque sortant ajouté avec succès.');
    }

    public function edit(Cheque $cheque)
    {
        return view('cheques.sortants.edit', compact('cheque'));
    }

    public function update(Request $request, Cheque $cheque)
    {
        $request->validate([
            'numero' => 'required|unique:cheques,numero,' . $cheque->id,
            'montant' => 'required|numeric',
            'date_echeance' => 'required|date',
            'banque' => 'required|string',
            'tiers' => 'required|string',
            'type' => 'required|in:entrant,sortant',
            'statut' => 'required|in:en_attente,encaisse,paye,annule',
        ]);

        $cheque->update($request->all());

                $type = $cheque->type;
        $numero = $cheque->numero;
        $message = match($type) {
    'entrant' => "📌Chèque entrant à échéance demain (n°$numero)",
    'sortant' => "📌Chèque sortant à échéance aujourd'hui (n°$numero)",
    default   => "📌Chèque mis à jour (n°$numero)",};
    
    Notification::updateOrCreate(
    ['cheque_id' => $cheque->id],
    [
        'type' => 'alerte_' . $type,
        'message' => $message,
        'is_read' => false,
    ]);

    Log::enregistrer(auth()->id(), 'Modification chèque sortant', 'cheque', [
    'numero' => $cheque->numero,
    'montant' => $cheque->montant
]);


        return redirect()->route('cheques.sortants.index')->with('success', 'Chèque modifié avec succès.');
    }

    public function destroy(Cheque $cheque)
    {
        Notification::where('cheque_id', $cheque->id)->delete();
        $cheque->delete();

        Log::enregistrer(auth()->id(), 'Suppression chèque sortant', 'cheque', ['numero' => $cheque->numero]);


        return redirect()->route('cheques.sortants.index')->with('success', 'Chèque supprimé avec succès.');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $cheques = Cheque::where('type', 'sortant')
            ->where(function ($q) use ($query) {
                $q->where('numero', 'like', "%{$query}%")
                  ->orWhere('montant', 'like', "%{$query}%")
                  ->orWhere('tiers', 'like', "%{$query}%")
                  ->orWhere('banque', 'like', "%{$query}%");
            })
            ->paginate(10)
            ->withQueryString();

        return view('cheques.sortants.index', compact('cheques', 'query'));
    }
}
