@extends('layouts.app')
@section('content')
    {{-- ✅ Message flash de succès --}}
    @if (session('success'))
        <div id="flash-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}

            {{-- Bouton de fermeture manuelle --}}
            <button onclick="this.parentElement.style.display='none'" class="absolute top-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-green-700" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>Fermer</title>
                    <path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 001.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"/>
                </svg>
            </button>
        </div>

        {{-- Script pour disparition automatique après 3 secondes --}}
        <script>
            setTimeout(() => {
                const flash = document.getElementById('flash-message');
                if (flash) flash.style.display = 'none';
            }, 3000);
        </script>
    @endif
    <div class="p-6">
        <h2 class="text-xl font-semibold mb-4">Liste des chèques entrants</h2>

        <a href="{{ route('cheques.entrants.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">+ Ajouter</a>

        <table class="w-full mt-4 border">
            <thead>
                <tr class="bg-gray-200 text-center">
                    <th>Numéro</th>
                    <th>Montant</th>
                    <th>Banque</th>
                    <th>Tiers</th>
                    <th>Échéance</th>
                    <th>Statut</th>
                    <th>Actions</th> {{-- ✅ Nouvelle colonne --}}
                </tr>
            </thead>
            <tbody>
                @foreach($cheques as $cheque)
                    <tr class="text-center border-t">
                        <td>{{ $cheque->numero }}</td>
                        <td>{{ $cheque->montant }} DT</td>
                        <td>{{ $cheque->banque }}</td>
                        <td>{{ $cheque->tiers }}</td>
                        <td>{{ $cheque->date_echeance }}</td>
                        <td>{{ $cheque->statut }}</td>
                        <td class="flex justify-center gap-2 py-2">
                            {{-- 🔵 Modifier --}}
                            <a href="{{ route('cheques.entrants.edit', $cheque) }}"
                               class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                Modifier
                            </a>

                            {{-- 🔴 Supprimer --}}
                            <form action="{{ route('cheques.entrants.destroy', $cheque) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
