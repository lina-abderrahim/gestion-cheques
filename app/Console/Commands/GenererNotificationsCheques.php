<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cheque;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class GenererNotificationsCheques extends Command
{
    // Nom de la commande
    protected $signature = 'cheques:generer-notifications';

    // Description visible dans `php artisan list`
    protected $description = 'Génère des notifications pour les chèques entrants (échéance demain) et sortants (échéance aujourd\'hui)';

    public function handle()
    {
        $timezone = config('app.timezone');
        $aujourdhui = Carbon::today();
        $demain = Carbon::tomorrow();

        // Log d'exécution
        Log::info('🕒 Commande de notification déclenchée à : ' . now());
        Log::info('🌍 Timezone Laravel : ' . $timezone);
        Log::info('📅 Aujourd\'hui : ' . $aujourdhui->toDateString());
        Log::info('📅 Demain : ' . $demain->toDateString());

        // === Notifications pour chèques ENTRANTS (échéance DEMAIN) ===
        $chequesEntrants = Cheque::where('type', 'entrant')
            ->whereDate('date_echeance', $demain)
            ->get();

        Log::info('📊 Nombre de chèques entrants à notifier : ' . $chequesEntrants->count());

        foreach ($chequesEntrants as $cheque) {
            $existe = Notification::where('cheque_id', $cheque->id)
                ->where('type', 'alerte_entrant')
                ->whereDate('created_at', $aujourdhui)
                ->exists();

            if (!$existe) {
                Notification::create([
                    'message' => "📌 Échéance proche pour le chèque #{$cheque->numero} (entrant)",
                    'type' => 'alerte_entrant',
                    'cheque_id' => $cheque->id,
                    'is_read' => false,
                ]);

                Log::info("✅ Notification créée pour chèque entrant #{$cheque->numero}");
            }
        }

        // === Notifications pour chèques SORTANTS (échéance AUJOURD’HUI) ===
        $chequesSortants = Cheque::where('type', 'sortant')
            ->whereDate('date_echeance', $aujourdhui)
            ->get();

        Log::info('📊 Nombre de chèques sortants à notifier : ' . $chequesSortants->count());

        foreach ($chequesSortants as $cheque) {
            $existe = Notification::where('cheque_id', $cheque->id)
                ->where('type', 'alerte_sortant')
                ->whereDate('created_at', $aujourdhui)
                ->exists();

            if (!$existe) {
                Notification::create([
                    'message' => "📌 Échéance aujourd'hui pour le chèque #{$cheque->numero} (sortant)",
                    'type' => 'alerte_sortant',
                    'cheque_id' => $cheque->id,
                    'is_read' => false,
                ]);

                Log::info("✅ Notification créée pour chèque sortant #{$cheque->numero}");
            }
        }

        $this->info('✅ Notifications générées avec succès.');
    }
}
