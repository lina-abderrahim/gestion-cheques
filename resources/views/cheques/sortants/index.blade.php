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

    {{-- 🔽 Le reste de ton tableau / contenu commence ici --}}
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Liste des chèques sortants</h1>

        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200"> {{-- Fond gris clair pour toute la ligne d'en-tête --}}
                    <th class="border px-4 py-2">Numéro</th>
                    <th class="border px-4 py-2">Montant</th>
                    <th class="border px-4 py-2">Date échéance</th>
                    <th class="border px-4 py-2">Banque</th>
                    <th class="border px-4 py-2">Tiers</th>
                    <th class="border px-4 py-2">Statut</th>
                    <th class="border px-4 py-2">Type</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cheques as $cheque)
                    <tr class="text-center">
                        <td class="border px-4 py-2">{{ $cheque->numero }}</td>
                        <td class="border px-4 py-2">{{ $cheque->montant }}</td>
                        <td class="border px-4 py-2">{{ $cheque->date_echeance }}</td>
                        <td class="border px-4 py-2">{{ $cheque->banque }}</td>
                        <td class="border px-4 py-2">{{ $cheque->tiers }}</td>
                        <td class="border px-4 py-2">{{ $cheque->statut }}</td>
                        <td class="border px-4 py-2">{{ $cheque->type }}</td>
                        <td class="border px-4 py-2 flex justify-center gap-2">
                            <a href="{{ route('cheques.sortants.edit', $cheque) }}" 
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                                Modifier
                            </a>

                            <form method="POST" action="{{ route('cheques.sortants.destroy', $cheque) }}" onsubmit="return confirm('Supprimer ce chèque ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
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
