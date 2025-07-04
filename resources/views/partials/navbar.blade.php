<!-- resources/views/partials/navbar.blade.php -->
<nav class="bg-blue-600 text-white p-4">
    <div class="container mx-auto flex justify-between">
        <a href="{{ route('dashboard') }}" class="font-bold text-lg">🏦 Gestion des Chèques</a>
        <div class="space-x-4">
            <a href="{{ route('cheques.entrants.index') }}">Entrants</a>
            <a href="{{ route('cheques.sortants.index') }}">Sortants</a>
        </div>
    </div>
</nav>
<a href="{{ route('notifications.index') }}" class="relative">
    <i class="fas fa-bell text-white text-xl"></i>
    @if($nbNotifsNonLues > 0)
        <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full px-1">
            {{ $nbNotifsNonLues }}
        </span>
    @endif
</a>
