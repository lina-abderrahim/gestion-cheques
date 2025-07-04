@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8 bg-white shadow-md rounded p-6">
    <h2 class="text-2xl font-semibold mb-6 text-center text-gray-700">Modifier le chèque entrant</h2>

    <form method="POST" action="{{ route('cheques.entrants.update', $cheque) }}" class="space-y-4">
        @csrf
        @method('PUT')

        {{-- Numéro --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Numéro</label>
            <input type="text" name="numero" value="{{ old('numero', $cheque->numero) }}" required
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-green-200">
        </div>

     

        {{-- Montant --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Montant</label>
            <input type="number" step="0.01" name="montant" value="{{ old('montant', $cheque->montant) }}" required
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-green-200">
        </div>

        {{-- Échéance --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Date d’échéance</label>
            <input type="date" name="date_echeance" value="{{ old('date_echeance', $cheque->date_echeance) }}" required
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-green-200">
        </div>

        {{-- Banque --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Banque</label>
            <input type="text" name="banque" value="{{ old('banque', $cheque->banque) }}" required
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-green-200">
        </div>

        {{-- Tiers --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Tiers</label>
            <input type="text" name="tiers" value="{{ old('tiers', $cheque->tiers) }}" required
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-green-200">
        </div>
           {{-- Type --}}

           <div>
            <label class="block text-sm font-medium text-gray-700">Type</label>
            <select name="type" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                <option value="entrant" {{ old('type', $cheque->type) == 'entrant' ? 'selected' : '' }}>Entrant</option>
                <option value="sortant" {{ old('type', $cheque->type) == 'sortant' ? 'selected' : '' }}>Sortant</option>
            </select>
        </div>
        

       {{-- statut --}}

        <div>
    <label class="block text-sm font-medium text-gray-700">Statut</label>
    <select name="statut" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
        <option value="en_attente" {{ old('statut', $cheque->statut) == 'en_attente' ? 'selected' : '' }}>En attente</option>
        <option value="encaisse" {{ old('statut', $cheque->statut) == 'encaisse' ? 'selected' : '' }}>Encaissé</option>
        <option value="paye" {{ old('statut', $cheque->statut) == 'paye' ? 'selected' : '' }}>Payé</option>
        <option value="annule" {{ old('statut', $cheque->statut) == 'annule' ? 'selected' : '' }}>Annulé</option>
    </select>
</div>


        {{-- Commentaire --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Commentaire</label>
            <textarea name="commentaire" rows="3"
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring focus:ring-green-200">{{ old('commentaire', $cheque->commentaire) }}</textarea>
        </div>

        {{-- Bouton --}}
        <div class="text-center">
            <button type="submit"
                class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded">
                Enregistrer les modifications
            </button>
        </div>

    </form>
</div>
@endsection
