@php
    use App\Models\Notification;
    $latestNotifs = Notification::where('is_read', false)->latest()->take(5)->get();
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des chèques</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Alpine doit être ici -->
</head>
<body class="bg-gray-100">

    <!-- ✅ Barre de navigation -->
    <nav class="bg-blue-600 text-white shadow p-4 flex justify-between items-center">
        <!-- ✅ Partie gauche : Logo et liens -->
        <div class="flex items-center space-x-6">
            <a href="{{ route('dashboard') }}" class="text-xl font-bold">🏦 Gestion des Chèques</a>
            <a href="{{ route('cheques.entrants.index') }}" class="hover:underline">Entrants</a>
            <a href="{{ route('cheques.sortants.index') }}" class="hover:underline">Sortants</a>
        </div>

        <!-- ✅ Partie droite : Notifications, utilisateur et logout -->
        <div class="flex items-center space-x-6" x-data="{ open: false }">
            <!-- 🔔 Cloche -->
            <div class="relative">
                <button @click="open = !open" class="relative focus:outline-none text-white hover:text-gray-200">
                    🔔
                    @if($latestNotifs->count() > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">
                            {{ $latestNotifs->count() }}
                        </span>
                    @endif
                </button>

                <!-- ✅ Dropdown notifications -->
                <div x-show="open" @click.away="open = false"
                     class="absolute right-0 mt-2 w-80 bg-white text-gray-800 border rounded shadow-md z-50 p-4"
                     x-cloak>
                    <h3 class="font-semibold mb-2">📬 Notifications</h3>

                    @if($latestNotifs->count() > 0)
                        <ul class="space-y-2 max-h-64 overflow-y-auto">
                            @foreach($latestNotifs as $notif)
                                <li class="text-sm">
                                    @if($notif->cheque)
                                        <a href="{{ $notif->cheque->type === 'entrant' 
                                                    ? route('cheques.entrants.edit', $notif->cheque) 
                                                    : route('cheques.sortants.edit', $notif->cheque) }}"
                                           class="block hover:bg-gray-100 px-2 py-1 rounded transition">
                                              {{ Str::limit($notif->message, 60) }}
                                            <span class="block text-xs text-gray-500">
                                                {{ $notif->created_at->format('d/m/Y H:i') }}
                                            </span>
                                        </a>
                                    @else
                                        <span class="block italic text-gray-400">Notification sans chèque</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="italic text-sm text-gray-500">Aucune nouvelle notification.</p>
                    @endif

                    <div class="mt-3 text-right">
                        <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="inline-block mr-2">
                            @csrf
                            <button type="submit" class="text-green-600 text-sm hover:underline">
                                ✅ Tout marquer comme lu
                            </button>
                        </form>

                        <a href="{{ route('notifications.index') }}" class="text-blue-500 text-sm hover:underline">
                            🔍 Voir toutes
                        </a>
                    </div>
                </div>
            </div>

            <!-- 👤 User + Logout -->
            @auth
                <span>
                    <a href="{{ route('profile.edit') }}" class="hover:underline">
                        {{ auth()->user()->name }}
                    </a>
                </span>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-300 hover:text-white">🚪Logout</button>
                </form>
            @endauth
        </div>
    </nav>
</body>
</html>
