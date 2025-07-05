@extends('layouts.app')

@section('content')
    <div class="p-6">
        <h2 class="text-xl font-semibold mb-4">Ajouter un chèque entrant</h2>

        <form method="POST" action="{{ route('cheques.entrants.store') }}">
            @csrf
            <div class="mb-4">
                <label>Numéro :</label>
                <input name="numero" class="w-full border p-2" required>
            </div>
            <div class="mb-4">
                <label>Montant :</label>
                <input name="montant" type="number" step="0.01" class="w-full border p-2" required>
            </div>
            <div class="mb-4">
                <label>Date d’échéance :</label>
                <input name="date_echeance" type="date" class="w-full border p-2" required>
            </div>
            <div class="mb-4">
                <label>Banque :</label>
                <input name="banque" class="w-full border p-2" required>
                
            </div>
            <div class="mb-4">
                <label>Tiers :</label>
                <input name="tiers" class="w-full border p-2" required>
            </div>
            <div class="mb-4">
                <label>Commentaire :</label>
                <textarea name="commentaire" class="w-full border p-2"></textarea>
            </div>
            <button class="bg-blue-500 text-white px-4 py-2 rounded">Enregistrer</button>
        </form>
    </div>
@endsection