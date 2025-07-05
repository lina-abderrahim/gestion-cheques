@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <!-- En-tête avec recherche et boutons -->
    <div class="px-6 py-4 border-b flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des Chèques entrants</h1>
        
        <div class="w-full md:w-auto flex flex-col sm:flex-row gap-3">
            <!-- Barre de recherche -->
            <form action="{{ route('cheques.entrants.index') }}" method="GET" class="flex-grow">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                           placeholder="Rechercher...">
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </form>
            
            <!-- Boutons d'action -->
            <div class="flex gap-2">
                <a href="{{ route('cheques.entrants.create') }}" 
                   class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center gap-2">
                    <i class="fas fa-plus"></i> Entrant
                </a>
                <a href="{{ route('cheques.sortants.create') }}" 
                   class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center gap-2">
                    <i class="fas fa-plus"></i> Sortant
                </a>
            </div>
        </div>
    </div>

    <!-- Tableau des chèques -->
    <div class="table-container overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">Numéro</th>
                    <th class="px-6 py-3 text-left">Montant</th>
                    <th class="px-6 py-3 text-left">Date Échéance</th>
                    <th class="px-6 py-3 text-left">Banque</th>
                    <th class="px-6 py-3 text-left">Tiers</th>
                    <th class="px-6 py-3 text-left">Statut</th>
                    <th class="px-6 py-3 text-left">Commentaire</th> 
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($cheques as $cheque)
                <tr class="bg-green-50">
                    <td class="px-6 py-4">{{ $cheque->numero }}</td>
                    <td class="px-6 py-4">{{ number_format($cheque->montant, 2) }} DT</td>
                    <td class="px-6 py-4">{{ $cheque->date_echeance->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">{{ $cheque->banque }}</td>
                    <td class="px-6 py-4">{{ $cheque->tiers }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $cheque->statut === 'encaisse' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $cheque->statut }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        {{ $cheque->commentaire ?? '—' }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('cheques.entrants.edit', $cheque) }}" 
                               class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('cheques.entrants.destroy', $cheque) }}" 
                                  method="POST" onsubmit="return confirm('Supprimer ce chèque ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                        Aucun chèque trouvé
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t">
        {{ $cheques->links() }}
    </div>
</div>
@endsection
