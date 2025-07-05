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
            static::updateOrCreate(
                ['cheque_id' => $cheque->id, 'type' => 'alerte_entrant'],
                ['message' => 'Chèque entrant à échéance demain (n°' . $cheque->numero . ')', 'is_read' => false]
            );
        }

        $chequesSortants = Cheque::where('type', 'sortant')
            ->whereDate('date_echeance', now())
            ->get();

        foreach ($chequesSortants as $cheque) {
            static::updateOrCreate(
                ['cheque_id' => $cheque->id, 'type' => 'alerte_sortant'],
                ['message' => 'Chèque sortant à échéance aujourd’hui (n°' . $cheque->numero . ')', 'is_read' => false]
            );
        }
    }
}
