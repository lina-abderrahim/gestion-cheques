<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'cheque_id',
        'type',
        'message',
        'is_read',
    ];

    public function cheque()
    {
        return $this->belongsTo(Cheque::class);
    }

    public static function checkAlertes()
    {
        $date = now()->toDateString();

        $chequesEntrants = Cheque::where('type', 'entrant')
            ->whereDate('date_echeance', now()->addDay())
            ->get();

    foreach ($chequesEntrants as $cheque) {
        $exists = Notification::where('cheque_id', $cheque->id)
            ->whereDate('created_at', now()->toDateString())
            ->exists();

        if (!$exists) {
            Notification::create([
                'message' => "Chèque entrant à échéance demain (n°{$cheque->numero})",
                'type' => 'alerte_entrant',
                'cheque_id' => $cheque->id,
            ]);
        }
    }

    // 🔔 Sortants
    $delaiSortant = 0; // Définir ici le délai souhaité en jours (par exemple 0 pour aujourd'hui)
    $chequesSortants = Cheque::where('type', 'sortant')
        ->whereDate('date_echeance', now()->addDays($delaiSortant))
        ->get();

    foreach ($chequesSortants as $cheque) {
        $exists = Notification::where('cheque_id', $cheque->id)
            ->whereDate('created_at', now()->toDateString())
            ->exists();

        if (!$exists) {
            Notification::create([
                'message' => "Chèque sortant à échéance aujourd'hui (n°{$cheque->numero})",
                'type' => 'alerte_sortant',
                'cheque_id' => $cheque->id,
            ]);
        }
    }
}

}
