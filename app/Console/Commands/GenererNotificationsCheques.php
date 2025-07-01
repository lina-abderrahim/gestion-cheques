<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cheque;
use App\Models\Notification;
use Carbon\Carbon;

class GenererNotificationsCheques extends Command
{
    
    protected $signature = 'app:generer-notifications';

   
    protected $description = 'Génère des notifications pour les chèques entrants (échéance demain) et sortants (échéance aujourd\'hui)';

    public function handle()
    {
        $aujourdhui = Carbon::today();
        $demain = Carbon::tomorrow();

        
        $chequesEntrants = Cheque::where('type', 'entrant')
            ->whereDate('date_echeance', $demain)
            ->get();

        foreach ($chequesEntrants as $cheque) {
      
            $existe = Notification::where('cheque_id', $cheque->id)
                ->where('type', 'alerte_entrant')
                ->whereDate('created_at', $aujourdhui)
                ->exists();

            if (! $existe) {
                Notification::create([
                    'message' => "Échéance proche pour le chèque #{$cheque->numero} (entrant)",
                    'type' => 'alerte_entrant',
                    'cheque_id' => $cheque->id,
                    'is_read' => false,
                ]);
            }
        }

      
        $chequesSortants = Cheque::where('type', 'sortant')
            ->whereDate('date_echeance', $aujourdhui)
            ->get();

        foreach ($chequesSortants as $cheque) {
        
            $existe = Notification::where('cheque_id', $cheque->id)
                ->where('type', 'alerte_sortant')
                ->whereDate('created_at', $aujourdhui)
                ->exists();

            if (! $existe) {
                Notification::create([
                    'message' => "Échéance aujourd'hui pour le chèque #{$cheque->numero} (sortant)",
                    'type' => 'alerte_sortant',
                    'cheque_id' => $cheque->id,
                    'is_read' => false,
                ]);
            }
        }

   
        $this->info('✅ Notifications générées avec succès.');
    }
}