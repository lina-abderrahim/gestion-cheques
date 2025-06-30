@extends('layouts.app')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">Ajouter un chèque sortant</h2>

    <form method="POST" action="{{ route('cheques.sortants.store') }}">
        @csrf
        <div class="mb-4">
            <label>Numéro :</label>
            <input type="text" name="numero" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label>Montant :</label>
            <input type="number" name="montant" step="0.01" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label>Date d’échéance :</label>
            <input type="date" name="date_echeance" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label>Banque :</label>
            <input type="text" name="banque" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label>Tiers :</label>
            <input type="text" name="tiers" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label>Commentaire :</label>
            <textarea name="commentaire" class="border p-2 w-full"></textarea>
        </div>

        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Enregistrer</button>
    </form>
</div>
@endsection
