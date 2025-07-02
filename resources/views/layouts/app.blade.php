@php
    use App\Models\Notification;
    $latestNotifs = Notification::where('is_read', false)
        ->latest()
        ->take(5)
        ->get();
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des chèques</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <div>
            <a href="/dashboard" class="text-xl font-bold">Tableau de bord</a>
        </div>
        <div class="flex items-center space-x-6" x-data="{ open: false }">
            <!-- 🔔 Cloche de notification -->
                <div class="relative">
                    <button @click="open = !open" class="relative focus:outline-none text-gray-700 hover:text-blue-600">
                        🔔
                        @if($latestNotifs->count() > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">
                                {{ $latestNotifs->count() }}
                            </span>
                        @endif
                    </button>

                    <!-- Dropdown -->
                    <div x-show="open" @click.away="open = false"
                         class="absolute right-0 mt-2 w-80 bg-white border rounded shadow-md z-50 p-4"
                         x-cloak>
                        <h3 class="font-semibold text-gray-800 mb-2">📬 Notifications</h3>

                        @if($latestNotifs->count() > 0)
                            <ul class="space-y-2 max-h-64 overflow-y-auto">
                                @foreach($latestNotifs as $notif)
                                    <li class="text-sm text-gray-700">
                                        @if($notif->cheque)
                                            <a href="{{ $notif->cheque->type === 'entrant' 
                                                        ? route('cheques.entrants.edit', $notif->cheque) 
                                                        : route('cheques.sortants.edit', $notif->cheque) }}"
                                               class="block hover:bg-gray-100 px-2 py-1 rounded transition">
                                                📌 {{ Str::limit($notif->message, 60) }}
                                                <span class="block text-xs text-gray-400">
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
                            <p class="text-gray-500 italic text-sm">Aucune nouvelle notification.</p>
                        @endif

                        <div class="mt-3 text-right">
                            <a href="{{ route('notifications.index') }}" class="text-blue-500 hover:underline text-sm">
                                🔍 Voir toutes les notifications
                            </a>
                            <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="inline-block mr-2">
    @csrf
    <button type="submit" class="text-green-600 text-sm hover:underline">
        ✅ Marquer tout comme lu
    </button>
</form>

                        </div>
                    </div>
                </div>
            @auth
                <span><a href="/profile">{{ auth()->user()->name }}</a></span>

                <!-- 🔓 Logout -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-500">Logout</button>
                </form>
            @endauth
        </div>
    </nav>

    <main class="p-6">
        @yield('content')
    </main>
</body>
</html>
