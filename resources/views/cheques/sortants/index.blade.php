@extends('layouts.app')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">Liste des chèques sortants</h2>

    <a href="{{ route('cheques.sortants.create') }}" class="bg-red-500 text-white px-4 py-2 rounded">+ Ajouter</a>

    <table class="w-full mt-4 border">
        <thead>
            <tr class="bg-gray-200">
                <th>Numéro</th>
                <th>Montant</th>
                <th>Banque</th>
                <th>Tiers</th>
                <th>Échéance</th>
                <th>Statut</th>
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
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
