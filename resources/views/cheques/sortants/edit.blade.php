@extends('layouts.app')

@section('content')
<div class="p-6 max-w-xl mx-auto">
    <h2 class="text-xl font-semibold mb-4">Modifier le chèque sortant</h2>

    <form method="POST" action="{{ route('cheques.sortants.update', $cheque) }}">
        @csrf
        @method('PUT')

        {{-- Numéro --}}
        <label class="block mb-2">Numéro :</label>
        <input type="text" name="numero" class="w-full border p-2 mb-4" value="{{ old('numero', $cheque->numero) }}" required>

        {{-- Montant --}}
        <label class="block mb-2">Montant :</label>
        <input type="number" step="0.01" name="montant" class="w-full border p-2 mb-4" value="{{ old('montant', $cheque->montant) }}" required>

        {{-- Échéance --}}
        <label class="block mb-2">Date d’échéance :</label>
        <input type="date" name="date_echeance" class="w-full border p-2 mb-4" value="{{ old('date_echeance', $cheque->date_echeance) }}" required>

        {{-- Banque --}}
        <label class="block mb-2">Banque :</label>
        <input type="text" name="banque" class="w-full border p-2 mb-4" value="{{ old('banque', $cheque->banque) }}" required>

        {{-- Tiers --}}
        <label class="block mb-2">Tiers :</label>
        <input type="text" name="tiers" class="w-full border p-2 mb-4" value="{{ old('tiers', $cheque->tiers) }}" required>

        {{-- Commentaire --}}
        <label class="block mb-2">Commentaire :</label>
        <textarea name="commentaire" class="w-full border p-2 mb-4">{{ old('commentaire', $cheque->commentaire) }}</textarea>

        {{-- Type --}}
        <label class="block mb-2">Type :</label>
        <select name="type" class="w-full border p-2 mb-4" required>
            <option value="entrant" {{ old('type', $cheque->type) == 'entrant' ? 'selected' : '' }}>Entrant</option>
            <option value="sortant" {{ old('type', $cheque->type) == 'sortant' ? 'selected' : '' }}>Sortant</option>
        </select>

        {{-- Statut --}}
        <label class="block mb-2">Statut :</label>
        <select name="statut" class="w-full border p-2 mb-4" required>
            <option value="en_attente" {{ old('statut', $cheque->statut) == 'en_attente' ? 'selected' : '' }}>En attente</option>
            <option value="encaisse" {{ old('statut', $cheque->statut) == 'encaisse' ? 'selected' : '' }}>Encaissé</option>
            <option value="paye" {{ old('statut', $cheque->statut) == 'paye' ? 'selected' : '' }}>Payé</option>
            <option value="annule" {{ old('statut', $cheque->statut) == 'annule' ? 'selected' : '' }}>Annulé</option>
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Modifier</button>
    </form>
</div>
@endsection
