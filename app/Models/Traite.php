<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traite extends Model
{
    use HasFactory;

    protected $fillable = [
        'cheque_id',
        'date_impression',
        'fichier_pdf',
    ];

    /**
     * 🔗 Relation : Une traite appartient à un chèque
     */
    public function cheque()
    {
        return $this->belongsTo(Cheque::class);
    }

    /**
     * 🧾 Méthode personnalisée : retourne un nom de fichier PDF clair
     */
    public function genererNomPDF()
    {
        return 'traite_cheque_' . $this->cheque->numero . '.pdf';
    }
}
