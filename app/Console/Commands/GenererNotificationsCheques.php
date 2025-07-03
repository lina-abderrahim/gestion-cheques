<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cheque;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class GenererNotificationsCheques extends Command
{
    protected $signature = 'cheques:generer-notifications';

    protected $description = 'Génère des notifications pour les chèques entrants (échéance demain) et sortants (échéance aujourd\'hui)';

    public function handle()
    {
        $timezone = config('app.timezone');
        $aujourdhui = Carbon::today();
        $demain = Carbon::tomorrow();

        Log::info('🕒 Commande de notification déclenchée à : ' . now());
        Log::info('🌍 Timezone Laravel : ' . $timezone);
        Log::info('📅 Aujourd\'hui : ' . $aujourdhui->toDateString());
        Log::info('📅 Demain : ' . $demain->toDateString());

        // 🔥 Supprimer toutes les notifications dont les chèques ne sont plus valides
        $notificationsInvalides = Notification::whereIn('type', ['alerte_entrant', 'alerte_sortant'])
            ->whereHas('cheque', function ($query) use ($aujourdhui, $demain) {
                $query->where(function ($q) use ($aujourdhui, $demain) {
                    $q->where('type', 'sortant')->whereDate('date_echeance', '!=', $aujourdhui)
                      ->orWhere(function ($q2) use ($demain) {
                          $q2->where('type', 'entrant')->whereDate('date_echeance', '!=', $demain);
                      });
                });
            })
            ->get();

        foreach ($notificationsInvalides as $notif) {
            Log::info("🗑️ Notification supprimée pour chèque #{$notif->cheque->numero} (type: {$notif->type})");
            $notif->delete();
        }

        // ✅ Notifications pour les chèques ENTRANTS (échéance DEMAIN)
        $chequesEntrants = Cheque::where('type', 'entrant')
            ->whereDate('date_echeance', $demain)
            ->get();

        Log::info('📊 Nombre de chèques entrants à notifier : ' . $chequesEntrants->count());

        foreach ($chequesEntrants as $cheque) {
            $existe = Notification::where('cheque_id', $cheque->id)
                ->where('type', 'alerte_entrant')
                ->whereDate('created_at', $aujourdhui)
                ->exists();

            if (! $existe) {
                Notification::create([
                    'message' => "📌 Échéance proche pour le chèque #{$cheque->numero} (entrant)",
                    'type' => 'alerte_entrant',
                    'cheque_id' => $cheque->id,
                    'is_read' => false,
                ]);
                Log::info("✅ Notification créée pour chèque entrant #{$cheque->numero}");
            }
        }

        // ✅ Notifications pour les chèques SORTANTS (échéance AUJOURD’HUI)
        $chequesSortants = Cheque::where('type', 'sortant')
            ->whereDate('date_echeance', $aujourdhui)
            ->get();

        Log::info('📊 Nombre de chèques sortants à notifier : ' . $chequesSortants->count());

        foreach ($chequesSortants as $cheque) {
            $existe = Notification::where('cheque_id', $cheque->id)
                ->where('type', 'alerte_sortant')
                ->whereDate('created_at', $aujourdhui)
                ->exists();

            if (! $existe) {
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
