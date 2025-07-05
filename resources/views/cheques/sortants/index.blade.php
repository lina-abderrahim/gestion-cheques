@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <!-- En-tête avec recherche et boutons -->
    <div class="px-6 py-4 border-b flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des Chèques sortants</h1>
        
        <div class="w-full md:w-auto flex flex-col sm:flex-row gap-3">
            <!-- Barre de recherche -->
            <form action="{{ route('cheques.sortants.index') }}" method="GET" class="flex-grow">
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
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left border-b">Numéro</th>
                    <th class="px-6 py-3 text-left border-b">Montant</th>
                    <th class="px-6 py-3 text-left border-b">Date Échéance</th>
                    <th class="px-6 py-3 text-left border-b">Banque</th>
                    <th class="px-6 py-3 text-left border-b">Tiers</th>
                    <th class="px-6 py-3 text-left border-b">Statut</th>
                    <th class="px-6 py-3 text-left border-b">Type</th>
                    <th class="px-6 py-3 text-left border-b">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($cheques as $cheque)
                <tr class="{{ 
                    ($cheque->type === 'entrant' ? 'bg-green-50' : 'bg-red-50') . 
                    (request('search') && str_contains($cheque->numero, request('search')) ? ' ring-2 ring-yellow-400' : '') 
                }}">
                    <td class="px-6 py-4">{{ $cheque->numero }}</td>
                    <td class="px-6 py-4">{{ number_format($cheque->montant, 2) }} DT</td>
                    <td class="px-6 py-4">{{ $cheque->date_echeance->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">{{ $cheque->banque }}</td>
                    <td class="px-6 py-4">{{ $cheque->tiers }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $cheque->statut === 'encaissé' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $cheque->statut }}
                        </span>
                    </td>
                    <td class="px-6 py-4 capitalize">{{ $cheque->type }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            @if($cheque->type === 'entrant')
                                <a href="{{ route('cheques.entrants.edit', $cheque) }}" 
                                   class="text-blue-600 hover:text-blue-800" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @else
                                <a href="{{ route('cheques.sortants.edit', $cheque) }}" 
                                   class="text-blue-600 hover:text-blue-800" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endif
                            <form action="{{ $cheque->type === 'entrant' 
                                          ? route('cheques.entrants.destroy', $cheque) 
                                          : route('cheques.sortants.destroy', $cheque) }}" 
                                  method="POST" onsubmit="return confirm('Êtes-vous sûr ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-800" title="Supprimer">
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
        {{ $cheques->appends(request()->query())->links() }}
    </div>
</div>
@endsection
