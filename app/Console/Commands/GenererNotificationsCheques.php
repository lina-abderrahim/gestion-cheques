<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cheque;
use App\Models\Notification;
use Carbon\Carbon;

class GenererNotificationsCheques extends Command
{
    protected $signature = 'notifications:generate';
    protected $description = 'Génère les notifications pour les chèques entrants (échéance demain) et sortants (échéance aujourd’hui)';

    public function handle()
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        // ✅ Chèques entrants : échéance DEMAIN
        $chequesEntrants = Cheque::where('type', 'entrant')
            ->whereDate('date_echeance', $tomorrow)
            ->get();

        foreach ($chequesEntrants as $cheque) {
            Notification::updateOrCreate(
                ['cheque_id' => $cheque->id],
                [
                    'type' => 'alerte_entrant',
                    'message' => 'Chèque entrant à échéance demain (n°' . $cheque->numero . ')',
                    'is_read' => false,
                ]
            );
        }

        // ✅ Chèques sortants : échéance AUJOURD'HUI
        $chequesSortants = Cheque::where('type', 'sortant')
            ->whereDate('date_echeance', $today)
            ->get();

        foreach ($chequesSortants as $cheque) {
            Notification::updateOrCreate(
                ['cheque_id' => $cheque->id],
                [
                    'type' => 'alerte_sortant',
                    'message' => 'Chèque sortant à échéance aujourd\'hui (n°' . $cheque->numero . ')',
                    'is_read' => false,
                ]
            );
        }

        $this->info('✅ Notifications générées avec succès.');
    }
}
