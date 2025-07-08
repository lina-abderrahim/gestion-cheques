@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des Paramètres</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-3 px-4 text-left text-gray-700 font-medium">Clé</th>
                    <th class="py-3 px-4 text-left text-gray-700 font-medium">Valeur</th>
                    <th class="py-3 px-4 text-left text-gray-700 font-medium">Description</th>
                    <th class="py-3 px-4 text-left text-gray-700 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($parametres as $parametre)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-4 text-gray-600">{{ $parametre->cle }}</td>
                    <td class="py-3 px-4 text-gray-600">{{ $parametre->valeur }}</td>
                    <td class="py-3 px-4 text-gray-600">{{ $parametre->description }}</td>
                    <td class="py-3 px-4">
                        <a href="{{ route('parametres.edit', $parametre) }}" 
                           class="text-blue-600 hover:text-blue-800 mr-3">
                           ✏️ Modifier
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection