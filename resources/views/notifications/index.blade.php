@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h2 class="text-xl font-semibold mb-4">Liste des notifications</h2>

    @foreach ($notifications as $notif)
        <div class="border p-3 mb-3 rounded {{ $notif->is_read ? 'bg-gray-100' : 'bg-yellow-100' }}">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-medium">{{ $notif->message }}</p>
                    <small class="text-gray-600">Type : {{ $notif->type }} • {{ $notif->created_at->diffForHumans() }}</small>
                </div>
                <div class="flex gap-2">
                    @if (! $notif->is_read)
                        <form method="POST" action="{{ route('notifications.markAsRead', $notif) }}">
                            @csrf
                            <button class="text-blue-600 text-sm hover:underline">Marquer comme lue</button>
                        </form>
                    @endif
                    <form method="POST" action="{{ route('notifications.destroy', $notif) }}">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 text-sm hover:underline" onclick="return confirm('Supprimer ?')">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
