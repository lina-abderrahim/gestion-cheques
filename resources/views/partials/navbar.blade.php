@php
    use App\Models\Notification;
    $latestNotifs = Notification::where('is_read', false)->latest()->take(5)->get();
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des chèques</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <!-- Barre de navigation améliorée -->
    <nav class="bg-blue-600 text-white shadow p-4 flex justify-between items-center">
        <!-- Partie gauche : Logo, titre et menu ⋮ -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('dashboard') }}" class="text-xl font-bold flex items-center">
                🏦 Gestion des Chèques
            </a>
            
            <!-- Bouton trois points -->
            <div class="relative" x-data="{ menuOpen: false }">
                <button @click="menuOpen = !menuOpen" 
                        class="text-white hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
<!-- Menu déroulant -->
<div x-show="menuOpen" @click.away="menuOpen = false"
     class="absolute left-0 mt-2 w-56 bg-white text-gray-800 rounded shadow-md z-50 py-1"
     x-cloak>
    
    <a href="{{ route('cheques.entrants.index') }}" 
       class="block px-4 py-2 hover:bg-gray-100">
        <i class="fas fa-sign-in-alt mr-2"></i> Chèques Entrants
    </a>

    <a href="{{ route('cheques.sortants.index') }}" 
       class="block px-4 py-2 hover:bg-gray-100">
        <i class="fas fa-sign-out-alt mr-2"></i> Chèques Sortants
    </a>

    @if(auth()->user() && auth()->user()->isAdmin())
        <div class="border-t my-1"></div>

        <a href="{{ route('logs.index') }}" 
           class="block px-4 py-2 hover:bg-gray-100">
            <i class="fas fa-history mr-2"></i> Historique
        </a>

        <a href="{{ route('parametres.index') }}" 
           class="block px-4 py-2 hover:bg-gray-100">
            <i class="fas fa-cogs mr-2"></i> Paramètres
        </a>
    @endif
</div>

            </div>
        </div>

        <!-- Partie droite : Notifications et profil -->
        <div class="flex items-center space-x-6" x-data="{ notifOpen: false }">
            <!-- 🔔 Notification -->
            <div class="relative">
                <button @click="notifOpen = !notifOpen" 
                        class="relative focus:outline-none text-white hover:text-gray-200">
                    <i class="fas fa-bell"></i>
                    @if($latestNotifs->count() > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">
                            {{ $latestNotifs->count() }}
                        </span>
                    @endif
                </button>

                <!-- Dropdown notifications -->
                <div x-show="notifOpen" @click.away="notifOpen = false"
                     class="absolute right-0 mt-2 w-80 bg-white border rounded shadow-md z-50 p-4"
                     x-cloak>
                    <h3 class="font-semibold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-bell mr-2"></i> Notifications
                    </h3>

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
                                            <span class="block text-xs text-gray-500 mt-1">
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

                    <div class="mt-3 flex justify-between items-center">
                        <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-green-600 text-sm hover:underline">
                                <i class="fas fa-check mr-1"></i> Tout marquer comme lu
                            </button>
                        </form>
                        <a href="{{ route('notifications.index') }}" class="text-blue-500 text-sm hover:underline">
                            <i class="fas fa-list mr-1"></i> Voir toutes
                        </a>
                    </div>
                </div>
            </div>

            <!-- 👤 User + Logout -->
            @auth
                <div class="flex items-center space-x-4">
                    <a href="{{ route('profile.edit') }}" class="hover:underline flex items-center">
                        <i class="fas fa-user-circle mr-1"></i>
                        {{ auth()->user()->name }}
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-red-300 hover:text-white flex items-center">
                            <i class="fas fa-sign-out-alt mr-1"></i> Déconnexion
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </nav>

   
</body>
</html>