<?php

namespace App\Services;

use App\Models\Cheque;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public static function synchroniser()
    {
        $aujourdhui = Carbon::today();
        $demain = Carbon::tomorrow();

        // 🔁 Suppression des notifications invalides
        $notifications = Notification::whereIn('type', ['alerte_entrant', 'alerte_sortant'])->get();

        foreach ($notifications as $notif) {
            $cheque = $notif->cheque;

            if (!$cheque || $cheque->statut !== 'en_attente') {
                $notif->delete();
                continue;
            }

            if (
                ($notif->type === 'alerte_entrant' && !Carbon::parse($cheque->date_echeance)->isSameDay($demain)) ||
                ($notif->type === 'alerte_sortant' && !Carbon::parse($cheque->date_echeance)->isSameDay($aujourdhui))

            ) {
                $notif->delete();
            }
        }

        // ✅ Création des nouvelles notifications
        $chequesEntrants = Cheque::where('type', 'entrant')
            ->where('statut', 'en_attente')
            ->whereDate('date_echeance', $demain)
            ->get();

        foreach ($chequesEntrants as $cheque) {
            $existe = Notification::where('cheque_id', $cheque->id)
                ->where('type', 'alerte_entrant')
                ->whereDate('created_at', $aujourdhui)
                ->exists();

            if (! $existe) {
                Notification::create([
                    'message' => "📌  Chèque entrant à échéance demain #{$cheque->numero}",
                    'type' => 'alerte_entrant',
                    'cheque_id' => $cheque->id,
                    'is_read' => false,
                ]);
            }
        }

        $chequesSortants = Cheque::where('type', 'sortant')
            ->where('statut', 'en_attente')
            ->whereDate('date_echeance', $aujourdhui)
            ->get();

        foreach ($chequesSortants as $cheque) {
            $existe = Notification::where('cheque_id', $cheque->id)
                ->where('type', 'alerte_sortant')
                ->whereDate('created_at', $aujourdhui)
                ->exists();

            if (! $existe) {
                Notification::create([
                    'message' => "📌  Chèque sortant à échéance aujourd'hui #{$cheque->numero}",
                    'type' => 'alerte_sortant',
                    'cheque_id' => $cheque->id,
                    'is_read' => false,
                ]);
            }
        }
    }
}
