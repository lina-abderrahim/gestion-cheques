@extends('layouts.app')

@section('content')

@if(session('success'))
    <div id="flash-message" class="mb-6 p-4 bg-green-100 text-green-800 rounded shadow">
        {{ session('success') }}
    </div>
@endif

{{-- Barre de recherche --}}
<div class="mb-6 bg-white p-4 rounded shadow">
    <form action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-4">
        <input type="text" 
               name="search" 
               class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500"
               placeholder="Rechercher par numéro, montant, tiers, banque, commentaire..."
               value="{{ request('search') }}">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
            🔍 Rechercher
        </button>
        @if(request('search'))
            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700">
                ❌ Effacer
            </a>
        @endif
    </form>
</div>

@if(isset($nbNotifsNonLues) && $nbNotifsNonLues > 0)
    <div class="mb-4 p-2 bg-yellow-200 text-yellow-900 rounded font-semibold">
        Vous avez {{ $nbNotifsNonLues }} notification(s) non lue(s).
    </div>
@endif

{{-- Boutons d’action --}}
<div class="flex justify-end gap-4 mb-6">
    <a href="{{ route('cheques.entrants.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded">
        + Nouveau Chèque Entrant
    </a>
    <a href="{{ route('cheques.sortants.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2 rounded">
        + Nouveau Chèque Sortant
    </a>
</div>

{{-- Tableau des chèques --}}
<div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full border border-gray-300 text-sm">
        <thead class="bg-gray-200 text-gray-700 uppercase text-xs">
            <tr>
                <th class="border px-6 py-3">Numéro</th>
                <th class="border px-6 py-3">Montant</th>
                <th class="border px-6 py-3">Date échéance</th>
                <th class="border px-6 py-3">Banque</th>
                <th class="border px-6 py-3">Tiers</th>
                <th class="border px-6 py-3">Statut</th>
                <th class="border px-6 py-3">Type</th>
                <th class="border px-6 py-3">Commentaire</th> 
                <th class="border px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cheques as $cheque)
                @php
                    $search = strtolower(request('search'));
                    $match = $search && (
                        Str::contains(strtolower($cheque->numero), $search) ||
                        Str::contains(strtolower($cheque->montant), $search) ||
                        Str::contains(strtolower($cheque->tiers), $search) ||
                        Str::contains(strtolower($cheque->banque), $search) ||
                        Str::contains(strtolower($cheque->commentaire ?? ''), $search)
                    );
                @endphp

                <tr class="{{ $cheque->type === 'entrant' ? 'bg-green-50' : 'bg-red-50' }} {{ $match ? 'bg-yellow-100 border-yellow-300 font-semibold' : '' }}">
                    <td class="px-6 py-4">{!! $match ? highlightText($cheque->numero, $search) : e($cheque->numero) !!}</td>
                    <td class="px-6 py-4">{!! $match ? highlightText($cheque->montant, $search) : e($cheque->montant) !!} DT</td>
                    <td class="px-6 py-4">{{ $cheque->date_echeance->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">{!! $match ? highlightText($cheque->banque, $search) : e($cheque->banque) !!}</td>
                    <td class="px-6 py-4">{!! $match ? highlightText($cheque->tiers, $search) : e($cheque->tiers) !!}</td>
                    <td class="px-6 py-4">{{ $cheque->statut }}</td>
                    <td class="px-6 py-4">{{ $cheque->type }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700 italic">
                        {!! $match ? highlightText($cheque->commentaire ?? '', $search) : e($cheque->commentaire ?? '—') !!}
                    </td>
                    <td class="px-6 py-4 flex gap-3">
                        @if($cheque->type === 'entrant')
                            <a href="{{ route('cheques.entrants.edit', $cheque) }}" class="text-blue-600 hover:underline">Modifier</a>
                            <form action="{{ route('cheques.entrants.destroy', $cheque) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Êtes-vous sûr ?')" class="text-red-600 hover:underline">Supprimer</button>
                            </form>
                        @else
                            <a href="{{ route('cheques.sortants.edit', $cheque) }}" class="text-blue-600 hover:underline">Modifier</a>
                            <form action="{{ route('cheques.sortants.destroy', $cheque) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Êtes-vous sûr ?')" class="text-red-600 hover:underline">Supprimer</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="mt-4">
    {{ $cheques->appends(request()->query())->links() }}
</div>

{{-- Fermeture automatique du message flash --}}
<script>
    setTimeout(() => {
        const flash = document.getElementById('flash-message');
        if (flash) flash.remove();
    }, 4000);
</script>

@endsection
