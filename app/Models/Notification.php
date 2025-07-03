<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable=['message','type','cheque_id','is_read'];

    public function cheque()
    {
       return $this->belongsTo(cheque::class);
    }

    public static function checkAlertes()
{
    $delaiEntrant = 1;
    $delaiSortant = 0;

    // 🔔 Entrants
    $chequesEntrants = Cheque::where('type', 'entrant')
        ->whereDate('date_echeance', now()->addDays($delaiEntrant))
        ->get();

    foreach ($chequesEntrants as $cheque) {
        $exists = Notification::where('cheque_id', $cheque->id)
            ->whereDate('created_at', now()->toDateString())
            ->exists(); // ❗ne filtre plus par type

        if (!$exists) {
            Notification::create([
                'message' => "Chèque entrant échéance proche (n°{$cheque->numero})",
                'type' => 'alerte_entrant',
                'cheque_id' => $cheque->id,
            ]);
        }
    }

    // 🔔 Sortants
    $chequesSortants = Cheque::where('type', 'sortant')
        ->whereDate('date_echeance', now()->addDays($delaiSortant))
        ->get();

    foreach ($chequesSortants as $cheque) {
        $exists = Notification::where('cheque_id', $cheque->id)
            ->whereDate('created_at', now()->toDateString())
            ->exists(); // ❗pareil ici

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
