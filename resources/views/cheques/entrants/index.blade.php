@extends('layouts.app')

@section('content')
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
