<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cheque;
use App\Models\Notification;

// Ensure the Notification model exists in the App\Models namespace
use Carbon\Carbon;

class GenererNotificationsCheques extends Command
{
    protected $signature = 'app:generer-notifications-cheques';
    protected $description = 'Génère des notifications selon les échéances des chèques';

    public function handle()
    {
        $demain = Carbon::tomorrow();
        $aujourdhui = Carbon::today();

        // ✅ Chèques entrants échéance demain
        $chequeEntrant = Cheque::where('type', 'entrant')
            ->whereDate('date_echeance', $demain)
            ->get();

        foreach ($chequeEntrant as $cheque) {
            Notification::create([
                'message' => "Échéance proche pour le chèque #{$cheque->numero} (entrant)",
                'type' => 'alerte_entrant',
                'cheque_id' => $cheque->id,
                'is_read' => false,
            ]);
        }

        // ✅ Chèques sortants échéance aujourd’hui
        $chequesSortants = Cheque::where('type', 'sortant')
            ->whereDate('date_echeance', $aujourdhui)
            ->get();

        foreach ($chequesSortants as $cheque) {
            Notification::create([
                'message' => "Échéance aujourd'hui pour le chèque #{$cheque->numero} (sortant)",
                'type' => 'alerte_sortant',
                'cheque_id' => $cheque->id,
                'is_read' => false,
            ]);
        }

        $this->info('✅ Notifications générées avec succès.');
    }
}
