@extends('layouts.app')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">🔔 Liste des notifications</h2>

    @if($notifications->count())
        <ul class="space-y-4">
            @foreach($notifications as $notification)
                <li class="p-4 border rounded bg-white shadow-sm flex justify-between items-start flex-col md:flex-row md:items-center">
                    <div class="flex-1">
                        {{-- 🔗 Lien vers la fiche du chèque --}}
                        @if($notification->cheque)
                            <a href="{{ $notification->cheque->type === 'entrant' 
                                ? route('cheques.entrants.edit', $notification->cheque) 
                                : route('cheques.sortants.edit', $notification->cheque) }}"
                               class="text-blue-600 hover:underline font-semibold text-lg">
                                📌 {{ $notification->message }}
                            </a>
                        @else
                            <span class="text-gray-500 italic text-lg">{{ $notification->message }}</span>
                        @endif
                        
                        <div class="text-sm text-gray-500 mt-1">
                            Type : <span class="capitalize">{{ str_replace('_', ' ', $notification->type) }}</span> — 
                            Date : {{ $notification->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>

                    {{-- ✅ Boutons d'action --}}
                    <div class="mt-4 md:mt-0 flex gap-3 items-center justify-end md:ml-6">
                        @if(!$notification->is_read)
                            <form action="{{ route('notifications.markAsRead', $notification) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white text-sm px-4 py-2 rounded hover:bg-green-600 transition">
                                    ✔️ Marquer comme lue
                                </button>
                            </form>
                        @else
                            <span class="text-sm text-gray-400">✅ Lue</span>
                        @endif

                        <form action="{{ route('notifications.destroy', $notification) }}" method="POST" onsubmit="return confirm('Supprimer cette notification ?');">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white text-sm px-4 py-2 rounded hover:bg-red-600 transition">
                                🗑 Supprimer
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    @else
        <p class="text-gray-500 italic">Aucune notification pour le moment.</p>
    @endif
</div>
@endsection
