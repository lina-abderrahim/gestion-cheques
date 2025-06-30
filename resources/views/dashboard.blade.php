@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">

    {{-- Boutons d'action --}}
    <div class="flex justify-end gap-4 mb-4">
        <a href="{{ route('cheques.entrants.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded">
            + Nouveau Chèque Entrant
        </a>
        <a href="{{ route('cheques.sortants.create') }}" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded">
            + Nouveau Chèque Sortant
        </a>
    </div>

    {{-- Tableau des chèques --}}
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-300 px-4 py-2">Numéro</th>
                <th class="border border-gray-300 px-4 py-2">Type</th>
                <th class="border border-gray-300 px-4 py-2">Montant</th>
                <th class="border border-gray-300 px-4 py-2">Banque</th>
                <th class="border border-gray-300 px-4 py-2">Tiers</th>
                <th class="border border-gray-300 px-4 py-2">Date création</th>
                <th class="border border-gray-300 px-4 py-2">Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cheques as $cheque)
                <tr class="{{ $cheque->type === 'entrant' ? 'bg-green-100' : 'bg-red-100' }} text-center border border-gray-300">
                    <td class="px-4 py-2">{{ $cheque->numero }}</td>
                    <td class="px-4 py-2 capitalize">{{ $cheque->type }}</td>
                    <td class="px-4 py-2">{{ $cheque->montant }} DT</td>
                    <td class="px-4 py-2">{{ $cheque->banque }}</td>
                    <td class="px-4 py-2">{{ $cheque->tiers }}</td>
                    <td class="px-4 py-2">{{ $cheque->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-2 capitalize">{{ $cheque->statut }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
