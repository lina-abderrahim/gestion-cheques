@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Modifier le paramètre</h1>

    <form action="{{ route('parametres.update', $parametre) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700 font-medium mb-1">Clé</label>
            <input type="text" value="{{ $parametre->cle }}" disabled
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 text-gray-600 cursor-not-allowed">
        </div>

        <div>
            <label for="valeur" class="block text-gray-700 font-medium mb-1">Valeur</label>
            <input type="text" name="valeur" id="valeur" value="{{ old('valeur', $parametre->valeur) }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required>
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-1">Description</label>
            <textarea class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 text-gray-600" disabled>{{ $parametre->description }}</textarea>
        </div>

        <div class="flex justify-end mt-6">
            <a href="{{ route('parametres.index') }}" class="mr-4 text-gray-600 hover:text-blue-600">Annuler</a>
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">💾 Enregistrer</button>
        </div>
    </form>
</div>
@endsection
