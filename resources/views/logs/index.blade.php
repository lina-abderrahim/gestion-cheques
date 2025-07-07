@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Historique des actions</h1>
    <table class="w-full table-auto border">
        <thead>
            <tr>
                <th class="px-4 py-2">Utilisateur</th>
                <th class="px-4 py-2">Action</th>
                <th class="px-4 py-2">Cible</th>
                <th class="px-4 py-2">Détails</th>
                <th class="px-4 py-2">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td class="px-4 py-2">{{ $log->user->name ?? '—' }}</td>
                    <td class="px-4 py-2">{{ $log->action }}</td>
                    <td class="px-4 py-2">{{ $log->cible }}</td>
                    <td class="px-4 py-2 text-xs break-all">{{ $log->details }}</td>
                    <td class="px-4 py-2">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</div>
@endsection
